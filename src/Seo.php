<?php

namespace Travelience\Seo;

use Travelience\Seo\Meta;
use Route;

class Seo
{
    
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
     * Set SEO meta in session to use later in the render
     *
     * @param String $key
     * @param String $value
     * @return String
     */
    public function meta( $key, $value )
    {
        return session()->put( $this->key . '.meta.' . $key, $value );
    }

    /**
     * Validate if the meta already exists in the session
     *
     * @param String $key
     * @return String
     */
    public function hasMeta( $key )
    {
        return session()->get( $this->key . '.meta.' . $key );
    }
    
    /**
     * Get all the metas in the session
     *
     * @return Array
     */
    public function getMeta()
    {
        return session()->get( $this->key . '.meta' );
    }

    /**
     * Set microformat in the session
     *
     * @param String $key
     * @param Array $data
     * @return String
     */
    public function microformat( $key, $data )
    {

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


}