<?php

namespace Travelience\Seo;

class Microformat
{
    
    public $seo  = false;


    public function __construct( $seo )
    {
        $this->seo = $seo;
    }

/**
     * render all the metas
     *
     * @return String
     */
    public function render()
    {

        if( !$microformats = $this->seo->getMicroformats() )
        {
            return '';
        }

        $html[] = "\n";
        $html[] = '<script type="application/ld+json">';

        foreach( $microformats as $key=>$value )
        {
            $html[] = $this->renderMicroformat( $key, $value );
        }

        $html[] = '</script>';
        return implode("\n", $html);
    }

    /**
     * Render and individual Microformat
     *
     * @return String
     */
    public function renderMicroformat( $key, $value )
    {
        
        // 2 levels deep
        foreach( $value as $k => $v )
        {
            if( is_array($v) )
            {
                foreach( $v as $_k => $_v )
                {
                    $value[$k][$_k] = $this->seo->makeReplacements( $_v );
                }

                continue;
            }

            $value[$k] = $this->seo->makeReplacements( $v );
        }

        $json = json_encode( $value, JSON_PRETTY_PRINT );
        $json = str_replace('\/','/', $json);
        return $json;
        
    }


}