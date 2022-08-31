<?php

namespace Mkinyua53\MixPreload;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MixPreloadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('preload', function ($expression) {
            return "<?php echo \Mkinyua53\MixPreload\RenderPreloadLinks::create($expression)(); ?>";
        });

        $this->publishes([
            __DIR__ . '/../config/preloader.php' => config_path('preloader.php'),
        ], 'preloader-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/preloader.php',
            'preloader'
        );
    }
}
