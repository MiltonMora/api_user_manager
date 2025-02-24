<?php

namespace App\User\Controller\Api;

use App\AbstractGeneralController;
use App\User\Application\Command\UserChangeData;
use App\User\Application\Command\UserChangePassword;
use App\User\Application\Command\UserChangeStatus;
use App\User\Application\Command\UserCreate;
use App\User\Application\Command\UserGetById;
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
                    $this->getContentValue('name'),
                    $this->getContentValue('surname'),
                    $this->getContentValue('password'),
                    $this->getContentValue('email'),
                    $this->getContentValue('phone'),
                    $this->getContentValue('address'),
                    $this->getContentValue('country'),
                    $this->getContentValue('rol'),
                    $this->getContentValue('community'))
            );

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
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
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{userId}', name: 'app_user_get', methods: ['GET'])]
    public function getUserById(string $userId): JsonResponse
    {
        try {
            return $this->json($this->commandBus->handle(new UserGetById($userId)), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/change-password', name: 'app_user_admin_change_password', methods: ['POST'])]
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(
                new UserChangePassword(
                    $this->getContentValue('newPassword'),
                    $this->getContentValue('userId')
                )
            );

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/change-status', name: 'app_user_admin_inactive', methods: ['PUT'])]
    public function inactive(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(
                new UserChangeStatus($this->getContentValue('userId')));

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/change-data', name: 'app_admin_user_change_data', methods: ['PUT'])]
    public function changeData(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new UserChangeData(
                $this->getContentValue('name'),
                $this->getContentValue('surname'),
                $this->getContentValue('id')
            ));

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
