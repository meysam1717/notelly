<?php

namespace App\Services;

use App\DTOs\TelegramUserDto;
use App\Models\User;

class UserService
{

    public function getUserByTelegramId(int|string $telegramId): ?User
    {
        return User::query()->where('telegram_id', $telegramId)->first();
    }

    public function createUserByTelegramData(TelegramUserDto $telegramUserDto): User
    {
        $user = new User();
        $user->setTelegramId($telegramUserDto->getId())
            ->setFirstName($telegramUserDto->getFirstName())
            ->setLastName($telegramUserDto->getLastName())
            ->setUsername($telegramUserDto->getUsername())
            ->setLanguageCode($telegramUserDto->getLanguageCode())
            ->setAllowsWriteToPm($telegramUserDto->isAllowsWriteToPm())
            ->save();
        return $user;
    }

    public function getUserById(int $userId): ?User
    {
        return User::query()->where('id', $userId)->first();
    }

}
