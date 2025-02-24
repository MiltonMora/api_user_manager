<?php

namespace App\User\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserCreate
{
    #[Assert\NotBlank]
    private string $name;

    #[Assert\NotBlank]
    private string $surname;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(5)]
    private string $password;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'Este email {{ value }} No es valido',
    )]
    private string $email;

    private ?string $phone;
    private ?string $address;
    private ?string $country;
    private ?string $community;

    #[Assert\NotBlank]
    private string $rol;

    public function __construct(
        string $name,
        string $surname,
        string $password,
        string $email,
        ?string $phone,
        ?string $address,
        ?string $country,
        ?string $rol,
        ?string $community)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->country = $country;
        $this->community = $community;
        $this->rol = $rol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCommunity(): ?string
    {
        return $this->community;
    }

    public function getRol(): string
    {
        return $this->rol;
    }
}
