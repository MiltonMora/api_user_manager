<?php

namespace App\User\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserChangePassword
{
    #[Assert\NotBlank]
    private string $newPassword;

    private ?string $idUser;


    public function __construct(string $newPassword, ?string $idUser = null)
    {
        $this->newPassword = $newPassword;
        $this->idUser = $idUser;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getIdUser(): ?string
    {
        return $this->idUser;
    }


}
