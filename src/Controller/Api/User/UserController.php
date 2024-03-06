<?php

namespace App\Controller\Api\User;

use App\Application\User\Command\UserCreate;
use App\Controller\AbstractGeneralController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user')]
class UserController extends AbstractGeneralController
{
    #[Route('/create', name: 'app_user_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(
                new UserCreate(
                    $request->request->get('name'),
                    $request->request->get('password'),
                    $request->request->get('email'))
            );
            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
