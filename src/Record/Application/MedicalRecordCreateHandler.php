<?php

namespace App\Record\Application;

use App\Commons\Helpers\ValidateConstraints;
use App\Record\Application\Command\MedicalRecordCreate;
use App\Record\Domain\Model\MedicalRecord;
use App\Record\Domain\Ports\MedicalRecordInterface;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class MedicalRecordCreateHandler
{
    public function __construct(
        private ValidateConstraints $validateConstraints,
        private MedicalRecordInterface $medicalRecord,
        private UserInterface $user,
    ) {
    }

    public function handle(MedicalRecordCreate $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $doctor = $this->user->findById($command->getDoctorId());
        $patient = $this->user->findById($command->getUserId());

        if (!$doctor || !$patient || !in_array(User::ROLE_DOCTOR, $doctor->getRoles())) {
            throw new BadRequestHttpException('Doctor or patient not found');
        }

        $record = new MedicalRecord();
        $record->setDoctor($doctor);
        $record->setPatient($patient);
        $record->setDateStart($command->getDateStart());
        $record->setDiagnosis($command->getDiagnosis());
        $record->setTreatment($command->getTreatment());

        $this->medicalRecord->save($record);
    }
}
