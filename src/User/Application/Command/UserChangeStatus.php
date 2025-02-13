<?php

namespace App\User\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserChangeStatus
{
    #[Assert\NotBlank]
    private string $idUser;

    public function __construct(string $idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdUser(): string
    {
        return $this->idUser;
    }
}
