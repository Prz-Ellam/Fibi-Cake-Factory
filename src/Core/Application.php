<?php

namespace Fibi\Core;

use Closure;
use Fibi\Database\DatabaseDriver;
use Fibi\Http\Request;
use Fibi\Http\RequestBuilder;
use Fibi\Http\Response;
use Fibi\Http\ResponseEmitter;
use Fibi\Routing\Router;
use Fibi\View\ViewEngine;

/**
 * Kernel basico de la aplicacion que almacena todos los modulos
 */
class Application
{
    /**
     * Enruteador de direcciones
     *
     * @var Router
     */
    public Router $router;

    /**
     * Petición HTTP solicitada
     *
     * @var Request
     */
    public Request $request;

    /**
     * Motor de renderizado de vistas
     *
     * @var ViewEngine
     */
    public ViewEngine $viewEngine;

    /**
     * El controlador de la base de datos
     *
     * @var DatabaseDriver
     */
    public DatabaseDriver $database;

    /**
     * Middlewares de la aplicación
     *
     * @var array
     */
    public array $middlewares;

    /**
     * Instancia de la aplicación
     *
     * @var self
     */
    private static self $instance;

    private function __construct()
    {
        $this->router = new Router();
        $this->request = RequestBuilder::createFromPhpServer();
        $this->viewEngine = new ViewEngine(__DIR__ . "//..//..//frontend");
        $this->viewEngine->setMainLayout("main");
        $this->database = new DatabaseDriver();
    }

    /**
     * Obtiene la instancia de la aplicación
     *
     * @return self Instancia de la aplicación
     */
    public static function app(): self
    {
        if (!isset(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Corre la aplicación y prepara la busqueda de la ruta
     *
     * @return void
     */
    public function run(): void
    {
        $action = $this->router->resolve($this->request);
        $response = new Response();
        $responseEmitter = new ResponseEmitter();

        if (!$action)
        {
            $response
                ->text("404 Not Found")
                ->setStatusCode(404);
        }
        else
        {
            call_user_func($action, $this->request, $response);
        }

        $responseEmitter->emitResponse($response);
        $this->database->close();
    }

    /**
     * Registra una ruta de tipo GET
     *
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
    public function get(string $uri, Closure|array $action): void
    {
        $this->router->get($uri, $action);
    }

    /**
     * Registra una ruta de tipo POST
     *
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
    public function post(string $uri, Closure|array $action): void
    {
        $this->router->post($uri, $action);
    }

    /**
     * Registra una ruta de tipo PUT
     *
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
    public function put(string $uri, Closure|array $action): void
    {
        $this->router->put($uri, $action);
    }

    /**
     * Registra una ruta de tipo PATCH
     *
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
    public function patch(string $uri, Closure|array $action): void
    {
        $this->router->patch($uri, $action);
    }

    /**
     * Registra una ruta de tipo DELETE
     *
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
    public function delete(string $uri, Closure|array $action): void
    {
        $this->router->delete($uri, $action);
    }

    public function addMiddleware(Closure|array $action)
    {
        $this->middlewares[] = $action;
    }
}
