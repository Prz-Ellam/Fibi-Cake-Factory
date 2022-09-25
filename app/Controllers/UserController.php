<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Image;
use CakeFactory\Models\User;
use CakeFactory\Repositories\AuthRepository;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\ShoppingCartRepository;
use CakeFactory\Repositories\UserRepository;
use CakeFactory\Validators\UserValidator;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Request\PhpCookie;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Session\Session;
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;

class UserController extends Controller
{
    /**
     * Crea un usuario en la base de datos
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
        $birthDate = $request->getBody('birth-date');
        $firstName = $request->getBody('first-name');
        $lastName = $request->getBody('last-name');
        $visibility = $request->getBody('visibility');
        $gender = $request->getBody('gender');
        $password = password_hash($request->getBody('password'), PASSWORD_DEFAULT);
        $confirmPassword = $request->getBody('confirm-password');
        $profilePicture = $request->getFile('profile-picture');

        $imageId = Uuid::uuid4()->toString();
        $imageName = $profilePicture["name"];
        $imageType = $profilePicture["type"];
        $imageSize = $profilePicture["size"];
        $imageContent = file_get_contents($profilePicture["tmp_name"]);

        $image = new Image();
        $image->setImageId($imageId)
            ->setName($imageName)
            ->setType($imageType)
            ->setSize($imageSize)
            ->setContent($imageContent)
            ->setMultimediaEntityId($userId)
            ->setMultimediaEntityType('users');

        $imageRepository = new ImageRepository();
        $imageRepository->create($image);

        // 4 - Comprador
        $user = new User();
        $user->setUserId($userId)
            ->setEmail($email)
            ->setUsername($username)
            ->setBirthDate($birthDate)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setVisibility($visibility)
            ->setGender($gender)
            ->setPassword($password)
            ->setConfirmPassword($confirmPassword)
            ->setUserRole(4)
            ->setProfilePicture($imageId);

        $validator = new UserValidator($user);
        $result = $validator->validate();

        if ($result === false)
        {
            // Errors
            $response->json(["response" => "No"])->setStatusCode(400);
            return;
        }

        $userRepository = new UserRepository();
        $result = $userRepository->create($user);

        if ($result === false)
        {
            $response->json(["response" => "No"])->setStatusCode(400);
            return;
        }

        $shoppingCartRepository = new ShoppingCartRepository();

        $response->json(["response" => "Si"]);
    }

    /**
     * Actualiza la informacion de un usuario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response) : void
    {

    }

    public function updatePassword(Request $request, Response $response) : void
    {

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

    public function getUser(Request $request, Response $response) : void
    {
        $userId = $request->getRouteParams('userId');

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($userId);

        $response->json($user[0]);
    }

    public function login(Request $request, Response $response) : void
    {
        $loginOrEmail = $request->getBody('login-or-email');
        $password = $request->getBody('password');

        $authRepository = new AuthRepository();
        $result = $authRepository->login($loginOrEmail);
        $passwordHashed = $result[0]["password"];
        $userId = $result[0]["user_id"];

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

        $cookies = new PhpCookie();
        $cookies->set('token', $token, time() + (60 * 60));

        $response->json([
            "status" => true,
            "token" => $token
        ]);
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
    
}

?>