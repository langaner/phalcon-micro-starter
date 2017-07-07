<?php

namespace App\Providers;

use Phalcon\DI\FactoryDefault;
use App\Providers\AbstractAppProvider;
use App\Repositories\UserRepository;
use App\Presenters\UserPresenter;
use App\Services\UserService;
use App\Models\User as UserModel;

class AppProvider extends AbstractAppProvider
{
    /**
     * @var DiInterface
     */
    protected $di;
    
    public function __construct(FactoryDefault $di)
    {
        $this->di = $di;
    }
    
    /**
     * All repositories bindings
     *
     * @return void
     */
    public function repositories() 
    {
        $this->bindRepository('userRepository', UserRepository::class, [new UserModel]);
    }

    /**
     * All services bindings
     *
     * @return void
     */
    public function services() 
    {
        $this->bindService('userService', UserService::class, [$this->getDi()->get('userRepository')]);
    }

    /**
     * All presenters bindings
     *
     * @return void
     */
    public function presenters() 
    {
        $this->bindRepository('userPresenter', UserPresenter::class, [new UserModel]);
    }
}