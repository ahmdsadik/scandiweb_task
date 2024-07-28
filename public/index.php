<?php


use App\Controllers\ProductAttributeController;
use App\Controllers\ProductController;
use App\Controllers\ValidateProductController;
use App\Lib\Session;

session_start();

require_once '../app/config/config.php';
require_once APP_PATH . '/Helpers/functions.php';
require_once APP_PATH . '/../vendor/autoload.php';


$route = new \App\Lib\Router();

$route->get('/', [ProductController::class, 'index']);
$route->get('/product-attributes', [ProductAttributeController::class, 'productAttribute']);
$route->post('/product-validate', [ValidateProductController::class, 'validate']);
$route->get('/add-product', [ProductController::class, 'create']);
$route->post('/product', [ProductController::class, 'store']);
$route->delete('/product', [ProductController::class, 'destroy']);
$route->dispatch();

Session::unflash();