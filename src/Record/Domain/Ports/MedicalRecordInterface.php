<?php

namespace App\Record\Domain\Ports;

use App\Record\Domain\Model\MedicalRecord;

interface MedicalRecordInterface
{
    public function save(MedicalRecord $medicalRecord): void;

    public function listAll(): array;

    public function findById(string $id): ?MedicalRecord;
}
