<?php

namespace App\UseCases\Folder;

use App\Models\Folder;
use App\Models\User;
use App\Services\FolderService;
use App\Services\UserService;
use Exception;

class FolderInfoUseCase
{

    private int $userId;
    private int $folderId;
    private Folder $folder;

    public function __construct(
        private readonly UserService   $userService,
        private readonly FolderService $folderService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $folderId): Folder
    {
        $this->userId = $userId;
        $this->folderId = $folderId;
        return $this->checkUserExists()
            ->getFolder()
            ->checkFolderIsForUser();
    }

    /**
     * @throws Exception
     */
    private function checkUserExists(): self
    {
        $user = $this->userService->getUserById($this->userId);
        if (!$user) {
            throw new Exception("User not found");
        }
        return $this;
    }

    /**
     * @throws Exception
     */
    private function getFolder(): self
    {
        $folder = $this->folderService->getFolderById($this->folderId);
        if (!$folder){
            throw new Exception("Folder not found");
        }
        $this->folder = $folder;
        return $this;
    }

    /**
     * @throws Exception
     */
    private function checkFolderIsForUser(): Folder
    {
        if ($this->folder->getUserId() !== $this->userId){
            throw new Exception("Folder not found");
        }
        return $this->folder;
    }

}
