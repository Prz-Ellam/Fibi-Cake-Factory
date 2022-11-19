<?php

use CakeFactory\Build\Startup;
use CakeFactory\Controllers\CategoryController;
use CakeFactory\Controllers\ChatController;
use CakeFactory\Controllers\ChatMessageController;
use CakeFactory\Controllers\ChatParticipantController;
use CakeFactory\Controllers\ImageController;
use CakeFactory\Controllers\OrderController;
use CakeFactory\Controllers\ProductController;
use CakeFactory\Controllers\ReportController;
use CakeFactory\Controllers\ReviewController;
use CakeFactory\Controllers\SessionController;
use CakeFactory\Controllers\ShoppingCartItemController;
use CakeFactory\Controllers\UserController;
use CakeFactory\Controllers\VideoController;
use CakeFactory\Controllers\WishlistController;
use CakeFactory\Controllers\WishlistObjectController;
use CakeFactory\Models\Category;
use CakeFactory\Repositories\ShoppingCartItemRepository;
use CakeFactory\Repositories\ShoppingCartRepository;
use CakeFactory\Repositories\UserRepository;
use Dotenv\Dotenv;
use Fibi\Core\Application;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\MaxLength;
use Fibi\Validation\Rules\Required;
use Ramsey\Uuid\Nonstandard\Uuid;

require_once("../vendor/autoload.php");

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



//$startup = new Startup();
//$startup->load();
//die;


$app = Application::app();

$uri = $_SERVER["REQUEST_URI"];
if ($uri[strlen($uri) - 1] === "/")
{
    header("Location: " . substr($uri, 0, strlen($uri) - 1));
}

$app->get('/', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === true)
    {
        $response->redirect('/home');
        return;
    }

    $response->view('landing-page', 'auth-layout');

});

$app->get('/login', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === true)
    {
        $response->redirect('/home');
        return;
    }

    $response->view('login', 'auth-layout');

});

$app->get('/signup', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

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

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }
    
    if ($session->get('role') === 'Administrador' || $session->get('role') === 'Super Administrador')
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

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('product-detail', 'auth-layout');
});

$app->get('/products', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $role = $session->get("role");
    if ($role === "Super Administrador" || $role === "Administrador") 
    {
        $response->view('approve-products', 'auth-layout');
        return;
    }

    $response->view('products', 'auth-layout');
});

$app->get('/wishlist', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('wishlist', 'auth-layout');
});

$app->get('/wishlists', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('wishlists', 'auth-layout');
});

$app->get('/checkout', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');
    
    if (!$login) {
        $response->redirect('/');
        return;
    }

    $userId = $session->get('userId');
    $shoppingCartRepository = new ShoppingCartRepository();
    $shoppingCartId = $shoppingCartRepository->getUserCart($userId);

    $shoppingCartItemRepository = new ShoppingCartItemRepository();
    $result = $shoppingCartItemRepository->getShoppingCartItems($shoppingCartId);

    if (!$result) {
        $response->redirect('/');
        return;
    }

    $response->view('checkout', 'auth-layout');
});

$app->get('/chat', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('chat', 'auth-layout');
});

$app->get('/shopping-cart', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('shopping-cart', 'auth-layout');
});

$app->get('/create-product', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('create-product', 'auth-layout');
});

$app->get('/update-product', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('update-product', 'auth-layout');
});

$app->get('/sales-report', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('sales-report', 'auth-layout');
});

$app->get('/orders-report', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('orders-report', 'auth-layout');
});

$app->get('/profile', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $id = $request->getQuery('id');
    if ($id === null)
    {
        $response->redirect('/profile?id=' . $session->get('userId'));
        return;
    }

    if ($id === $session->get('userId'))
        $response->view('profile', 'auth-layout');
    else
    {
        $userId = $request->getQuery('id');

        $userRepository = new UserRepository();
        $user = $userRepository->getOne($userId);

        if ($user === [])
        {
            $response->text("404 Not found")->setStatusCode(404);
            return;
        }

        $response->view('user-profile-2', 'auth-layout');
    }
});

$app->get('/search', function(Request $request, Response $response) {

    $session = new PhpSession();

    $login = $session->has('userId');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('search', 'auth-layout');
});



// API

// Users
$app->post('/api/v1/users', [ new UserController(), 'create' ]);
$app->put('/api/v1/users/{userId}', [ new UserController(), 'update' ]);
$app->put('/api/v1/users/{userId}/password', [ new UserController(), 'updatePassword' ]);
$app->delete('/api/v1/users/{userId}', [ new UserController(), 'delete' ]);
$app->get('/api/v1/users', [ new UserController(), 'getAll' ]);
$app->get('/api/v1/users/{userId}', [ new UserController(), 'getUser' ]);



// Auth
$app->post('/api/v1/login', [ new SessionController(), 'login' ]);
$app->post('/api/v1/session', [ new SessionController(), 'login' ]);
$app->get('/api/v1/session', [ new SessionController(), 'session' ]);

$app->post('/api/v1/users/email/available', [ new UserController(), 'isEmailAvailable' ]);
$app->post('/api/v1/users/username/available', [ new UserController(), 'isUsernameAvailable' ]);

$app->get('/api/v1/users/{userId}/products/approves', [ new ProductController(), 'getApprovedProdcuts' ]);




// Wishlists
$app->post('/api/v1/wishlists', [ new WishlistController(), 'create' ]);
$app->put('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'update' ]);
$app->delete('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'delete' ]);
$app->get('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'getWishlist' ]);
$app->get('/api/v1/users/{userId}/wishlists', [ new WishlistController(), 'getUserWishlists' ]);



// Categories
$app->post('/api/v1/categories', [ new CategoryController(), 'create' ]);
$app->put('/api/v1/categories/{categoryId}', [ new CategoryController(), 'update' ]);
$app->delete('/api/v1/categories/{categoryId}', [ new CategoryController(), 'delete' ]);
$app->get('/api/v1/categories', [ new CategoryController(), 'getCategories' ]);



// Products
$app->post('/api/v1/products', [ new ProductController(), 'create' ]);
$app->put('/api/v1/products/{productId}', [ new ProductController(), 'update']);
$app->delete('/api/v1/products/{productId}', [ new ProductController(), 'delete' ]);
$app->get('/api/v1/products', [ new ProductController(), 'getProducts' ]);
$app->get('/api/v1/products/{productId}', [ new ProductController(), 'getProduct' ]);

$app->get('/api/v1/users/{userId}/products', [ new ProductController(), 'getUserProducts' ]);
$app->get('/api/v1/products/action/recents', [ new ProductController(), 'getRecentProducts' ]);



$app->post('/api/v1/shopping-cart-item', [ new ShoppingCartItemController(), 'addItem' ]);
$app->delete('/api/v1/shopping-cart-items/{shoppingCartItemId}', [ new ShoppingCartItemController(), 'removeItem' ]);
$app->get('/api/v1/shopping-cart', [ new ShoppingCartItemController(), 'getShoppingCartItems' ]);

$app->post('/api/v1/shopping-carts/{shoppingCartItemId}', [ new ShoppingCartItemController(), 'update' ]);


// Images
$app->get('/api/v1/images/{imageId}', [ new ImageController(), 'get' ]);
$app->delete('/api/v1/images/{id}', [ new ImageController(), 'delete' ]);





$app->get('/api/v1/files/{fileId}', []);

$app->get('/api/v1/videos/{videoId}', [ new VideoController(), 'getVideo' ]);

$app->post('/api/v1/wishlist-objects', [ new WishlistObjectController(), 'create' ]);
$app->get('/api/v1/wishlist-objects/{wishlistId}', [ new WishlistObjectController(), 'getWishlistObjects' ]);
$app->delete('/api/v1/wishlist-objects/{wishlistObjectId}', [ new WishlistObjectController(), 'delete' ]);

$app->post('/api/v1/checkout', [ new OrderController(), 'checkout' ]);


$app->post('/api/v1/chats/check', [ new ChatController(), 'checkIfExists' ]);
$app->post('/api/v1/chats/findOrCreate', [ new ChatController(), 'findOrCreateChat' ]);
$app->get('/api/v1/users/{userId}/chats', [ new ChatController(), 'getRecentChats' ]);

$app->post('/api/v1/chatParticipants/userId', [ new ChatParticipantController(), 'getOneByUserId' ]);

$app->post('/api/v1/chats/{chatId}/messages', [ new ChatMessageController(), 'create' ]);
$app->get('/api/v1/chats/{chatId}/messages', [ new ChatMessageController(), 'getAllByChat' ]);





$app->post('/api/v1/products/{productId}/reviews', [ new ReviewController(), 'create' ]);
$app->put('/api/v1/products/{productId}/reviews/{reviewId}', [ new ReviewController(), 'update' ]);
$app->delete('/api/v1/products/{productId}/reviews/{reviewId}', [ new ReviewController(), 'delete' ]);


$app->get('/api/v1/products/{productId}/comments', [ new ReviewController(), 'getProductComments' ]);




$app->get('/api/v1/products/find/pending', [ new ProductController(), 'getPendingProducts' ]);
$app->post('/api/v1/products/{productId}/approve', [ new ProductController(), 'approve'  ]);
$app->post('/api/v1/products/{productId}/denied', [ new ProductController(), 'denied'  ]);

$app->get('/api/v1/users/{userId}/products/approved', [ new ProductController(), 'getUserApproveProducts' ]);
$app->get('/api/v1/users/{userId}/products/denied', [ new ProductController(), 'getUserDeniedProducts' ]);
$app->get('/api/v1/users/{userId}/products/pending', [ new ProductController(), 'getUserPendingProducts' ]);

$app->get('/api/v1/users/{userId}/wishlists/public', [ new WishlistController(), 'getUserPublicWishlists' ]);


$app->get('/api/v1/reports/order-report', [ new ReportController(), 'getOrderReport' ]);
$app->get('/api/v1/reports/sales-report2', [ new ReportController(), 'getSalesReport2' ]);
$app->get('/api/v1/reports/sales-report', [ new ReportController(), 'getSalesReport' ]);

$app->get('/api/v1/users/filter/search', [ new UserController(), 'getAllByFilter' ]);






$app->get('/api/v1/products/order/price', [ new ProductController(), 'getAllByPrice' ]);
$app->get('/api/v1/products/order/ships', [ new ProductController(), 'getAllByShips' ]);
$app->get('/api/v1/products/order/alpha', [ new ProductController(), 'getAllByAlpha' ]);

$app->get('/testing', function (Request $request, Response $response) {
/*
    $orderRepository = new OrderRepository();
    $results = $orderRepository->getOrderReport("95ee300d-6466-4f43-86fd-35c2737da7f8", null, null, null);
    foreach ($results as &$result)
    {
        $result["categories"] = explode(',', $result["categories"]);
    }

    $response->json($results);
*/
});

$app->get('/prueba', function(Request $request, Response $response) {
    
    $category = new Category();
    $category
            ->setCategoryId(Uuid::uuid4()->toString())
            ->setName("A")
            ->setDescription("Pasteles deliciosos")
            ->setUserId(Uuid::uuid4()->toString());

    print("<pre>");

    $parameters = [];
    $str = "CALL sp_update_category(:categoryId, :name, :description)";
    preg_match_all("/:([A-Za-z]+)[,()]/", $str, $parameters);

    $parameters = $parameters[1];
    $properties = $category->toObject();

    var_dump($parameters);

    var_dump($properties);

    $properties = array_filter($properties, 
    function($key) use ($parameters) { 
        return in_array($key, $parameters); 
    }, ARRAY_FILTER_USE_KEY);

    var_dump($properties);

    print("</pre>");

    //$validator = new Validator($category);
    //var_dump($validator->validate());

    die;

});

$app->post('/test', function(Request $req, Response $res) {

    $inputs = [
        "rules" => [
            "name" => [
                new Required(),
                new MaxLength(5, "Hola")
            ],
            "description" => 
                new Required()
        ],
        "values" => [
            "name" => "",
            'description' => ""
        ]
    ];

    foreach ($inputs["rules"] as $property => $rules)
        {
            $status = false;
            if (is_array($rules))
            {
                foreach ($rules as $rule)
                {
                    $status = $rule->isValid($inputs["values"][$property]);
                    $class = new ReflectionClass($rule);
                    $attributeName = $class->getShortName();
                    if (!$status)
                    {
                        $results[$property][$attributeName] = $rule->message();
                    }
                }
            }
            else
            {
                $status = $rules->isValid($inputs["values"][$property]);
                $class = new ReflectionClass($rules);
                $attributeName = $class->getShortName();
                if (!$status)
                {
                    $results[$property][$attributeName] = $rules->message();
                }
            }

        }

    var_dump($results);
    
die;
});

$app->run();
