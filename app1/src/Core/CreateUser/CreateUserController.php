<?php

declare(strict_types=1);

namespace App\Core\CreateUser;

use App\Core\Shared\Dpi\UserDpiInterface;
use App\Core\Shared\Request\CannotDenormalizeRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateUserController extends AbstractController
{
    public function create(
        Request $request,
        CreateUserRequestDenormalizer $denormalizer,
        CreateUserHandler $createUserHandler,
        UserDpiInterface $userDpi
    ): JsonResponse {
        try {
            $createUserRequest = $denormalizer->denormalize($request->request->all());
        } catch (CannotDenormalizeRequestException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $createUserHandler->handle(new CreateUserCommand($createUserRequest->id, $createUserRequest->email));

        return new JsonResponse($userDpi->getById($createUserRequest->id), 201);
    }
}
