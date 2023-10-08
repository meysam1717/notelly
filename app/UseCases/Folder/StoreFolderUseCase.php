<?php

namespace App\UseCases\Folder;

use App\Models\Folder;
use App\Models\User;
use App\Services\FolderService;
use Illuminate\Validation\ValidationException;

class StoreFolderUseCase
{

    private User $user;
    private string $name;

    public function __construct(
        private readonly FolderService $folderService,
    )
    {
    }

    public function execute(User $user, string $name): Folder
    {
        $this->user = $user;
        $this->name = $name;
        return $this->checkFolderDuplicate()
            ->createFolder();

    }


    /**
     * @throws ValidationException
     */
    private function checkFolderDuplicate(): self
    {
        $folders = $this->folderService->getUserFoldersByName($this->user, $this->name);
        if (!empty($folders)){
            throw new ValidationException("Folder with name '{$this->name}' exists");
        }
        return $this;
    }

    private function createFolder(): Folder
    {
        return $this->folderService->createFolder($this->user, $this->name);
    }

}
