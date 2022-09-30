<?php

use CakeFactory\Build\Startup;
use CakeFactory\Controllers\CategoryController;
use CakeFactory\Controllers\ChatController;
use CakeFactory\Controllers\ChatMessageController;
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
use CakeFactory\Repositories\UserRepository;
use Dotenv\Dotenv;
use Fibi\Core\Application;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Validator;
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

    $id = $request->getQuery('id');
    if ($id === null)
    {
        $response->redirect('/profile?id=' . $session->get('user_id'));
        return;
    }

    if ($id === $session->get('user_id'))
        $response->view('profile', 'auth-layout');
    else
    {
        $userId = $request->getQuery('id');

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($userId);

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

    $login = $session->has('token');

    if ($login === false)
    {
        $response->redirect('/');
        return;
    }

    $response->view('search', 'auth-layout');
});

// API
$app->get('/api/v1/users', [ new UserController(), 'getAll' ]);
$app->post('/api/v1/users', [ new UserController(), 'create' ]);
$app->put('/api/v1/users', function() {});
$app->get('/api/v1/users/{userId}', [ new UserController(), 'getUser' ]);
$app->delete('/api/v1/users/{userId}', function() {});

$app->post('/api/v1/login', [ new UserController(), 'login' ]);

// Wishlists
$app->post('/api/v1/wishlists', [ new WishlistController(), 'create' ]);
$app->put('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'update' ]);
$app->delete('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'delete' ]);
$app->get('/api/v1/wishlists/{wishlistId}', [ new WishlistController(), 'getWishlist' ]);
$app->get('/api/v1/users/{userId}/wishlists', [ new WishlistController(), 'getUserWishlists' ]);



$app->post('/api/v1/session', [ new UserController(), 'login' ]);

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


$app->post('/api/v1/wishlist-objects', [ new WishlistObjectController(), 'addObject' ]);
$app->get('/api/v1/wishlist-objects/{wishlistId}', [ new WishlistObjectController(), 'getWishlistObjects' ]);
$app->delete('/api/v1/wishlist-objects/{wishlistObjectId}', [ new WishlistObjectController(), 'deleteObject' ]);

$app->post('/api/v1/checkout', [ new OrderController(), 'checkout' ]);


$app->post('/api/v1/chats/check', [ new ChatController(), 'checkIfExists' ]);
$app->post('/api/v1/chats/findOrCreate', [ new ChatController(), 'findOrCreateChat' ]);


$app->post('/api/v1/chats/{chatId}/messages', [ new ChatMessageController(), 'create' ]);
$app->get('/api/v1/chats/{chatId}/messages', [ new ChatMessageController(), 'getAllByChat' ]);



$app->put('/prueba', function (Request $request, Response $response) {

    global $_PUT;

    /* PUT data comes in on the stdin stream */
    $putdata = fopen("php://input", "r");

    /* Open a file for writing */
    // $fp = fopen("myputfile.ext", "w");

    $raw_data = '';

    /* Read the data 1 KB at a time
       and write to the file */
    while ($chunk = fread($putdata, 1024))
        $raw_data .= $chunk;

    /* Close the streams */
    fclose($putdata);

    // Fetch content and determine boundary
    $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

    if(empty($boundary)){
        parse_str($raw_data,$data);
        $GLOBALS[ '_PUT' ] = $data;
        return;
    }

    // Fetch each part
    $parts = array_slice(explode($boundary, $raw_data), 1);
    $data = array();

    foreach ($parts as $part) {
        // If this is the last part, break
        if ($part == "--\r\n") break;

        // Separate content from headers
        $part = ltrim($part, "\r\n");
        list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

        // Parse the headers list
        $raw_headers = explode("\r\n", $raw_headers);
        $headers = array();
        foreach ($raw_headers as $header) {
            list($name, $value) = explode(':', $header);
            $headers[strtolower($name)] = ltrim($value, ' ');
        }

        // Parse the Content-Disposition to get the field name, etc.
        if (isset($headers['content-disposition'])) {
            $filename = null;
            $tmp_name = null;
            preg_match(
                '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                $headers['content-disposition'],
                $matches
            );
            list(, $type, $name) = $matches;

            //Parse File
            if( isset($matches[4]) )
            {
                //if labeled the same as previous, skip
                if( isset( $_FILES[ $matches[ 2 ] ] ) )
                {
                    continue;
                }

                //get filename
                $filename = $matches[4];

                //get tmp name
                $filename_parts = pathinfo( $filename );
                $tmp_name = tempnam( ini_get('upload_tmp_dir'), $filename_parts['filename']);

                //populate $_FILES with information, size may be off in multibyte situation
                $_FILES[ $matches[ 2 ] ] = array(
                    'error'=>0,
                    'name'=>$filename,
                    'tmp_name'=>$tmp_name,
                    'size'=>strlen( $body ),
                    'type'=>$value
                );

                //place in temporary directory
                file_put_contents($tmp_name, $body);
            }
            //Parse Field
            else
            {
                $data[$name] = substr($body, 0, strlen($body) - 2);
            }
        }

    }
    $GLOBALS[ '_PUT' ] = $data;

    var_dump($_FILES);
    die;

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

$app->get('/run', function(Request $req, Response $res) {

    

});

$app->run();

?>






















