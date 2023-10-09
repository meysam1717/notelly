<?php

namespace App\Services;

use App\Models\Folder;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NoteService
{

    public function getNoteListByFolder(Folder $folder): Collection
    {
        return $folder->notes()->get();
    }

    public function getNoteById(int $noteId): ?Note
    {
        return Note::query()->where('id', $noteId)->first();
    }

    public function createNote(Folder $folder, string $title, ?string $data): Note
    {
        $note = new Note();
        $note->setTitle($title)
            ->setData($data)
            ->save();
        $folder->notes()->save($note);
        return $note;
    }

    public function editNote(Note $note, string $title, ?string $data): Note
    {
        $note->setTitle($title)
            ->setData($data)
            ->save();
        return $note;
    }

    public function deleteNote(Note $note): bool
    {
        return $note->delete();
    }

}
