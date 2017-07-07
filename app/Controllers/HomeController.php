<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
	public function index()
	{
		var_dump($this->userRepository->test());
		var_dump($this->userService->test());
		var_dump($this->userRepository->getModel()->getPresenter()->test);
		
		return [
			'status' => 200,
			'message' => 'Test index',
			'data' => 'index'
		];
	}

	public function test()
	{
		return [
			'status' => 200,
			'message' => 'Test test action',
			'data' => 'test'
		];
	}
}
