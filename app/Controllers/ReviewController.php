<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Review;
use CakeFactory\Repositories\ReviewRepository;
use CakeFactory\Repositories\ShoppingRepository;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules;
use Fibi\Validation\Rules\Uuid as RulesUuid;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Nonstandard\Uuid;

class ReviewController
{
    /**
     * Crea un comentario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response): void
    {
        $session = new PhpSession();
        $userId = $session->get("userId");

        $reviewId = Uuid::uuid4()->toString();
        $message = $request->getBody("message");
        $rate = $request->getBody("rate");
        $productId = $request->getRouteParams("productId");

        $shoppingRepository = new ShoppingRepository();
        $result = $shoppingRepository->exists($productId, $userId);
        if (!$result) {
            $response->setStatusCode(400)->json([
                "status" => false,
                "message" => "No ha comprado este producto"
            ]);
            return;
        }

        $review = new Review();
        $review
            ->setReviewId($reviewId)
            ->setMessage($message)
            ->setRate($rate)
            ->setProductId($productId)
            ->setUserId($userId);

        $validator = new Validator($review);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $reviewRepository = new ReviewRepository();
        $status = $reviewRepository->create($review);
        if (!$status) {
            $response->json([
                "status" => $status,
                "message" => "No se pudo crear la rese??a"
            ])->setStatusCode(400);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "La rese??a fue generada con ??xito"
        ]);
    }

    /**
     * Actualiza una review
     * Endpoint: PUT /api/v1/products/:productId/reviews/:reviewId
     * Creado por: Eliam Rodr??guez P??rez
     * Creado: 2022-10-27
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response): void
    {
        $session = new PhpSession();
        $userId = $session->get("userId");

        $reviewId = $request->getRouteParams("reviewId");
        $message = $request->getBody("message");
        $rate = $request->getBody("rate");
        $productId = $request->getRouteParams("productId");

        $review = new Review();
        $review
            ->setReviewId($reviewId)
            ->setMessage($message)
            ->setRate($rate)
            ->setProductId($productId)
            ->setUserId($userId);

        $validator = new Validator($review);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $reviewRepository = new ReviewRepository();
        $status = $reviewRepository->update($review);
        if (!$status) {
            $response->json([
                "status" => $status,
                "message" => "No se pudo actualizar la rese??a"
            ])->setStatusCode(400);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "La rese??a fue actualizada con ??xito"
        ]);
    }

    /**
     * Elimina una review
     * Endpoint: DELETE /api/v1/products/:productId/reviews/:reviewId
     * Creado por: Eliam Rodr??guez P??rez
     * Creado: 2022-10-27
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response): void
    {
        $reviewId = $request->getRouteParams("reviewId");

        $validations = [
            "rules" => [
                "reviewId" => [
                    new Required(),
                    new RulesUuid()
                ]
            ],
            "values" => [
                "reviewId" => &$reviewId
            ]
        ];

        $validator = new Validator($validations);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $commentRepository = new ReviewRepository();
        $status = $commentRepository->delete($reviewId);
        if (!$status) {
            $response->json([
                "status" => $status,
                "message" => "No se pudo eliminar la rese??a"
            ])->setStatusCode(400);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "La rese??a fue eliminada con ??xito"
        ]);
    }

    /**
     * Obtiene todos los comentarios de un producto
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getProductComments(Request $request, Response $response): void
    {
        // TODO: Validar que exista el ID
        $productId = $request->getRouteParams("productId");
        $validations = [
            "rules" => [
                "productId" => [
                    new Required("A"),
                    new RulesUuid("A")
                ]
            ],
            "values" => [
                "productId" => &$productId
            ]
        ];

        $validator = new Validator($validations);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $commentRepository = new ReviewRepository();
        $comments = $commentRepository->getAllByProduct($productId);
        /*
        if (!$comments) {
            $response->json([
                "status" => $status,
                "message" => "No se encontr?? nada"
            ])->setStatusCode(404);
            return;
        }
        */

        $response->json($comments);
    }
}
