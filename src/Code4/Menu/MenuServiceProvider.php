<?php namespace Code4\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('code4/menu');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['config']->package('code4/menu', __DIR__.'/../config');

        $this->app['menu'] = $this->app->share(function($app)
        {
            return new Menu($app['config']);
        });

        $autoLoader = \Illuminate\Foundation\AliasLoader::getInstance();
        $autoLoader->alias('Menu', 'Code4\Menu\Facades\Menu');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('menu');
	}
}