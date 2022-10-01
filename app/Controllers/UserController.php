<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Image;
use CakeFactory\Models\ShoppingCart;
use CakeFactory\Models\User;
use CakeFactory\Repositories\AuthRepository;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\ShoppingCartRepository;
use CakeFactory\Repositories\UserRepository;
use CakeFactory\Repositories\UserRoleRepository;
use Fibi\Core\Storage;
use Fibi\Database\DB;
use Fibi\Helpers\Crypto;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Request\PhpCookie;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;

class UserController extends Controller
{
    /**
     * Crea un usuario en la base de datos
     * Endpoint: POST /api/v1/users
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-09-28
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response) : void
    {
        $userId = Uuid::uuid4()->toString();
        $email = $request->getBody('email');
        $username = $request->getBody('username');
        $birthDate = $request->getBody('birthDate');
        $firstName = $request->getBody('firstName');
        $lastName = $request->getBody('lastName');
        $visible = $request->getBody('visible');
        $gender = $request->getBody('gender');
        $password = $request->getBody('password');
        $confirmPassword = $request->getBody('confirmPassword');
        $profilePicture = $request->getFile('profilePicture');
        //Storage::set('confirmPassword', $confirmPassword);
        
        $session = new PhpSession();
        // Solo un super administrado logueado puede dar de alta otro tipo de usuarios
        if ($session->get("role") === "Super Administrador")
            $userRole = $request->getBody("userRole");
        else
            $userRole = "Comprador";

        $imageId = Uuid::uuid4()->toString();
        $imageName = $profilePicture->getName();
        $imageType = $profilePicture->getType();
        $imageSize = $profilePicture->getSize();
        $imageContent = $profilePicture->getContent();

        $image = new Image();
        $image
            ->setImageId($imageId)
            ->setName($imageName)
            ->setType($imageType)
            ->setSize($imageSize)
            ->setContent($imageContent)
            ->setMultimediaEntityId($userId)
            ->setMultimediaEntityType("users");

        $validator = new Validator($image);
        $feedback = $validator->validate();
        $status = $validator->getStatus();

        if (!$status)
        {
            // Errors
            $response->json([
                "response" => $status,
                "data" => $feedback
            ])->setStatusCode(400);
            return;
        }

        DB::beginTransaction();

        $imageRepository = new ImageRepository();
        $result = $imageRepository->create($image);

        if (!$result)
        {
            $response->json([
                "status" => false,
                "message" => "No se pudo crear la foto de perfil"
            ])->setStatusCode(400);
            return;
        }

        $userRoleRepository = new UserRoleRepository();
        $userRoleObj = $userRoleRepository->getOneByName($userRole);
        
        if (!$userRoleObj || count($userRoleObj) < 1)
        {
            $response->json([
                "status" => "No se encontro el rol de usuario"
            ])->setStatusCode(400);
            return;
        }

        // 4 - Comprador
        $user = new User();
        $user
            ->setUserId($userId)
            ->setEmail($email)
            ->setUsername($username)
            ->setBirthDate($birthDate)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setVisibility($visible)
            ->setGender($gender)
            ->setPassword($password)
            ->setUserRole($userRoleObj[0]["userRoleId"])
            ->setProfilePicture($imageId);

        $validator = new Validator($user);
        $results = $validator->validate();
        $status = $validator->getStatus();

        if (!$status)
        {
            // Errors
            $response->json([
                "response" => $results,
                "message" => "No se pudo crear al usuario"
            ])->setStatusCode(400);
            return;
        }

        $user->setPassword(Crypto::bcrypt($user->getPassword()));

        $userRepository = new UserRepository();
        $result = $userRepository->create($user);

        if (!$result)
        {
            $response->json(["response" => "No"])->setStatusCode(400);
            return;
        }

        // Solo los compradores y vendedores (clientes) tienen carrito
        if ($userRole !== "Super Administrador" || $userRole !== "Administrador")
        {
            $shoppingCartId = Uuid::uuid4()->toString();
            $shoppingCart = new ShoppingCart();
            $shoppingCart
                ->setShoppingCartId($shoppingCartId)
                ->setUserId($userId);
        
            $validator = new Validator($user);
            $results = $validator->validate();
            $status = $validator->getStatus();
    
            if (!$status)
            {
                // Errors
                $response->json([
                    "response" => $status,
                    "data" => $results
                ])->setStatusCode(400);
                return;
            }
                
            $shoppingCartRepository = new ShoppingCartRepository();
            $result = $shoppingCartRepository->create($shoppingCart);
            if (!$result)
            {
                $response->json([
                    "response" => "No se pudo crear el carrito"
                ])->setStatusCode(400);
                return;
            }

            $JWT_SECRET = "3bb515fea33c5a653a5bbdcd20d958c8b7e49a91db0c74e91a04a0faab4f5c3a";
            $iat = time();
            $exp = $iat + 60 * 60;
            $token = JWT::encode([ 
                "login" => $email,
                "iat" => $iat,
                "exp" => $exp
            ], $JWT_SECRET, "HS256");
    
            $session->set('token', $token);
            $session->set('user_id', $userId);
            $session->set('role', $userRole);
        }

        DB::endTransaction();

        $response->json(["response" => "Si"]);
    }

    /**
     * Actualiza la informacion de un usuario
     * Endpoint: /api/v1/users/:userId
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-09-29
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response) : void
    {
        //$userId = Uuid::uuid4()->toString();
        $email = $request->getBody('email');
        $username = $request->getBody('username');
        $birthDate = $request->getBody('birthDate');
        $firstName = $request->getBody('firstName');
        $lastName = $request->getBody('lastName');
        //$visible = $request->getBody('visible');
        $gender = $request->getBody('gender');
        //$password = $request->getBody('password');
        //$confirmPassword = $request->getBody('confirmPassword');
        $profilePicture = $request->getFile('profilePicture');

        
        
    }

    public function updatePassword(Request $request, Response $response) : void
    {
        $oldPassword = $request->getBody("oldPassword");
        $newPassword = $request->getBody("newPassword");
        $confirmNewPassword = $request->getBody("confirmNewPassword");
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response) : void
    {

    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getUser(Request $request, Response $response) : void
    {
        $userId = $request->getRouteParams('userId');

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($userId);

        $response->json($user[0]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function login(Request $request, Response $response) : void
    {
        $loginOrEmail = $request->getBody('loginOrEmail');
        $password = $request->getBody('password');

        $required = new Required();
        if (!$required->isValid($loginOrEmail) || !$required->isValid($password) )
        {
            $response->setStatusCode(400)->json([
                "status" => "Bad request"
            ]);
            return;
        }

        $authRepository = new AuthRepository();
        $result = $authRepository->login($loginOrEmail);

        if ($result === null || count($result) < 1)
        {
            $response->setStatusCode(400)->json([
                "status" => "Bad request"
            ])->redirect('/login');
            return;
        }

        $passwordHashed = $result[0]["password"];
        $userId = $result[0]["user_id"];
        $userRole = $result[0]["user_role"];

        $passwordCheck = password_verify($password, $passwordHashed);

        if ($passwordCheck === false)
        {
            $response->json([
                "status" => false
            ])->setStatusCode(400);
            return;
        }

        // Cuida mucho el JWT_SECRET
        $JWT_SECRET = "3bb515fea33c5a653a5bbdcd20d958c8b7e49a91db0c74e91a04a0faab4f5c3a";
        $iat = time();
        $exp = $iat + 60 * 60;
        $token = JWT::encode([ 
            "login" => $loginOrEmail,
            "iat" => $iat,
            "exp" => $exp
        ], $JWT_SECRET, "HS256");

        $session = new PhpSession();
        $session->set('token', $token);
        $session->set('user_id', $userId);
        $session->set('role', $userRole);

        $cookies = new PhpCookie();
        $cookies->set('token', $token, time() + (60 * 60));

        $response->json([
            "status" => true,
            "token" => $token,
            "userRole" => $userRole
        ]);//->redirect('/');
    }

    public function isEmailAvailable(Request $request, Response $response)
    {

    }

    public function isUsernameAvailable(Request $request, Response $response)
    {
        
    }

    public function session(Request $request, Response $response)
    {
        $session = new PhpSession();
        $userId = $session->get('user_id');

        $response->json(["id" => $userId]);
    }

    /**
     * Sacar todos los usuarios
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getAll(Request $request, Response $response) : void
    {
        // https://developer.wordpress.org/rest-api/reference/posts/#list-posts
        $search = $request->getQuery('search');
        $id = $request->getQuery('exclude') ?? "";

        $userRepository = new UserRepository();
        $users = $userRepository->getAllExcept($id);

        $response->json($users);
    }
    
}
