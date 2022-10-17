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
    public function create(Request $request, Response $response): void
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

        if (!$status) {
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

        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo crear la foto de perfil"
            ])->setStatusCode(400);
            return;
        }

        $userRoleRepository = new UserRoleRepository();
        $userRoleObj = $userRoleRepository->getOneByName($userRole);

        if (!$userRoleObj || count($userRoleObj) < 1) {
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

        if (!$status) {
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

        if (!$result) {
            $response->json(["response" => "No"])->setStatusCode(400);
            return;
        }

        // Solo los compradores y vendedores (clientes) tienen carrito
        if ($userRole !== "Super Administrador" || $userRole !== "Administrador") {
            $shoppingCartId = Uuid::uuid4()->toString();
            $shoppingCart = new ShoppingCart();
            $shoppingCart
                ->setShoppingCartId($shoppingCartId)
                ->setUserId($userId);

            $validator = new Validator($user);
            $results = $validator->validate();
            $status = $validator->getStatus();

            if (!$status) {
                // Errors
                $response->json([
                    "response" => $status,
                    "data" => $results
                ])->setStatusCode(400);
                return;
            }

            $shoppingCartRepository = new ShoppingCartRepository();
            $result = $shoppingCartRepository->create($shoppingCart);
            if (!$result) {
                $response->json([
                    "response" => "No se pudo crear el carrito"
                ])->setStatusCode(400);
                return;
            }

            $session->set('userId', $userId);
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
    public function update(Request $request, Response $response): void
    {
        $session = new PhpSession();   
        $userId = $session->get("userId");
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

        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $imageRepository = new ImageRepository();
        $result = $imageRepository->create($image);

        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo crear la foto de perfil"
            ])->setStatusCode(400);
            return;
        }

        $user = new User();
        $user
            ->setUserId($userId)
            ->setEmail($email)
            ->setUsername($username)
            ->setBirthDate($birthDate)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setGender($gender)
            ->setProfilePicture($imageId);

        $userRepository = new UserRepository();
        $result = $userRepository->update($user);

        $response->json([
            "status" => true
        ]);

        // $response->json([$userId, $email, $username, $birthDate, $firstName, $lastName, $gender]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function updatePassword(Request $request, Response $response): void
    {
        $userId = $request->getRouteParams("userId");
        $oldPassword = $request->getBody("oldPassword");
        $newPassword = $request->getBody("newPassword");
        $confirmNewPassword = $request->getBody("confirmNewPassword");

        $userRepository = new UserRepository();
        $user = $userRepository->getOne($userId);

        $authRepository = new AuthRepository();
        $auth = $authRepository->login($user["email"]);

        $res = Crypto::verify($auth["password"], $oldPassword);
        if (!$res)
        {
            // Esta mal
        }

        if ($newPassword != $confirmNewPassword)
        {
            $response->json([ "Las contraseñas no coinciden" ]);
            return;
        }

        $passwordHashed = Crypto::bcrypt($newPassword);

        $result = $userRepository->updatePassword($userId, $passwordHashed);
        if (!$result)
        {
            $response->json([ "No se pudo realizar la operacion" ]);
            return;
        }

        // TODO: Test json
        $response->json([$res]);

        //$userRepository->updatePassword();
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response): void
    {
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getUser(Request $request, Response $response): void
    {
        $userId = $request->getRouteParams('userId');

        $userRepository = new UserRepository();
        $user = $userRepository->getOne($userId);

        $response->json($user);
    }

    public function isEmailAvailable(Request $request, Response $response)
    {
        $session = new PhpSession();   
        $userId = $session->get("userId") ?? "-1";

        $email = $request->getBody("email");
        $userRepository = new UserRepository();
        $result = $userRepository->isEmailAvailable($userId, $email);
        $response->json(!boolval($result["result"]));
    }

    public function isUsernameAvailable(Request $request, Response $response)
    {
        $session = new PhpSession();   
        $userId = $session->get("userId") ?? "-1";

        $username = $request->getBody("username");
        $userRepository = new UserRepository();
        $result = $userRepository->isUsernameAvailable($userId, $username);
        $response->json(!boolval($result["result"]));
    }


    /**
     * Sacar todos los usuarios
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getAll(Request $request, Response $response): void
    {
        // https://developer.wordpress.org/rest-api/reference/posts/#list-posts
        $search = $request->getQuery('search');
        $id = $request->getQuery('exclude') ?? "";

        $userRepository = new UserRepository();
        $users = $userRepository->getAllExcept($id);

        $response->json($users);
    }

    public function getAllByFilter(Request $request, Response $response): void
    {
        $search = $request->getQuery('search');

        $userRepository = new UserRepository();
        $users = $userRepository->getAllByFilter($search);

        $response->json($users);
    }
}
