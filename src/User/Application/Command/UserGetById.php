<?php

namespace App\User\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;
readonly class UserGetById
{
    #[Assert\NotBlank]
    private string $userId;
    public function __construct(string $userId) {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

}
