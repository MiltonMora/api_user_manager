<?php

namespace App\User\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserChangeData
{
    #[Assert\NotBlank]
    private string $name;

    #[Assert\NotBlank]
    private string $surname;

    private ?string $id;

    public function __construct(
        string $name,
        string $surname,
        ?string $id = null,
    ) {
        $this->name = $name;
        $this->surname = $surname;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
