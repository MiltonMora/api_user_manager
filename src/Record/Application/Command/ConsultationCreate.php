<?php

namespace App\Record\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ConsultationCreate
{
    #[Assert\NotBlank]
    private string $doctorId;

    #[Assert\NotBlank]
    private string $userId;

    #[Assert\NotBlank]
    private string $medicalRecordId;
    #[Assert\NotBlank]
    private \DateTime $dateStart;
    private ?\DateTime $dateEnd;

    private ?string $notes;

    public function __construct(
        string $doctorId,
        string $userId,
        string $medicalRecordId,
        \DateTime $dateStart,
        ?\DateTime $dateEnd,
        ?string $notes,
    ) {
        $this->doctorId = $doctorId;
        $this->userId = $userId;
        $this->medicalRecordId = $medicalRecordId;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->notes = $notes;
    }

    public function getDoctorId(): string
    {
        return $this->doctorId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getMedicalRecordId(): string
    {
        return $this->medicalRecordId;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }
}
