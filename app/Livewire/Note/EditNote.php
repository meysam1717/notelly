<?php

namespace App\Livewire\Note;

use App\UseCases\Folder\StoreFolderUseCase;
use App\UseCases\Note\EditNoteUseCase;
use App\UseCases\Note\NoteInfoUseCase;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditNote extends Component
{
    private NoteInfoUseCase $noteInfoUseCase;
    private EditNoteUseCase $editNoteUseCase;


    #[Rule('required|min:2|max:30')]
    public string $title = '';

    public int $folderId;
    public int $noteId;


    public function mount($id, $noteId){
        $this->folderId = $id;
        $this->noteId = $noteId;
    }

    public function boot(NoteInfoUseCase $noteInfoUseCase,EditNoteUseCase $editNoteUseCase): void
    {
        $this->noteInfoUseCase = $noteInfoUseCase;
        $this->editNoteUseCase = $editNoteUseCase;
    }


    /**
     * @throws Exception
     */
    #[On('get-note-info')]
    public function noteInfo($folderId,$noteId): void
    {
        $note = $this->noteInfoUseCase->execute(Auth::id(),$folderId,$noteId);
        $this->title = $note->title;
        $this->dispatch('loadEditorJs',data: json_encode($note->data));
    }

    /**
     * @throws Exception
     */
    #[On('update-note')]
    public function save($note,$folderId,$noteId)
    {
        $this->validate();
        try {
            $this->editNoteUseCase->execute(Auth::id(),$folderId,$noteId,$this->title,$note);
            $this->reset(['title']);
            $this->dispatch('notify',message: "Note Updated");
            return redirect()->route('note-list',['id'=>$folderId]);
        }catch (Exception $e){
            $this->addError('title', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.note.edit-note');
    }
}
