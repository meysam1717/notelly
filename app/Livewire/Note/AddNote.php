<?php

namespace App\Livewire\Note;

use App\UseCases\Note\StoreNoteUseCase;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddNote extends Component
{
    private StoreNoteUseCase $storeNoteUseCase;

    #[Rule('required|min:2|max:30')]
    public string $title = '';

    public int $folderId;

    public mixed $note;


    public function boot(StoreNoteUseCase $storeNoteUseCase): void
    {
        $this->storeNoteUseCase = $storeNoteUseCase;
    }

    public function mount($id): void
    {
        $this->folderId = $id;
    }

    /**
     * @throws Exception
     */
    #[On('save-new-note')]
    public function save($note,$folderId)
    {
        $this->validate();
        $this->storeNoteUseCase->execute(Auth::id(),$folderId,$this->title,$note);
        $this->reset(['title']);
        $this->dispatch('notify', message: "Note Saved");
        return redirect()->route('note-list',['id'=>$folderId]);
    }


    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.note.add-note');
    }
}
