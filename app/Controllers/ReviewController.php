<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Review;
use CakeFactory\Repositories\ReviewRepository;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules;
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
    public function create(Request $request, Response $response) : void
    {
        $session = new PhpSession();

        $reviewId = Uuid::uuid4()->toString();
        $message = $request->getBody("message");
        $productId = $request->getRouteParams("productId");
        $userId = $session->get("userId");

        $review = new Review();
        $review
            ->setReviewId($reviewId)
            ->setMessage($message)
            ->setRate(5)
            ->setProductId($productId)
            ->setUserId($userId);

        $validator = new Validator($review);
        $feedback = $validator->validate();
        $status = $validator->getStatus();

        if (!$status)
        {
            $response->json([
                "status" => $status,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $commentRepository = new ReviewRepository();
        $status = $commentRepository->create($review);
        if (!$status)
        {
            $response->json([
                "status" => $status,
                "message" => "No se pudo crear el mensaje"
            ])->setStatusCode(400);
            return;
        }

        $response->json([
            "status" => true,
            "productId" => $productId,
            "message" => $message,
            "userId" => $userId
        ]);
    }

    public function getProductComments(Request $request, Response $response) : void
    {
        $productId = $request->getRouteParams("productId");

        $required = new Required();
        $uuid = new Rules\Uuid();
        if (!$required->isValid($productId) || !$uuid->isValid($productId))
        {
            $response->text("404 Not Found")->setStatusCode(404);
            return;
        }

        $commentRepository = new ReviewRepository();
        $comments = $commentRepository->getAllByProduct($productId);

        $response->json($comments);
    }
}
