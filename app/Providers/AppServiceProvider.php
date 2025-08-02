<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
    {
        // Register admin middleware alias
        $this->app['router']->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
        
        // Set default pagination view for AdminLTE theme
        Paginator::defaultView('pagination::adminlte');
        Paginator::defaultSimpleView('pagination::simple-adminlte');
    }
}
