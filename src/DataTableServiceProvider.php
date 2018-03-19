<?php

namespace SagarYonjan\VueDatatable;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use SagarYonjan\VueDatatable\Helpers\Router;

class DataTableServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register
     */
    public function register()
    {
        $this->app->singleton('datable', function () {
            return $this->app->make('SagarYonjan\VueDatatable\DataTable');
        });

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../resources/assets/js/components' => resource_path('assets/js/components/datatable'),
            ], 'vue-datatable');

            $this->commands([
                Console\CreateDataTableController::class,
            ]);
        }

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function ($router) {

                if(file_exists(base_path('routes/datatable.php'))) {

                   require base_path('routes/datatable.php');

                } else {

                   $this->dynamicRoute();

                }

            });

    }

    /**
     * Generate Dynamic Routes
     */
    public function dynamicRoute()
    {
        $custom_router = new Router();

        if(count($custom_router->getRoutes()) > 0) {

            foreach ($custom_router->getRoutes() as $controller => $route)
            {
                app('datable')->route($route, $controller);
            }

        }
    }

}
