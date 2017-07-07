<?php

namespace App\Providers;

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

use App\Middleware\NotFoundMiddleware;
use App\Middleware\RedirectMiddleware;
use App\Middleware\FirewallMiddleware;
use App\Middleware\CORSMiddleware;
use App\Middleware\RequestMiddleware;
use App\Middleware\ResponseMiddleware;
use App\Middleware\AuthMiddleware;

class MiddlewareProvider
{
    /**
     * @var Phalcon\Mvc\Micro
     */
    protected $app;
    
    /**
     * @var Phalcon\Mvc\Micro\Collection 
     */
    protected $moddleware = [
        'NotFoundMiddleware' => [
            'class' => NotFoundMiddleware::class,
            'trigger' => 'before'
        ],
        'RedirectMiddleware' => [
            'class' => RedirectMiddleware::class,
            'trigger' => 'before'
        ],
        'FirewallMiddleware' => [
            'class' => FirewallMiddleware::class,
            'trigger' => 'before'
        ],
        'CORSMiddleware' => [
            'class' => CORSMiddleware::class,
            'trigger' => 'before'
        ],
        'RequestMiddleware' => [
            'class' => RequestMiddleware::class,
            'trigger' => 'before'
        ],
        'ResponseMiddleware' => [
            'class' => ResponseMiddleware::class,
            'trigger' => 'after'
        ],
        'AuthMiddleware' => [
            'class' => AuthMiddleware::class,
            'trigger' => 'before'
        ]
    ];

    public function __construct(Micro $app)
    {
        $this->app = $app;
    }
    
    public function load() 
    {
        $eventsManager = new Manager();
        
        foreach ($this->moddleware as $key => $value) {
            $class = new $value['class'];
            $eventsManager->attach('micro', $class);
            $this->app->{$value['trigger']}($class);
        }
        
        $this->app->setEventsManager($eventsManager);

        return $this->app;
    }
}