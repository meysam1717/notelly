<?php

namespace App\UseCases\Auth;

use App\Constants\AppConstants;
use App\DTOs\TelegramInitDataDto;
use App\Models\User;
use App\Services\AuthService;
use App\Services\FolderService;
use App\Services\UserService;
use App\Traits\TelegramTrait;
use Exception;
use Illuminate\Validation\ValidationException;

class LoginByTelegramUseCase
{

    use TelegramTrait;

    private string $initData;
    private TelegramInitDataDto $telegramInitDataDto;
    private User $user;
    private bool $userNotExists;

    public function __construct(
        private readonly UserService   $userService,
        private readonly AuthService   $authService,
        private readonly FolderService $folderService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(string $initData): bool
    {
        $this->initData = $initData;
        return $this->isTelegramDataValid()
            ->extractTelegramData()
            ->getUserByTelegramId()
            ->createUserByTelegramIdIfNotExists()
            ->createDefaultFolderIfUserDoesNotExists()
            ->loginUser();
    }

    /**
     * @throws Exception
     */
    private function isTelegramDataValid(): self
    {
        try {
            $isValid = $this->validateInitData($this->initData);
            if (!$isValid) {
                throw new Exception();
            }
        } catch (Exception $e) {
            throw new Exception('Telegram data is not valid');
        }
        return $this;
    }

    private function extractTelegramData(): self
    {
        $this->telegramInitDataDto = $this->extractInitData($this->initData);
        return $this;
    }

    private function getUserByTelegramId(): self
    {
        $user = $this->userService->getUserByTelegramId($this->telegramInitDataDto->getTelegramUserDto()->getId());
        if (empty($user)) {
            $this->userNotExists = true;
        } else {
            $this->userNotExists = false;
            $this->user = $user;
        }
        return $this;
    }

    private function createUserByTelegramIdIfNotExists(): self
    {
        if ($this->userNotExists) {
            $this->user = $this->userService->createUserByTelegramData($this->telegramInitDataDto->getTelegramUserDto());
        }
        return $this;
    }

    private function createDefaultFolderIfUserDoesNotExists(): self
    {
        if ($this->userNotExists) {
            $this->folderService->createFolder($this->user, AppConstants::DEFAULT_FOLDER_NAME);
        }
        return $this;
    }

    private function loginUser(): bool
    {
        $this->authService->loginUser($this->user);
        return true;
    }

}
