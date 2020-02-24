<?php

namespace Modules\Shop\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class ShopServiceProvider extends ServiceProvider {
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot() {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Shop', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig() {
        $this->publishes([
            module_path('Shop', 'Config/config.php') => config_path('shop.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Shop', 'Config/config.php'), 'shop'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews() {
        $viewsPath = resource_path('views/modules/shop');

        if (!is_dir($viewsPath)) {
            $viewsPath = module_path('Shop', \Config::get('modules.paths.generator.views.path'));
        }

        $this->publishes([$viewsPath], 'views');
        $this->loadViewsFrom($viewsPath, 'shop');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations() {
        $langPath = resource_path('lang/modules/shop');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'shop');
        } else {
            $this->loadTranslationsFrom(module_path('Shop', 'Resources/lang'), 'shop');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories() {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Shop', 'Database/Factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }
}
