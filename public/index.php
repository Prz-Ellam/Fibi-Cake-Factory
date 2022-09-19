<?php

use CakeFactory\Controllers\CategoryController;
use CakeFactory\Controllers\ImageController;
use CakeFactory\Controllers\UserController;
use CakeFactory\Controllers\WishlistController;
use Fibi\Core\Application;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;

require_once("../vendor/autoload.php");

$app = Application::app();


$app->get('/', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === true)
    {
        $response->redirect('/home');
        return;
    }

    $response->view('home');

});

$app->get('/login', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === true)
    {
        $response->redirect('/home');
        return;
    }

    $response->view('home');

});
$app->get('/signup', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === true)
    {
        $response->redirect('/home');
        return;
    }

    $response->view('index');

});

$app->get('/logout', function(Request $request, Response $response) {

    $session = new PhpSession();
    $session->destroy();
    $response->redirect('/');

});

$app->get('/home', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('home');

});

$app->get('/product', function(Request $request, Response $response) {

});

$app->get('/products', function(Request $request, Response $response) {

});

$app->get('/wishlist', function(Request $request, Response $response) {

});

$app->get('/wishlists', function(Request $request, Response $response) {

});

$app->get('/checkout', function(Request $request, Response $response) {

});

$app->get('/chat', function(Request $request, Response $response) {

});

$app->get('/shopping-cart', function(Request $request, Response $response) {

});

$app->get('/create-product', function(Request $request, Response $response) {

});

$app->get('/update-product', function(Request $request, Response $response) {

});

$app->get('/sales-report', function(Request $request, Response $response) {

});

$app->get('/orders-report', function(Request $request, Response $response) {

});

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


$app->post('/api/v1/wishlists', [ new WishlistController(), 'create' ]);




$app->run();

?>






















