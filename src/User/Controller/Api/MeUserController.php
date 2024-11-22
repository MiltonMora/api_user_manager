<?php

namespace App\User\Controller\Api;

use App\AbstractGeneralController;
use App\User\Application\Command\UserChangePassword;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/me/user')]
class MeUserController extends AbstractGeneralController
{
    #[Route('/change-password', name: 'app_user_change_password', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new UserChangePassword($request->request->get('newPassword')));
            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
