<?php

namespace App\Record\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class MedicalRecordCreate
{
    #[Assert\NotBlank]
    private string $doctorId;

    #[Assert\NotBlank]
    private string $userId;

    #[Assert\NotBlank]
    private string $diagnosis;
    #[Assert\NotBlank]
    private string $treatment;
    #[Assert\NotBlank]
    private \DateTime $dateStart;

    public function __construct(
        string $doctorId,
        string $userId,
        string $diagnosis,
        string $treatment,
        \DateTime $dateStart,
    ) {
        $this->doctorId = $doctorId;
        $this->userId = $userId;
        $this->diagnosis = $diagnosis;
        $this->treatment = $treatment;
        $this->dateStart = $dateStart;
    }

    public function getDoctorId(): string
    {
        return $this->doctorId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getDiagnosis(): string
    {
        return $this->diagnosis;
    }

    public function getTreatment(): string
    {
        return $this->treatment;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }
}
