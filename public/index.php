<?php

use CakeFactory\Controllers\CategoryController;
use CakeFactory\Controllers\ImageController;
use CakeFactory\Controllers\OrderController;
use CakeFactory\Controllers\ProductController;
use CakeFactory\Controllers\ShoppingCartController;
use CakeFactory\Controllers\ShoppingCartItemController;
use CakeFactory\Controllers\UserController;
use CakeFactory\Controllers\VideoController;
use CakeFactory\Controllers\WishlistController;
use CakeFactory\Controllers\WishlistObjectController;
use CakeFactory\Models\Category;
use CakeFactory\Models\WishlistObject;
use Fibi\Core\Application;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Nonstandard\Uuid;

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

    $response->view('landing-page', 'auth-layout');

});

$app->get('/login', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === true)
    {
        $response->redirect('/home');
        return;
    }

    $response->view('login', 'auth-layout');

});

$app->get('/signup', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === true)
    {
        $response->redirect('/home');
        return;
    }

    $response->view('signup', 'auth-layout');

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

    if (false)
    {
        $response->view('admin-dashboard', 'auth-layout');
        return;
    }

    $response->view('home');

});

$app->get('/users', function(Request $request, Response $response) {
    $response->view('users', 'auth-layout');
});

$app->get('/categories', function(Request $request, Response $response) {
    $response->view('categories', 'auth-layout');
});

$app->get('/product', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('product-detail', 'auth-layout');
});

$app->get('/products', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('products', 'auth-layout');
});

$app->get('/wishlist', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('wishlist', 'auth-layout');
});

$app->get('/wishlists', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('wishlists', 'auth-layout');
});

$app->get('/checkout', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('checkout', 'auth-layout');
});

$app->get('/chat', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('chat', 'auth-layout');
});

$app->get('/shopping-cart', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('shopping-cart', 'auth-layout');
});

$app->get('/create-product', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('create-product', 'auth-layout');
});

$app->get('/update-product', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('update-product', 'auth-layout');
});

$app->get('/sales-report', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('sales-report', 'auth-layout');
});

$app->get('/orders-report', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('orders-report', 'auth-layout');
});

$app->get('/profile', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('profile', 'auth-layout');
});

$app->get('/search', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('search', 'auth-layout');
});

// API
$app->get('/api/v1/users', function() {});
$app->post('/api/v1/users', [ new UserController(), 'create' ]);
$app->put('/api/v1/users', function() {});
$app->get('/api/v1/users/{userId}', [ new UserController(), 'getUser' ]);

$app->post('/api/v1/login', [ new UserController(), 'login' ]);

// Categories
$app->post('/api/v1/categories', [ new CategoryController(), 'create' ]);
$app->post('/api/v1/categories/{categoryId}', [ new CategoryController(), 'update' ]);
$app->delete('/api/v1/categories/{categoryId}', [ new CategoryController(), 'delete' ]);
$app->get('/api/v1/categories', [ new CategoryController(), 'getCategories' ]);

//$app->get('/api/v1/categories', function() {});

$app->post('/api/v1/products', [ new ProductController(), 'create' ]);
$app->get('/api/v1/products', [ new ProductController(), 'getProducts' ]);
$app->get('/api/v1/products/{productId}', [ new ProductController(), 'getProduct' ]);
$app->post('/api/v1/products/{productId}', [ new ProductController(), 'update']);
$app->delete('/api/v1/products/{productId}', [ new ProductController(), 'delete' ]);
$app->get('/api/v1/users/{userId}/products', [ new ProductController(), 'getUserProducts' ]);
$app->get('/api/v1/products/action/recents', [ new ProductController(), 'getRecentProducts' ]);

$app->get('/api/v1/session', [ new UserController(), 'session' ]);


$app->post('/api/v1/shopping-cart-item', [ new ShoppingCartItemController(), 'addItem' ]);
$app->delete('/api/v1/shopping-cart-items/{shoppingCartItemId}', [ new ShoppingCartItemController(), 'removeItem' ]);
$app->get('/api/v1/shopping-cart', [ new ShoppingCartItemController(), 'getShoppingCartItems' ]);


// Images
$app->get('/api/v1/images/{imageId}', [ new ImageController(), 'get' ]);
$app->get('/api/v1/files/{fileId}', []);

$app->get('/api/v1/videos/{videoId}', [ new VideoController(), 'getVideo' ]);

$app->post('/api/v1/wishlists', [ new WishlistController(), 'create' ]);
$app->post('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'update' ]);
$app->delete('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'delete' ]);
$app->get('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'getWishlist' ]);
$app->get('/api/v1/users/{userId}/wishlists', [ new WishlistController(), 'getUserWishlists' ]);

$app->post('/api/v1/wishlist-objects', [ new WishlistObjectController(), 'addObject' ]);
$app->get('/api/v1/wishlist-objects/{wishlistId}', [ new WishlistObjectController(), 'getWishlistObjects' ]);
$app->delete('/api/v1/wishlist-objects/{wishlistObjectId}', [ new WishlistObjectController(), 'deleteObject' ]);

$app->post('/api/v1/checkout', [ new OrderController(), 'checkout' ]);


$app->get('/prueba', function(Request $request, Response $response) {
    
    $category = new Category();
    $category
            ->setCategoryId(Uuid::uuid4()->toString())
            ->setName("A")
            ->setDescription("Pasteles deliciosos")
            ->setUserId(Uuid::uuid4()->toString());

    $validator = new Validator($category);
    var_dump($validator->validate());

    die;

});

$app->run();

?>






















