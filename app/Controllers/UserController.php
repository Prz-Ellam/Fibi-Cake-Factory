<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Image;
use CakeFactory\Models\User;
use CakeFactory\Repositories\AuthRepository;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\UserRepository;
use CakeFactory\Validators\UserValidator;
use Fibi\Http\Controller;
use Fibi\Http\Request;
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
            ->setMultimediaEntityId(1);

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
            $response->json(["response" => "No"]);
            return;
        }

        $userRepository = new UserRepository();
        $result = $userRepository->create($user);

        if ($result === false)
        {
            $response->json(["response" => "No"]);
            return;
        }


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

    public function login(Request $request, Response $response) : void
    {
        $loginOrEmail = $request->getBody('login-or-email');
        $password = $request->getBody('password');

        $authRepository = new AuthRepository();
        $passwordHashed = $authRepository->login($loginOrEmail)[0]["password"];
        $passwordCheck = password_verify($password, $passwordHashed);

        $token = JWT::encode([ "login" => $loginOrEmail ], "1234", "HS256");

        $session = new PhpSession();
        $session->start();
        //$session->set('token', $token);

        var_dump($session->get()); die;
    }

    public function isEmailAvailable(Request $request, Response $response)
    {

    }

    public function isUsernameAvailable(Request $request, Response $response)
    {
        
    }
}

?>