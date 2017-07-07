<?php 

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use App\Controllers\AuthController;

$collection = new MicroCollection();

$collection->setHandler(AuthController::class, true);

$collection->setPrefix('/auth/');

$collection->get('login', 'login');
$collection->get('refresh', 'refresh');

$this->app->mount($collection);