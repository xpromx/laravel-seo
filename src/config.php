<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Multi-Language SEO
    |--------------------------------------------------------------------------
    |
    | Allow multi-language SEO in this project
    |
    */
    'localization' => true,


    /*
    |--------------------------------------------------------------------------
    | Default Tags
    |--------------------------------------------------------------------------
    |
    | This options are the defaults for title, keywords and description.
    | are going to be used if you forget to set one of them for a specific page
    |
    */
    'title' => env('APP_NAME'),
    'description' => 'Welcome to '. env('APP_NAME'),
    'keywords' => env('APP_NAME'),

    
    /*
    |--------------------------------------------------------------------------
    | Default Meta tags
    |--------------------------------------------------------------------------
    |
    | This options are the defaults meta-tags that are going to be included
    | in every tag where the SEO meta is called
    |
    */
    'meta' => [

            	// Facebook

                'og:type'       => 'web',
                'og:title'      => env('APP_NAME'),
                'og:site_name'  => env('APP_NAME'),
                'og:image'      => env('SITE_URL') . '/img/facebook-banner.jpg',

                // Facebook App

                //'fb:app_id' => '',
                
                // Twitter
                
                // 'twitter:card' => 'summary_large_image',
                // 'twitter:site' => '@planetyze',
                // 'twitter:creator' => '@planetyze',
                // 'twitter:title' => '#title#',
                // 'twitter:description' => '#description#',
                // 'twitter:image' => '#image#',
                // 'twitter:domain' => 'planetyze.com',
                

                // Google+

                // 'link:author' => 'https://plus.google.com/+' . env('SITE_NAME'),

                // Itunes

                // 'apple-itunes-app' => 'app-id=1026542774',

    ],


];