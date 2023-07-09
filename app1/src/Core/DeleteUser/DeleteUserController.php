<?php

declare(strict_types=1);

namespace App\Core\DeleteUser;

use App\Core\Shared\ValueObject\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DeleteUserController extends AbstractController
{
    public function delete(string $id, DeleteUserHandler $handler): JsonResponse
    {
        $userId = new Uuid($id);

        $handler->handle(new DeleteUserCommand($userId));

        return new JsonResponse(null, 204);
    }
}
