<?php

use CakeFactory\Controllers\CategoryController;
use CakeFactory\Controllers\ImageController;
use CakeFactory\Controllers\UserController;
use Fibi\Core\Application;
use Fibi\Http\Request;
use Fibi\Http\Response;

require_once("../vendor/autoload.php");

$app = Application::app();

$index = function(Request $request, Response $response)
{
    $response->view('index');
};

$app->get('/', $index);
$app->get('/login', $index);
$app->get('/signup', $index);
$app->get('/home', $index);
$app->get('/product', $index);
$app->get('/products', $index);
$app->get('/wishlist', $index);
$app->get('/wishlists', $index);
$app->get('/checkout', $index);
$app->get('/chat', $index);
$app->get('/shopping-cart', $index);
$app->get('/create-product', $index);
$app->get('/update-product', $index);
$app->get('/sales-report', $index);
$app->get('/orders-report', $index);

// API
$app->get('/api/v1/users', function() {});
$app->post('/api/v1/users', [ new UserController(), 'create' ]);
$app->put('/api/v1/users', function() {});

$app->post('/api/v1/login', [ new UserController(), 'login' ]);

// Categories
$app->post('/api/v1/categories', [ new CategoryController(), 'create' ]);
$app->put('/api/v1/categories', function() {});
$app->delete('/api/v1/categories', function() {});
$app->get('/api/v1/categories', function() {});

// Images
$app->get('/api/v1/images/{imageId}', [ new ImageController(), 'get' ]);





$app->run();

?>






















