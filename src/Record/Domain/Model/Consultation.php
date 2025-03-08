<?php

namespace App\Record\Domain\Model;

use App\User\Domain\Model\User;
use Symfony\Component\Uid\Uuid;

class Consultation
{
    private string $id;
    private User $doctor;
    private User $patient;
    private MedicalRecord $medicalRecord;
    private \DateTime $dateStart;
    private ?\DateTime $dateEnd;

    private string $notes;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getDoctor(): User
    {
        return $this->doctor;
    }

    public function setDoctor(User $doctor): void
    {
        $this->doctor = $doctor;
    }

    public function getPatient(): User
    {
        return $this->patient;
    }

    public function setPatient(User $patient): void
    {
        $this->patient = $patient;
    }

    public function getMedicalRecord(): MedicalRecord
    {
        return $this->medicalRecord;
    }

    public function setMedicalRecord(MedicalRecord $medicalRecord): void
    {
        $this->medicalRecord = $medicalRecord;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTime $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
