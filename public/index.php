<?php 

try {
    $application = require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

    $application->handle();
} catch (\Exception $e) {
    return json_encode([
        'code' => $e->getCode(),
        'status' => 'Fatal error',
        'message' => $e->getMessage(),
        'data' => null
    ]);
}
