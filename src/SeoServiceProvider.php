<?php

namespace Travelience\Seo;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Travelience\Seo\Seo;



class SeoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('seo.php'),
        ]);        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
       $this->app->singleton('seo', function () {

            return new Seo();

       });

       $this->app->alias('seo', Seo::class);


       $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {

            $namespaces = ['SEO' => get_class_methods(Seo::class)];

            foreach ($namespaces as $namespace => $methods) {

                foreach ($methods as $method) {

                    $snakeMethod = snake_case($method);
                    $directive = strtolower($namespace).'_'.$snakeMethod;

                    $bladeCompiler->directive($directive, function ($expression) use ($namespace, $method) {
                        return "<?php echo $namespace::$method($expression); ?>";
                    });
                    
                }

            }

        });
    }


    

}
