<?php

namespace App\Record\Domain\Model;

use App\User\Domain\Model\User;
use Symfony\Component\Uid\Uuid;

class MedicalRecord
{
    private string $id;
    private User $doctor;
    private User $patient;
    private string $diagnosis;
    private string $treatment;
    private \DateTime $dateStart;

    private bool $isActive;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->isActive = true;
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

    public function getDiagnosis(): string
    {
        return $this->diagnosis;
    }

    public function setDiagnosis(string $diagnosis): void
    {
        $this->diagnosis = $diagnosis;
    }

    public function getTreatment(): string
    {
        return $this->treatment;
    }

    public function setTreatment(string $treatment): void
    {
        $this->treatment = $treatment;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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
