<?php

namespace App\Livewire\Note;

use App\UseCases\Note\DeleteNoteUseCase;
use App\UseCases\Note\NoteListUseCase;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NoteList extends Component
{
    private NoteListUseCase $noteListUseCase;
    private DeleteNoteUseCase $deleteNoteUseCase;
    public mixed $notes = [];
    public mixed $folderId;

    public function boot(NoteListUseCase $noteListUseCase,DeleteNoteUseCase $deleteNoteUseCase): void
    {
        $this->noteListUseCase = $noteListUseCase;
        $this->deleteNoteUseCase = $deleteNoteUseCase;
    }


    public function mount($id): void
    {
        $this->folderId = $id;
    }

    /**
     * @throws Exception
     */
    #[On('get-note-list')]
    public function noteList($folderId): void
    {
        $this->notes = $this->noteListUseCase->execute(Auth::id(),$folderId);
    }

    /**
     * @throws Exception
     */
    #[On('delete-note')]
    public function deleteFolder($folderId,$noteId): void
    {
        $this->deleteNoteUseCase->execute(Auth::id(),$folderId,$noteId);
        $this->dispatch('notify',message: "Note deleted");
        $this->noteList($folderId);
    }

    public function render()
    {
        return view('livewire.note.note-list');
    }
}
