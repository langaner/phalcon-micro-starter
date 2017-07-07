<?php

namespace App\Providers;

use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

abstract class AbstractAppProvider implements InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * Setter for DI
     *
     * @param DiInterface $di
     * @return void
     */
    public function setDi(DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * Getter for DI
     *
     * @return void
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Bind method
     *
     * @param string $name
     * @param mixed $class
     * @return void
     */
    public function bind($name, $class)
    {
        $this->getDi()->set($name, $class);
    }

    /**
     * Bind repository. If debag is true then returnet decorated repository
     *
     * @param string $name
     * @param string $repository
     * @param array $params
     * @return void
     */
    public function bindRepository($name, $repository, array $params = [])
    {
        $useCache = $this->getDI()->get('config')->app->debug;
        $decorator = str_replace('Repository', 'Decorator', $repository);
        $clasName = substr(strrchr($decorator, "\\"), 1);
        $decorator = str_replace($clasName, 'Decorator\\' . $clasName, $decorator);
        
        $this->bind($name, function() use($useCache, $decorator, $repository, $params) {
            $repository = new $repository(...$params);

            if (!$useCache) {
                return $repository;
            }

            $decorator = new $decorator;
            
            return $decorator->setRepository($repository);
        });
    }

    /**
     * Bind service
     *
     * @param string $name
     * @param string $repository
     * @param array $params
     * @return void
     */
    public function bindService($name, $service, array $params = [])
    {
        $this->bind($name, function() use($service, $params) {
            return new $service(...$params);
        });
    }

    /**
     * Register services related to module
     *
     * @return void
     */
    public function registerServices()
    {
        $this->repositories();
        $this->services();
        $this->presenters();
    }

    /**
     * All repositories bindings
     *
     * @return void
     */
    public function repositories() 
    {
        
    }

    /**
     * All services bindings
     *
     * @return void
     */
    public function services() 
    {
        
    }

    /**
     * All presenters bindings
     *
     * @return void
     */
    public function presenters() 
    {
        
    }
}