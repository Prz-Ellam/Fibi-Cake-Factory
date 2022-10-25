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
use Exception;
use Fibi\Database\DB;
use Fibi\Helpers\Crypto;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Request\PhpCookie;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Validator;
use PDOException;
use Ramsey\Uuid\Uuid;

/**
 * Controlador de usuarios
 */
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
        $result = null;

        $userId = Uuid::uuid4()->toString();
        $email = $request->getBody("email");
        $username = $request->getBody("username");
        $birthDate = $request->getBody("birthDate");
        $firstName = $request->getBody("firstName");
        $lastName = $request->getBody("lastName");
        $visible = $request->getBody("visible");
        $gender = $request->getBody("gender");
        $password = $request->getBody("password");
        $confirmPassword = $request->getBody("confirmPassword");
        $profilePicture = $request->getFiles("profilePicture");

        $session = new PhpSession();
        $userRole = ($session->get("role") === "Super Administrador") ? 
            "Administrador" : "Comprador";

        // Images
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
                "status" => $status,
                "message" =>  $feedback
            ])->setStatusCode(400);
            return;
        }

        DB::beginTransaction();

        $imageRepository = new ImageRepository();

        try {
            $result = $imageRepository->create($image);
        }
        catch (PDOException $ex) {
            $response->json([
                "status" => false,
                "message" => [
                    "profilePicture" => [ "Error" => "Hubo un error con la base de datos" ]
                ]
            ])->setStatusCode(500);
            return;
        }

        if (!$result) {
            $response->json([
                "status" => false,
                "message" => [
                    "profilePicture" => [ "Error" => "No se pudo crear la foto de perfil" ]
                ]
            ])->setStatusCode(400);
            return;
        }

        $userRoleRepository = new UserRoleRepository();
        $userRoleObj = $userRoleRepository->getOneByName($userRole);

        if (!$userRoleObj || count($userRoleObj) < 1) {
            $response->json([
                "status" => false,
                "message" => "No se encontro el rol de usuario"
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
            ->setVisible($visible)
            ->setGender($gender)
            ->setPassword($password)
            ->setUserRole($userRoleObj["userRoleId"])
            ->setProfilePicture($imageId);

        $validator = new Validator($user);
        $results = $validator->validate();
        $status = $validator->getStatus();

        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $results
            ])->setStatusCode(400);
            return;
        }

        $user->setPassword(Crypto::bcrypt($user->getPassword()));

        $userRepository = new UserRepository();
        $result = $userRepository->create($user);
        if (!$result) {
            $response->json([
                "status" => $result,
                "message" => "No se pudo crear al usuario"
            ])->setStatusCode(400);
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
                $response->json([
                    "status" => $status,
                    "message" => $results
                ])->setStatusCode(400);
                return;
            }

            $shoppingCartRepository = new ShoppingCartRepository();
            $result = $shoppingCartRepository->create($shoppingCart);
            if (!$result) {
                $response->json([
                    "status" => false,
                    "message" => "No se pudo crear el carrito"
                ])->setStatusCode(400);
                return;
            }

            $session->set("userId", $userId);
            $session->set("role", $userRole);
        }

        DB::endTransaction();

        $response->json([
            "status" => true,
            "message" => "El usuario se creó exitosamente"
        ]);
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
        $email = $request->getBody("email");
        $username = $request->getBody("username");
        $birthDate = $request->getBody("birthDate");
        $firstName = $request->getBody("firstName");
        $lastName = $request->getBody("lastName");
        $gender = $request->getBody("gender");
        $profilePicture = $request->getFile("profilePicture");

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
/*
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
*/
        $userRepository = new UserRepository();
        $result = $userRepository->update($user);
        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo editar el usuario"
            ])->setStatusCode(400);
            return;
        }

        $response->json([
            "status" => true
        ]);
    }

    /**
     * Actualiza la contraseña del usuario
     * Endpoint: /api/v1/users/:userId/password
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
     * Elimina un usuario de la base de datos
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response): void
    {
    }

    /**
     * Obtiene un usuario en base a su ID
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

    /**
     * Verifica si existe un usuario con un email
     *
     * @param Request $request
     * @param Response $response
     * @return boolean
     */
    public function isEmailAvailable(Request $request, Response $response)
    {
        $session = new PhpSession();   
        $userId = $session->get("userId") ?? "-1";

        $email = $request->getBody("email");
        $userRepository = new UserRepository();
        $result = $userRepository->isEmailAvailable($userId, $email);
        $response->json(!boolval($result["result"]));
    }

    /**
     * Verifica si existe un usuario con ese username
     *
     * @param Request $request
     * @param Response $response
     * @return boolean
     */
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
     * Obtiene todos los usuarios
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

        $response
            ->setHeader("Access-Control-Allow-Origin", "*")
            ->json($users);
    }

    public function getAllByFilter(Request $request, Response $response): void
    {
        $search = $request->getQuery('search');

        $userRepository = new UserRepository();
        $users = $userRepository->getAllByFilter($search);

        $response->json($users);
    }
}
