<?php

namespace App\Record\Controller\Api;

use App\AbstractGeneralController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/record/me')]
class MeRecordController extends AbstractGeneralController
{
    #[Route('', name: '', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
