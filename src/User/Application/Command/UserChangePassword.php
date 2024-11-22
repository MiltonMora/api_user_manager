<?php

namespace App\User\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserChangePassword
{

    #[Assert\NotBlank]
    private string $newPassword;


    public function __construct(string $newPassword)
    {
        $this->newPassword = $newPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }


}
