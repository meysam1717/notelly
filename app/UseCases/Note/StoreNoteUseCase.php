<?php

namespace App\UseCases\Note;

use App\Models\Folder;
use App\Models\Note;
use App\Services\FolderService;
use App\Services\NoteService;
use App\Services\UserService;
use Exception;

class StoreNoteUseCase
{

    private int $userId;
    private int $folderId;
    private string $title;
    private mixed $data;
    private Folder $folder;

    public function __construct(
        private readonly UserService   $userService,
        private readonly FolderService $folderService,
        private readonly NoteService $noteService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(int $userId, int $folderId, string $title, mixed $data): Note
    {
        $this->userId = $userId;
        $this->folderId = $folderId;
        $this->title = $title;
        $this->data = $data;
        return $this->checkUserExists()
            ->getFolder()
            ->checkFolderIsForUser()
            ->storeNote();
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
    private function checkFolderIsForUser(): self
    {
        if ($this->folder->getUserId() !== $this->userId){
            throw new Exception("Folder not found");
        }
        return $this;
    }

    private function storeNote(): Note
    {
        return $this->noteService->createNote($this->folder, $this->title, $this->data);
    }

}
