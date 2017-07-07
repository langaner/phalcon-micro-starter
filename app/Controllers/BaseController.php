<?php 

namespace App\Controllers;

use Phalcon\Mvc\Controller;

/**
 * The Base controller
 */
class BaseController extends Controller
{
	/**
	 * Render view
	 *
	 * @param string $view
	 * @param array $params
	 * @param integer $code
	 * @return void
	 */
	public function view($view, array $params = [], $code = 200)
	{
		$content = $this->view->render($view, $params);

		$this->response->setStatusCode($code, null);
		$this->response->setContent($content);
	}

	/**
	 * Render json response
	 *
	 * @param array $data
	 * @param string $message
	 * @param integer $code
	 * @param string $type
	 * @return void
	 */
	public function json($data = [], $message = '', $code = 200, $status = '', $type = null)
	{
		$data = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        $this->response->setJsonContent($data);
		$this->response->setStatusCode($code, $type);
        $this->response->send();
	}

	/**
	 * Render response
	 *
	 * @param string $data
	 * @param integer $code
	 * @param string $type
	 * @return void
	 */
	public function response($data = '', $code = 200, $type = null)
	{
		$this->response->setStatusCode($code, $type);
		$this->response->setContent($data);
	}
	
}
