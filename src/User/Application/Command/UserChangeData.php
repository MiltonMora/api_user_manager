<?php

namespace App\User\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserChangeData
{
    #[Assert\NotBlank]
    private string $name;

    #[Assert\NotBlank]
    private string $surname;

    public function __construct(
        string $name,
        string $surname,
    ) {
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }
}
