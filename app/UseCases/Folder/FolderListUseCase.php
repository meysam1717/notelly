<?php

namespace App\UseCases\Folder;

use App\Models\Folder;
use App\Models\User;
use App\Services\FolderService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Collection;

class FolderListUseCase
{
    private int $userId;
    private User $user;
    private Collection $folders;

    public function __construct(
        private readonly FolderService $folderService,
        private readonly UserService $userService,

    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(int $userId): Collection
    {
        $this->userId = $userId;
        return $this->getUser()
            ->getFolders()
            ->prepareFoldersData();
    }

    /**
     * @throws Exception
     */
    private function getUser(): self
    {
        $user = $this->userService->getUserById($this->userId);
        if (!$user){
            throw new Exception("User not found");
        }
        $this->user = $user;
        return $this;
    }

    private function getFolders(): self
    {
        $this->folders = $this->folderService->getUserFoldersWithNotesCount(
            user: $this->user,
        );
        return $this;
    }

    private function prepareFoldersData(): Collection
    {
        return $this->folders->map(function (Folder $folder){
            $folder['notes'] = [
                'count' => $folder->notes_count === 0 ? null: $folder->notes_count,
                'title' => $this->prePareNotesCountTitle($folder->notes_count),
            ];
            unset($folder['notes_count']);
            return $folder;
        });
    }

    private function prePareNotesCountTitle(int $count): string
    {
        return match ($count){
            0 => "Empty",
            1 => "Item",
            default => "Items",
        };
    }

}
