<?php
namespace App\User\Domain\Dto;

class UserDTO
{
    public string $id;
    public string $name;
    public string $surNames;
    public string $email;
    public array $roles;
    public bool $isActive;
    public function __construct(
        string $id,
        string $name,
        string $surNames,
        string $email,
        array $roles,
        bool $isActive
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surNames = $surNames;
        $this->email = $email;
        $this->roles = $roles;
        $this->isActive = $isActive;
    }

}
