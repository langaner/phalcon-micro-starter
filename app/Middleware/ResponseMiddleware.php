<?php

namespace App\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class ResponseMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        $returnedValue = $application->getReturnedValue();
        
        $data = [
            'code'    => $returnedValue['code'] ?? 200,
            'status'  => $returnedValue['status'] ?? '',
            'message' => $returnedValue['message'] ?? '',
            'data' => $returnedValue['data'] ?? $returnedValue,
        ];

        $application->response->setJsonContent($data);
        $application->response->send();

        return true;
    }
}