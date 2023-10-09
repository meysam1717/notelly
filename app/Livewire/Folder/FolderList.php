<?php

namespace App\Livewire\Folder;

use App\Models\Folder;
use App\UseCases\Folder\DeleteFolderUseCase;
use App\UseCases\Folder\FolderListUseCase;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class FolderList extends Component
{
    private FolderListUseCase $folderListUseCase;
    private DeleteFolderUseCase $deleteFolderUseCase;
    public mixed $folders = [];

    public function boot(FolderListUseCase $folderListUseCase,DeleteFolderUseCase $deleteFolderUseCase): void
    {
        $this->folderListUseCase = $folderListUseCase;
        $this->deleteFolderUseCase = $deleteFolderUseCase;
    }

    /**
     * @throws Exception
     */
    #[On('get-folder-list')]
    public function folderList(): void
    {
        $this->folders = $this->folderListUseCase->execute(Auth::id());
    }

    /**
     * @throws Exception
     */
    #[On('delete-folder')]
    public function deleteFolder($id): void
    {
        $this->deleteFolderUseCase->execute(Auth::id(),$id);
        $this->dispatch('notify',message: "Folder deleted");
        $this->folderList();
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.folder.folder-list');
    }
}
