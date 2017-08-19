<?php

namespace Travelience\Seo;

use Travelience\Seo\Meta;
use Travelience\Seo\Traits\Meta as hasMeta;
use Travelience\Seo\Microformat;
use Travelience\Seo\Traits\Microformat as hasMicroformat;

use Route;

class Seo
{
    
    use hasMeta;
    use hasMicroformat;

    public $key = 'laravel_seo';


    public function __construct()
    {

    }

    /**
     * Set SEO data in session to use later in the render
     *
     * @param String $key
     * @param String $value
     * @return String
     */
    public function set( $key, $value )
    {
        return session()->put( $this->key . '.data.' . $key, $value );
    }

    /**
     * Get SEO data from the session
     *
     * @param String $key
     * @return String
     */
    public function get( $key )
    {
        return session()->get( $this->key . '.data.' . $key );
    }

    /**
     * get all the data from the session
     *
     * @return Array
     */
    public function getData()
    {
        return session()->get( $this->key . '.data' );
    }


    /**
     * Clean all the session for the SEO
     *
     * @return Boolean
     */
    public function flush()
    {
        return session()->forget( $this->key );
    }

    /**
     * Render all the SEO tags, title and meta
     *
     * @return String
     */
    public function render()
    {
        $meta = new Meta( $this );
        $html = $meta->render();

        $microformat = new Microformat( $this );
        $html .= $microformat->render();

        $this->flush();

        return $html;
    }

    /**
     * Get the name of the current route
     *
     * @return String
     */
    public function current_route()
    {
        $route =  Route::currentRouteName() ?? 'default';
        return str_replace( '.', '_', $route );
    }


    /**
     * Get the current url
     *
     * @return String
     */
    public function current_url()
    {
       $url = config('app.url') . request()->server('REQUEST_URI');
       return $this->clearUrl( $url );
    }

    /**
     * Get the current base url without language
     *
     * @return String
     */
    public function current_base_url()
    {
        $url = $this->current_url();

        foreach( config('seo.locales') as $lang )
        {
            if( request()->segment(2) == $lang )
            {
                $segments = request()->segments();
                unset($segments[2]);
                return implode('/', $segments);
            }
        }

        return $url;
    }


    /**
     * Clear the url without any parameter
     *
     * @return String
     */
    public static function clearUrl( $url )
    {
        if( str_contains($url,'?') )
        {
            $data = explode('?', $url);
            $url  = $data[0];
        }

        if( substr($url, -1) == '/')
        {
            return substr($url, 0, -1);
        }

        return $url;
    }


    /**
     * Make the place-holder replacements on a line.
     *
     * @param  string  $line
     * @param  array   $replace
     * @return string
     */
    public function makeReplacements($line, $replace = null)
    {

        $replace = $replace ?? $this->getData();

        if( count($replace) == 0 )
        {
            return $line;
        }

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