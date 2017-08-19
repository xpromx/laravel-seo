<?php

namespace Travelience\Seo;

class Meta
{
    
    public $seo  = false;


    /**
     * Construct of the Meta Class
     *
     * @param Seo $seo
     * @return Void
     */

    public function __construct( $seo )
    {
        $this->seo = $seo;

        $this->siteName();
        $this->title();
        $this->description();
        $this->keywords();
        $this->defaults();
        $this->localization();

    }

    /**
     * Set all the multi-language url available
     *
     * @return Void
     */
    public function localization()
    {
        if( !config('seo.localization') )
        {
            return false;
        }
        
        $current_url = $this->seo->current_base_url();

        // default url
        $alternate = str_replace( config('app.url'), config('app.url') . '/' . config('app.locale'), $current_url );
        $this->seo->meta('link:alternate',  ['hreflang' => 'x-default', 'href' => $alternate], true);

        foreach( config('seo.locales') as $lang )
        {
            $alternate = str_replace( config('app.url'), config('app.url') . '/' . $lang, $current_url );
            $this->seo->meta('link:alternate',  ['hreflang' => $lang, 'href' => $alternate], true);
        }

    }

    /**
     * Set all the default meta in the config file
     *
     * @return Void
     */
    public function defaults()
    {

        // variables
        $this->seo->set('title'        , $this->seo->getMeta('title'));
        $this->seo->set('description'  , $this->seo->getMeta('description'));
        $this->seo->set('keywords'     , $this->seo->getMeta('keywords'));
        $this->seo->set('url'          , $this->seo->current_url());

        // metas
        foreach( config('seo.meta') as $key=>$value )
        {
            if( !$this->seo->hasMeta($key) )
            {
                $this->seo->meta($key, $value);
            }
        }
    }

    /**
     * Get translation for the meta if exits
     *
     * @param String $key
     * @return String
     */
    public function trans( $key, $default=true )
    {
        $lang_key = 'seo.' . $this->seo->current_route() . '.' . $key;
        $data = $this->seo->getData() ?? [];

        if( !app('translator')->has($lang_key))
        {
            if( !$default )
            {
                return false;
            }

            return $this->seo->makeReplacements( config('seo.' . $key ) );
        }

        return __( $lang_key , $data );
    }
    
    /**
     * Set the Title tag by default
     *
     * @return Void
     */
    public function title()
    {
        $separator = ' ' . config('seo.separator') .' ' . $this->seo->get('site_name');

        $title = $this->seo->getMeta('title');

        if( !$title )
        {
           $title = $this->trans('title', false);
        }

        if( !$title )
        {
            $title = title_case( $this->seo->current_route() );
        }

        return $this->seo->meta('title', $title . $separator);
        
    }

    /**
     * Set the Description meta by default
     *
     * @return Void
     */
    public function description()
    {
        
        if( !$this->seo->hasMeta('description') )
        {
            $this->seo->meta('description', $this->trans('description'));
        }

    }

    /**
     * Set the Keywords meta by default
     *
     * @return Void
     */
    public function keywords()
    {
        
        if( !$this->seo->hasMeta('keywords') )
        {
            $this->seo->meta('keywords', $this->trans('keywords'));
        }

    }

    /**
     * Set the site name
     *
     * @return Void
     */
    public function siteName()
    {
        
        if( !$this->seo->get('site_name') )
        {
            $this->seo->set('site_name', $this->trans('site_name') ?? config('seo.site_name'));
        }

    }

    /**
     * render all the metas
     *
     * @return String
     */
    public function render()
    {
        $meta[] = "\n";

        foreach( $this->seo->getMetas() as $key=>$value )
        {
            
            $meta[] = $this->renderMeta( $key, $value );
        }

        return implode("\n", $meta);
    }

    /**
     * Render and individual Meta
     *
     * @return String
     */
    public function renderMeta( $key, $value )
    {

        $value = $this->seo->makeReplacements( $value );

        // is multidimentional array loop to process
        if( is_array($value) && is_array( array_first($value) ) )
        {
            $meta[] = "\n";

            foreach( $value as $item )
            {
                $meta[] = $this->renderMeta( $key, $item );
            }

            return implode("\n", $meta);
        }

        // title tag
        if( $key == 'title'  )
        {
            return "<title>$value</title>";
        }

        // og tag
        if( str_contains($key, 'og:')  )
        {
            return "<meta property='$key' content='$value'>";
        }

        // array values tag
        if( is_array( $value ) )
        {
            $params = [];

            foreach( $value as $k => $v )
            {
                $params[] = "$k='$v'";
            }

            $params = implode(' ', $params);

            return "<meta name='$key' $params>";

        }


        // default meta
        return "<meta name='$key' content='$value'>";

    }


}