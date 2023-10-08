<?php

namespace App\Services;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FolderService
{

    public function createFolder(User $user, string $name): Folder
    {
        $folder = new Folder();
        $folder->setName($name);
        $user->folders()->save($folder);
        return $folder;
    }

    public function getUserFolders(User $user, $eagerLoads = []): Collection|null
    {
        return $user->folders()->with($eagerLoads)->get();
    }

    public function getUserFoldersByName(User $user, string $name): Collection|null
    {
        return $user->folders()->where('name', $name)->get();
    }
}
