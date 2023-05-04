<?php

declare(strict_types=1);

use model\Db;
use Services\CarService;

spl_autoload_register(static function ($class_name) {
    $fileName = str_ireplace('\\', '/', $class_name) . '.php';
    if (is_readable($fileName)) {
        require_once $fileName;
    }
});

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$service = new CarService();
$result = $service->run($method, $_GET);

header("Access-Control-Allow-Origin: *");

if (!empty($result)) {
    echo json_encode($result, JSON_THROW_ON_ERROR);
} else {
    echo json_encode([], JSON_THROW_ON_ERROR);
}
