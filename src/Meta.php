<?php

namespace Travelience\Seo;

class Meta
{
    
    public $seo  = false;


    public function __construct( $seo )
    {
        $this->seo = $seo;

        $this->title();
        $this->description();
        $this->keywords();
        $this->defaults();

    }


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

    public function trans( $key, $default=false )
    {
        $lang_key = 'seo.' . $this->seo->current_route() . '.' . $key;
        $data = $this->seo->getData() ?? [];
        if( !app('translator')->has($lang_key) )
        {
            return $this->makeReplacements( config('seo.' . $key ), $data );
        }

        return __( $lang_key , $data );
    }
    
    public function title()
    {
        if( !$this->seo->hasMeta('title') )
        {
            $this->seo->meta('title', $this->trans('title'));
        }
    }

    public function description()
    {
        
        if( !$this->seo->hasMeta('description') )
        {
            $this->seo->meta('description', $this->trans('description'));
        }

    }


    public function keywords()
    {
        
        if( !$this->seo->hasMeta('keywords') )
        {
            $this->seo->meta('keywords', $this->trans('keywords'));
        }

    }

    public function render()
    {
        $meta[] = "\n";

        foreach( $this->seo->getMeta() as $key=>$value )
        {
            $meta[] = $this->renderMeta( $key, $value );
        }

        return implode("\n", $meta);
    }

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