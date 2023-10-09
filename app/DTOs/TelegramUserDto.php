<?php

namespace App\DTOs;

use JsonSerializable;

class TelegramUserDto implements JsonSerializable
{

    public function __construct(
        private readonly int    $id,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $username,
        private readonly string $languageCode,
        private readonly bool   $allowsWriteToPm,
    )
    {
    }

    public static function fromQuery(string $userQuery): self
    {
        $userArray = json_decode($userQuery, true);
        return new self(
            id: $userArray['id'],
            firstName: $userArray['first_name'],
            lastName: $userArray['last_name'],
            username: $userArray['username'],
            languageCode: $userArray['language_code'],
            allowsWriteToPm: $userArray['allows_write_to_pm']
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    public function isAllowsWriteToPm(): bool
    {
        return $this->allowsWriteToPm;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'username' => $this->getUsername(),
            'language_code' => $this->getLanguageCode(),
            'allows_write_to_pm' => $this->isAllowsWriteToPm(),
        ];
    }
}
