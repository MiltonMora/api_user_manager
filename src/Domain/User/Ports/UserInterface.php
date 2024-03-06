<?php

namespace App\Domain\User\Ports;

use App\Domain\User\Model\User;

interface UserInterface
{
    public function save(User $user): void;
}
