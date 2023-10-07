<?php

namespace App\Services;

use App\Models\Folder;

class FolderService
{

    public function createFolder(int|string $userid, string $name): Folder
    {
        $folder = new Folder();
        $folder->setUserId($userid)
            ->setName($name)
            ->save();
        return $folder;
    }

}
