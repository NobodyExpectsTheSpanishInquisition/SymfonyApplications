<?php

declare(strict_types=1);

namespace App\Core\IndexUsers;

use App\Core\Shared\Request\CannotDenormalizeRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class IndexUsersController extends AbstractController
{
    public function index(
        Request $request,
        IndexUsersRequestDenormalizer $denormalizer,
        IndexUsersHandler $handler
    ): JsonResponse {
        try {
            $indexUsersRequest = $denormalizer->denormalize($request->query->all());
        } catch (CannotDenormalizeRequestException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new JsonResponse($handler->handle(new IndexUsersQuery($indexUsersRequest->paginator)));
    }
}
