<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Auth\Auth;

class AuthController extends BaseController
{
    /**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $jwt;

    public function onConstruct()
    {
        $this->jwt = new Auth;
    }

	public function login()
	{
		$userData = [
			'name' => 'Phalcom',
			'email' => 'phalcom@phalconphp.com'
		];

		return $this->jwt->encode($userData);
	}

	public function refresh()
	{
		
	}
}
