<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\AuthRepository;
use Fibi\Helpers\Crypto;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Request\PhpCookie;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\Required;

class SessionController extends Controller
{
    /**
     * Inicia una sesión
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function login(Request $request, Response $response): void
    {
        $loginOrEmail = $request->getBody("loginOrEmail");
        $password = $request->getBody("password");
        $remember = $request->getBody("remember") ?? "0";

        $required = new Required();
        if (!$required->isValid($loginOrEmail) || !$required->isValid($password)) {
            $response->json([
                "status" => false,
                "message" => "Falta rellenar campos"
            ])->setStatusCode(400);
            return;
        }

        $authRepository = new AuthRepository();
        $result = $authRepository->login($loginOrEmail);

        if (!$result || count($result) < 1) {
            $response->json([
                "status" => false,
                "message" => "Sus credenciales no coinciden"
            ])->setStatusCode(400);
            return;
        }

        $passwordHashed = $result["password"];
        $userId = $result["user_id"];
        $userRole = $result["user_role"];
        $visible = $result["visible"];

        $passwordCheck = Crypto::verify($passwordHashed, $password);
        if (!$passwordCheck) {
            $response->json([
                "status" => false,
                "message" => "Sus credenciales no coinciden"
            ])->setStatusCode(400);
            return;
        }

        $session = new PhpSession();
        $session->set('userId', $userId);
        $session->set('loginOrEmail', $loginOrEmail);
        $session->set('role', $userRole);
        $session->set("visible", $visible);

        if ($remember)
        {
            $cookie = new PhpCookie();
            $cookie->set('loginOrEmail', $loginOrEmail, time() + 60 * 60 * 24 * 7);
            $cookie->set('password', $password, time() + 60 * 60 * 24 * 7);
            $cookie->set('remember', true, time() + 60 * 60 * 24 * 7);
        }
        else
        {
            $cookie = new PhpCookie();
            $cookie->set('loginOrEmail', "", time() - 3600);
            $cookie->set('password', "", time() - 3600);
            $cookie->set('remember', "", time() - 3600);
        }

        $response->json([
            "status" => true
        ]);
    }

    /**
     * Elimina la sesión
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function logout(Request $request, Response $response): void
    {
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function session(Request $request, Response $response)
    {
        $session = new PhpSession();
        $userId = $session->get('userId');
        $response->json(["id" => $userId]);
    }
}
