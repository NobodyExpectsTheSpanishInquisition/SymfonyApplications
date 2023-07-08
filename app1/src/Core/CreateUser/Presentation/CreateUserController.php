<?php

declare(strict_types=1);

namespace App\Core\CreateUser\Presentation;

use App\Core\Shared\Request\CannotDenormalizeRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateUserController extends AbstractController
{
    public function create(Request $request, CreateUserRequestDenormalizer $denormalizer): JsonResponse
    {
        try {
            $createUserRequest = $denormalizer->denormalize($request->request->all());
        } catch (CannotDenormalizeRequestException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new JsonResponse(null, 201);
    }
}
