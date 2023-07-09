<?php

declare(strict_types=1);

namespace App\Core\GetUser;

use App\Core\Shared\Repository\Exception\NotFoundException;
use App\Core\Shared\ValueObject\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetUserController extends AbstractController
{
    public function get(string $id, GetUserHandler $handler): JsonResponse
    {
        try {
            return new JsonResponse($handler->handle(new GetUserQuery(new Uuid($id))));
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
