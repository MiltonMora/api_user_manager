<?php

namespace App\Application\User\Command;

use Symfony\Component\Validator\Constraints as Assert;
readonly class UserCreate
{
    #[Assert\NotBlank]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(5)]
    private string $password;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'Este email {{ value }} No es valido',
    )]
    private string $email;

    public function __construct(string $name, string $password, string $email)
    {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}
