<?php

namespace App\Record\Domain\Ports;

use App\Record\Domain\Model\Consultation;

interface ConsultationInterface
{
    public function save(Consultation $consultation): void;

    public function listAll(): array;

    public function findById(string $id): ?Consultation;
}
