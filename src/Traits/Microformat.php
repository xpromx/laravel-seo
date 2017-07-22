<?php

namespace Travelience\Seo\Traits;

trait Microformat
{

    /**
     * Set SEO microformat in session to use later in the render
     *
     * @param String $key
     * @param String $value
     * @return String
     */
    public function microformat( $key, $value )
    {

        $params = ['@context' => 'http://schema.org/', '@type' => $key];
        $value = array_merge( $params, $value );

        return session()->put( $this->key . '.microformat.'. $key, $value );
    }

    /**
     * Validate if the meta already exists in the session
     *
     * @param String $key
     * @return String
     */
    public function hasMicroformat( $key )
    {
        return session()->get( $this->key . '.microformat.' . $key );
    }
    
    /**
     * Get all the metas in the session
     *
     * @return Array
     */
    public function getMicroformats()
    {
        return session()->get( $this->key . '.microformat' );
    }


    /**
     * Get a specific meta
     *
     * @return Array
     */
    public function getMicroformat( $key )
    {
        return session()->get( $this->key . '.microformat.'. $key );
    }

}

?>