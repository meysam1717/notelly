<?php

namespace App\UseCases\Folder;

use App\Models\Folder;
use App\Models\User;
use App\Services\FolderService;
use App\Services\UserService;
use Exception;
use Illuminate\Validation\ValidationException;

class StoreFolderUseCase
{

    private int $userId;
    private User $user;
    private string $name;

    public function __construct(
        private readonly FolderService $folderService,
        private readonly UserService $userService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(int $userId, string $name): Folder
    {
        $this->userId = $userId;
        $this->name = $name;
        return $this->getUser()
            ->checkFolderDuplicate()
            ->createFolder();

    }

    /**
     * @throws Exception
     */
    private function getUser(): self
    {
        $user = $this->userService->getUserById($this->userId);
        if (!$user){
            throw new Exception('User not found');
        }
        $this->user = $user;
        return $this;
    }

    /**
     * @throws Exception
     */
    private function checkFolderDuplicate(): self
    {
        $folders = $this->folderService->getUserFoldersByName($this->user, $this->name);
        if (count($folders) > 0){
            throw new Exception("Folder with name '{$this->name}' exists");
        }
        return $this;
    }

    private function createFolder(): Folder
    {
        return $this->folderService->createFolder($this->user, $this->name);
    }

}
