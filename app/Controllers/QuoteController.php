<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\QuoteRepository;
use Fibi\Http\Request;
use Fibi\Http\Response;

class QuoteController
{
    public function create(Request $request, Response $response) {
        
    }


    public function getUserAllPending(Request $request, Response $response) {

        // Obtener el ID
        $queryUserId = $request->getQuery("userId") ?? "";

        // Validar que este autorizado

        // Validar que es el usuario

        // Obtener los datos
        $quoteRepository = new QuoteRepository();
        $quotes = $quoteRepository->getUserAllPending($queryUserId);

        // Validar que esten los datos

        // Devolver
        $response->json($quotes);

    }
}
