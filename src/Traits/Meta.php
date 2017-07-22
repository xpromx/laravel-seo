<?php

namespace Travelience\Seo\Traits;

trait Meta
{

    /**
     * Set SEO meta in session to use later in the render
     *
     * @param String $key
     * @param String $value
     * @param Boolean $push
     * @return String
     */
    public function meta( $key, $value, $push=false )
    {
        if( $push )
        {
           return session()->push( $this->key . '.meta.'. $key, $value );
        }

        return session()->put( $this->key . '.meta.'. $key, $value );
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
    public function getMetas()
    {
        return session()->get( $this->key . '.meta' );
    }

    /**
     * Get a specific meta
     *
     * @return Array
     */
    public function getMeta( $key )
    {
        return session()->get( $this->key . '.meta.'. $key );
    }

}

?>