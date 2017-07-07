<?php 

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use App\Controllers\HomeController;

$collection = new MicroCollection();

$collection->setHandler(HomeController::class, true);

$collection->setPrefix('/');

$collection->get('/', 'index');
$collection->get('test', 'test');

$this->app->mount($collection);