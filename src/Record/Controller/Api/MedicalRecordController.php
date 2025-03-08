<?php

namespace App\Record\Controller\Api;

use App\AbstractGeneralController;
use App\Record\Application\Command\MedicalRecordCreate;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/record/medical-record')]
class MedicalRecordController extends AbstractGeneralController
{
    #[Route('/create', name: 'app_record_api_medical_record_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new MedicalRecordCreate(
                $this->getContentValue('doctorId'),
                $this->getContentValue('userId'),
                $this->getContentValue('diagnosis'),
                $this->getContentValue('treatment'),
                new \DateTime($this->getContentValue('dateStart')))
            );

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
