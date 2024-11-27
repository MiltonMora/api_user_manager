<?php

namespace App\User\Controller\Api;

use App\AbstractGeneralController;
use App\User\Application\Command\UserChangePassword;
use App\User\Application\Command\UserCreate;
use App\User\Application\Command\UserList;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class AdminUserController extends AbstractGeneralController
{
    #[Route('/create', name: 'app_user_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(
                new UserCreate(
                    $request->request->get('name'),
                    $request->request->get('surname'),
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

    #[Route('/list', name: 'app_user_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        try {
            return $this->json($this->commandBus->handle(new UserList()), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/change-password', name: 'app_user_admin_change_password', methods: ['POST'])]
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(
                new UserChangePassword(
                    $request->request->get('newPassword'),
                    $request->request->get('userId'))
            );
            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
