<?php

namespace App\User\Domain\Model;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\Uuid;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_DOCTOR = 'ROLE_DOCTOR';
    public const ROLE_PATIENT = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    private string $id;
    private string $name;
    private string $surnames;
    private ?string $phone;
    private ?string $country;
    private ?string $community;
    private ?string $address;

    #[Ignore]
    private string $password;
    private string $email;
    private array $roles;
    private bool $isActive;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->isActive = true;
    }

    public function setName(string $name): void
    {
        $this->name = ucfirst(strtolower($name));
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower($email);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getSurnames(): string
    {
        return $this->surnames;
    }

    public function setSurnames(string $surnames): void
    {
        $this->surnames = ucfirst(strtolower($surnames));
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getCommunity(): ?string
    {
        return $this->community;
    }

    public function setCommunity(?string $community): void
    {
        $this->community = $community;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
