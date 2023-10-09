<?php

namespace App\UseCases\Note;

use App\Models\Folder;
use App\Models\Note;
use App\Services\FolderService;
use App\Services\NoteService;
use App\Services\UserService;
use Exception;

class EditNoteUseCase
{

    private int $userId;
    private int $folderId;
    private int $noteId;
    private string $title;
    private ?string $data;
    private Folder $folder;
    private Note $note;

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
    public function execute(int $userId, int $folderId, int $noteId, string $title, ?string $data): Note
    {
        $this->userId = $userId;
        $this->folderId = $folderId;
        $this->noteId = $noteId;
        $this->title = $title;
        $this->data = $data;
        return $this->checkUserExists()
            ->getFolder()
            ->checkFolderIsForUser()
            ->getNote()
            ->checkNoteIsForFolder()
            ->editNote();
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

    /**
     * @throws Exception
     */
    private function getNote(): self
    {
        $note = $this->noteService->getNoteById($this->noteId);
        if (!$note){
            throw new Exception("Note not found");
        }
        $this->note = $note;
        return $this;
    }


    /**
     * @throws Exception
     */
    private function checkNoteIsForFolder(): self
    {
        if ($this->note->getFolderId() !== $this->folderId){
            throw new Exception("Note not found");
        }
        return $this;
    }


    private function editNote(): Note
    {
        return $this->noteService->editNote($this->note, $this->title, $this->data);
    }

}
