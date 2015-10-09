<?php

namespace Code4\Menu;

use App\Components\Menu\MenuFactory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->singleton('menu', function($app) {
            return new Menu($app['files'], $app['config'], $app['url']);
        });

        $this->registerAliases();
    }

    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/menu.php' => base_path('config/menu.php')], 'config');
        $this->loadViewsFrom(__DIR__ . '/../views', 'menu');
    }


    private function registerAliases() {
        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Assets', Facades\Menu::class);
    }

}