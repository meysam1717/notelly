<?php

namespace App\UseCases\Auth;

use App\DTOs\TelegramInitDataDto;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use App\Traits\TelegramTrait;
use Exception;

class AuthLoginUseCase
{

    use TelegramTrait;

    private string $initData;
    private TelegramInitDataDto $telegramInitDataDto;
    private User $user;

    public function __construct(
        private readonly UserService $userService,
        private readonly AuthService $authService,
    )
    {
    }

    public function execute(string $initData): bool
    {
        $this->initData = $initData;
        try {
            return $this->isTelegramDataValid()
                ->extractTelegramData()
                ->getOrCreateUserByTelegramId()
                ->loginUser();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    private function isTelegramDataValid(): self
    {
        $isValid = $this->validateInitData($this->initData);
        if (!$isValid) {
            throw new Exception('Telegram data is not valid');
        }
        return $this;
    }

    private function extractTelegramData(): self
    {
       $this->telegramInitDataDto = $this->extractInitData($this->initData);
       return $this;
    }

    private function getOrCreateUserByTelegramId(): self
    {
        $user = $this->userService->getUserByTelegramId($this->telegramInitDataDto->getTelegramUserDto()->getId());
        if (empty($this->user)){
            $user = $this->userService->createUserByTelegramData($this->telegramInitDataDto->getTelegramUserDto());
        }
        $this->user = $user;
        return $this;
    }

    private function loginUser(): bool
    {
        $this->authService->loginUser($this->user);
        return true;
    }

}
