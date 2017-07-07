<?php

namespace App\Providers;

use Phalcon\Mvc\Micro;

use App\Controllers\HomeController;

class RouteProvider
{
    /**
     * @var Phalcon\Mvc\Micro
     */
    protected $app;
    
    /**
     * @var Phalcon\Mvc\Micro\Collection 
     */
    protected $collection;

    public function __construct(Micro $app)
    {
        $this->app = $app;
    }
    
    public function load() 
    {
        $this->app = $this->map();

        return $this->app;
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        return $this->mapRoutes();
    }

    public function mapRoutes()
    {
        return require_once app_path('routes/routes.php');
    }
}