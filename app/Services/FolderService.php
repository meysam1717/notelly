<?php

namespace App\Services;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FolderService
{

    public function getFolderById(int $folderId): ?Folder
    {
        return Folder::query()->where('id', $folderId)->first();
    }
    public function createFolder(User $user, string $name): Folder
    {
        $folder = new Folder();
        $folder->setName($name);
        $user->folders()->save($folder);
        return $folder;
    }

    public function getUserFoldersWithNotesCount(User $user): Collection|null
    {
        return $user->folders()->withCount('notes')->get();
    }

    public function getUserFoldersByName(User $user, string $name): Collection|null
    {
        return $user->folders()->where('name', $name)->get();
    }
}
