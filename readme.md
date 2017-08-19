# Installation


### Service Provider
Add the service provider in config/app.php

```
Travelience\Seo\SeoServiceProvider::class,
```

### Alias
Add the SEO alias in config/app.php

```
'SEO' => Travelience\Seo\Facades\Seo::class,`
```

### Config Files
In order to edit the default configuration for this package you may execute:

```
php artisan vendor:publish
```

### Translation Files for routes
If you support multi-language you can use the lang folder creating a file seo.php for each language to automatically translate the SEO meta for each language.

The key is the route name for example in routes/web.php
```php
Route::get('/'  	             , ['as' => 'home', 'uses' => 'Web\HomeController@index']);
Route::get('/about'            , ['as' => 'about', 'uses' => 'Web\AboutController@index']);
Route::get('/company/reviews'  , ['as' => 'company.reviews', 'uses' => 'Web\CompanyController@reviews']);
```

The translation file for the previous routes will be:

```php
<?php

return [

  'home' => [
                'title' => 'Home',
                'description' => '',
                'keywords' => '',
            ],

  'about' => [
                'title' => 'About'
            ],

  'company_reviews' => [
                'title' => 'Company Reviews'
            ],

];

```

### Translations variables
Set variables to be replaced in translations automatically.

```php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Travelience\Seo\Seo;

class HomeController extends Controller
{

    public function index()
    {
        SEO::set('product', 'Product Name');
        
        return view('home');
    }

}

```

### MetaTags
Defaults metatags are in the config/seo.php file, but if you need to add one meta to a specific page, use the follow method:

```php
SEO::meta('name', 'value');
```

### MicroFormats
If you need to set a microformat, check this example:

```php
SEO::microformat('TouristAttraction', [

  'name'            => 'Asakusa', 
  'description'     => ':description', 
  'aggregateRating' => [

    '@type'       => 'AggregateRating', 
    'ratingValue' => '5.0' 

  ]

]);
````


