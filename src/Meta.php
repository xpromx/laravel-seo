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

        $this->title();
        $this->description();
        $this->keywords();
        $this->defaults();

    }


    /**
     * Set all the default meta in the config file
     *
     * @return Void
     */
    public function defaults()
    {
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
    public function trans( $key )
    {
        $lang_key = 'seo.' . $this->seo->current_route() . '.' . $key;
        $data = $this->seo->getData() ?? [];
        if( !app('translator')->has($lang_key) )
        {
            return $this->makeReplacements( config('seo.' . $key ), $data );
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
        if( !$this->seo->hasMeta('title') )
        {
            $this->seo->meta('title', $this->trans('title'));
        }
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
     * render all the metas
     *
     * @return String
     */
    public function render()
    {
        $meta[] = "\n";

        foreach( $this->seo->getMeta() as $key=>$value )
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

        if( $key == 'title'  )
        {
            return "<title>$value</title>";
        }

        if( str_contains($key, 'og:')  )
        {
            return "<meta property='$key' content='$value'>";
        }

        return "<meta name='$key' content='$value'>";

    }


    /**
     * Make the place-holder replacements on a line.
     *
     * @param  string  $line
     * @param  array   $replace
     * @return string
     */
    public function makeReplacements($line, array $replace)
    {

        foreach ($replace as $key => $value) {
            $line = str_replace(
                [':'.$key, ':'.strtoupper($key), ':'.ucfirst($key)],
                [$value, strtoupper($value), ucfirst($value)],
                $line
            );
        }

        return $line;
    }


}