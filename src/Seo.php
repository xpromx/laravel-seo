<?php

namespace Travelience\Seo;

use Travelience\Seo\Meta;
use Route;

class Seo
{
    
    public $key = 'laravel_seo';
    public $data = [];

    public function __construct()
    {

    }

    public function set( $key, $value )
    {
        return session()->put( $this->key . '.data.' . $key, $value );
    }

    public function get( $key )
    {
        return session()->get( $this->key . '.data.' . $key );
    }

    public function getData()
    {
        return session()->get( $this->key . '.data' );
    }

    public function meta( $key, $value )
    {
        return session()->put( $this->key . '.meta.' . $key, $value );
    }

    public function hasMeta( $key )
    {
        return session()->get( $this->key . '.meta.' . $key );
    }
    
    public function getMeta()
    {
        return session()->get( $this->key . '.meta' );
    }

    public function microformat( $key, $data )
    {

    }

    public function flush()
    {
        session()->forget( $this->key );
    }

    public function render()
    {
        $meta = new Meta( $this );
        $html = $meta->render();

        $this->flush();

        return $html;
    }

    public function current_route()
    {
        $route =  Route::currentRouteName() ?? 'default';
        return str_replace( '.', '_', $route );
    }


}