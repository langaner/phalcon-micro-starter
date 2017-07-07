<?php

namespace App\Middleware;

use \DomainException;
use Phalcon\Di;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use App\Auth\Auth;
use Firebase\JWT\InvalidArgumentException;
use Firebase\JWT\UnexpectedValueException;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var Micro
     */
    private $application;

    /**
     * Before anything happens
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        $jwt = new Auth;
        $this->application = $application;
        $config = Di::getDefault()->get('config');

        $url = $this->application->request->getURI();
        $headers = $this->application->request->getHeaders();
        
        if(in_array(ltrim($url, '/'), $config->auth->exceptUrls->toArray())) {
            return true;
        }

        $headers = $this->application->request->getHeaders();

        if(!isset($headers["Authorization"]) || empty($headers["Authorization"])){
            $this->forbidden();
            die;
		}

        if(preg_match("/^Bearer\\s+(.*?)$/", $headers['Authorization'], $authData)) {
            try {
                $jwt->decode($authData[1]);
            } catch (\Exception $e) {
                $this->unauthorized();
                die;
            }
        } else {
            $this->forbidden();
            die;
        }

        return true;
    }

    public function forbidden() {
        $this->application->response->setJsonContent([
            'code' => 403,
            'status' => 'forbidden',
            'message' => 'Forbidden',
            'data' => ''
        ]);
        $this->application->response->send();
    }

    public function unauthorized() {
        $this->application->response->setJsonContent([
            'code'    => 401,
            'status' => 'unauthorized',
            'message' => 'Unauthorized',
            'data' => ''
        ]);
        $this->application->response->send();
    }

    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}