<?php

declare(strict_types=1);

namespace App\Core\UpdateUser;

use App\Core\Shared\Dpi\UserDpiInterface;
use App\Core\Shared\Repository\Exception\NotFoundException;
use App\Core\Shared\Request\CannotDenormalizeRequestException;
use App\Core\Shared\ValueObject\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class UpdateUserController extends AbstractController
{
    public function update(
        string $id,
        Request $request,
        UpdateUserRequestDenormalizer $denormalizer,
        UpdateUserHandler $updateUserHandler,
        UserDpiInterface $userDpi
    ): JsonResponse {
        $userId = new Uuid($id);
        try {
            $updateUserRequest = $denormalizer->denormalize($request->request->all());
        } catch (CannotDenormalizeRequestException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        try {
            $updateUserHandler->handle(new UpdateUserCommand($userId, $updateUserRequest->email));
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (CannotUpdateUserException $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        try {
            return new JsonResponse($userDpi->getById($userId));
        } catch (\App\Core\Shared\Dpi\NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
