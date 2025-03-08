<?php

namespace App\Record\Application;

use App\Commons\Helpers\ValidateConstraints;
use App\Record\Application\Command\ConsultationCreate;
use App\Record\Domain\Model\Consultation;
use App\Record\Domain\Ports\ConsultationInterface;
use App\Record\Domain\Ports\MedicalRecordInterface;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class ConsultationCreateHandler
{
    public function __construct(
        private ValidateConstraints $validateConstraints,
        private MedicalRecordInterface $medicalRecord,
        private UserInterface $user,
        private ConsultationInterface $consultationInterface,
    ) {
    }

    public function handle(ConsultationCreate $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $doctor = $this->user->findById($command->getDoctorId());
        $patient = $this->user->findById($command->getUserId());
        $record = $this->medicalRecord->findById($command->getMedicalRecordId());

        if (!$doctor || !$patient || !$record || !in_array(User::ROLE_DOCTOR, $doctor->getRoles())) {
            throw new BadRequestHttpException('Doctor or patient or Medical Record not found');
        }
        if ($record->getPatient() !== $patient) {
            throw new BadRequestHttpException('Patient not assigned in this Medical Record');
        }

        $consultation = new Consultation();
        $consultation->setDoctor($doctor);
        $consultation->setPatient($patient);
        $consultation->setMedicalRecord($record);
        $consultation->setDateStart($command->getDateStart());
        $consultation->setDateEnd($command->getDateEnd());
        $consultation->setNotes($command->getNotes());

        $this->consultationInterface->save($consultation);
    }
}
