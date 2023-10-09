<?php

namespace App\UseCases\Note;

use App\Models\Folder;
use App\Models\User;
use App\Services\FolderService;
use App\Services\NoteService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Collection;

class NoteListUseCase
{
    private int $userId;
    private int $folderId;

    private Folder $folder;
    private Collection $notes;

    public function __construct(
        private readonly UserService $userService,
        private readonly FolderService $folderService,
        private readonly NoteService $noteService,

    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $folderId): Collection
    {
        $this->userId = $userId;
        $this->folderId = $folderId;
        return $this->checkUserExists()
            ->getFolder()
            ->checkFolderIsFoUser()
            ->getNotes();
    }

    /**
     * @throws Exception
     */
    private function checkUserExists(): self
    {
        $user = $this->userService->getUserById($this->userId);
        if (!$user){
            throw new Exception("User not found");
        }
        return $this;
    }

    private function getFolder(): self
    {
        $this->folder = $this->folderService->getFolderById($this->folderId);
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

    private function getNotes(): Collection
    {
        return $this->noteService->getNoteListByFolder($this->folder);
    }

}
