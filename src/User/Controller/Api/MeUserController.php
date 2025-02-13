<?php

namespace App\User\Controller\Api;

use App\AbstractGeneralController;
use App\User\Application\Command\UserChangeData;
use App\User\Application\Command\UserChangePassword;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/me/user')]
class MeUserController extends AbstractGeneralController
{
    #[Route('/change-password', name: 'app_user_change_password', methods: ['POST'])]
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new UserChangePassword($this->getContentValue('newPassword')));

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/change-data', name: 'app_user_change_data', methods: ['PUT'])]
    public function changeData(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new UserChangeData(
                $this->getContentValue('name'),
                $this->getContentValue('surName')
            ));

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
