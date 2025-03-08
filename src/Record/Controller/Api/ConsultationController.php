<?php

namespace App\Record\Controller\Api;

use App\AbstractGeneralController;
use App\Record\Application\Command\ConsultationCreate;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/record/consultation')]
class ConsultationController extends AbstractGeneralController
{
    #[Route('/create', name: 'app_record_api_consultation_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new ConsultationCreate(
                $this->getContentValue('doctorId'),
                $this->getContentValue('userId'),
                $this->getContentValue('medicalRecordId'),
                new \DateTime($this->getContentValue('dateStart')),
                $this->getContentValue('dateEnd') ? new \DateTime($this->getContentValue('dateEnd')) : null,
                $this->getContentValue('notes'),
            ));

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
