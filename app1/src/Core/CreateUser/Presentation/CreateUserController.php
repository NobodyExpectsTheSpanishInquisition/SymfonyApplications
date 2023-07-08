<?php

declare(strict_types=1);

namespace App\Core\CreateUser\Presentation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateUserController extends AbstractController
{
    public function create(Request $request, CreateUserRequestDenormalizer $denormalizer): JsonResponse
    {
        $createUserRequest = $denormalizer->denormalize($request->request->all());
//        $test = $denormalizer->denormalize(json_encode($request->request->all()), CreateUserRequest::class,);

        return new JsonResponse(null, 201);
    }
}
