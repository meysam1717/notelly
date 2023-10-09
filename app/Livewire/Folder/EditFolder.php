<?php

namespace App\Livewire\Folder;

use App\UseCases\Folder\EditFolderUseCase;
use App\UseCases\Folder\FolderInfoUseCase;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditFolder extends Component
{
    private FolderInfoUseCase $folderInfoUseCase;
    private EditFolderUseCase $editFolderUseCase;


    #[Rule('required|min:2|max:10')]
    public string $name = '';


    public function boot(FolderInfoUseCase $folderInfoUseCase,EditFolderUseCase $editFolderUseCase): void
    {
        $this->folderInfoUseCase = $folderInfoUseCase;
        $this->editFolderUseCase = $editFolderUseCase;
    }


    /**
     * @throws Exception
     */
    #[On('get-folder-info')]
    public function folderInfo($folderId): void
    {
        $this->name = $this->folderInfoUseCase->execute(Auth::id(),$folderId)->name;
    }

    /**
     * @throws Exception
     */
    #[On('update-folder')]
    public function save($folderId)
    {
        $this->validate();
        try {
            $this->editFolderUseCase->execute(Auth::id(),$folderId,$this->name);
            $this->reset(['name']);
            $this->dispatch('notify',message: "Folder Updated");
            return redirect()->to('/');
        }catch (Exception $e){
            $this->addError('name', $e->getMessage());
        }
    }


    public function render(): view
    {
        return view('livewire.folder.edit-folder');
    }
}
