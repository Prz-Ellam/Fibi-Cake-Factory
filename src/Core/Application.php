<?php

namespace Fibi\Core;

use Closure;
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
    }

    /**
     * Obtiene la instancia de la aplicación
     *
     * @return self Instancia de la aplicación
     */
    public static function app() : self
    {
        if (!isset(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Prepare the requested router to be found
     *
     * @return void
     */
    public function run() : void
    {
        $action = $this->router->resolve($this->request);

        if ($action == null)
        {
            print("404 Not found");
            die;
        }

        $response = new Response();

        call_user_func($action, $this->request, $response);

        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emitResponse($response);
    }

    public function get(string $uri, Closure|array $action)
    {
        $this->router->get($uri, $action);
    }

    public function post(string $uri, Closure|array $action)
    {
        $this->router->post($uri, $action);
    }

    public function put(string $uri, Closure|array $action)
    {
        $this->router->put($uri, $action);
    }

    public function patch(string $uri, Closure|array $action)
    {
        $this->router->patch($uri, $action);
    }

    public function delete(string $uri, Closure|array $action)
    {
        $this->router->delete($uri, $action);
    }
}

?>