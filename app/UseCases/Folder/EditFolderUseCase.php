<?php

namespace App\UseCases\Folder;

use App\Models\Folder;
use App\Models\User;
use App\Services\FolderService;
use App\Services\UserService;
use Exception;

class EditFolderUseCase
{

    private int $userId;
    private int $folderId;
    private string $name;
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
    public function execute(int $userId, int $folderId, string $name): Folder
    {
        $this->userId = $userId;
        $this->folderId = $folderId;
        $this->name = $name;
        return $this->checkUserExists()
            ->getFolder()
            ->checkFolderIsFoUser()
            ->editFolder();
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
    private function checkFolderIsFoUser(): self
    {
        if ($this->folder->getUserId() !== $this->userId){
            throw new Exception("Folder not found");
        }
        return $this;
    }

    private function editFolder(): Folder
    {
        $this->folder->setName($this->name)->save();
        return $this->folder;
    }

}
