<?php


namespace Travelience\Seo\Traits;

use Travelience\Seo\Seo as _Seo;

trait Seo
{
    public function seo()
    {
        return new _Seo();
    }
}