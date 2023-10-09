<?php

namespace App\Livewire\Folder;

use App\UseCases\Folder\StoreFolderUseCase;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class AddFolder extends Component
{
    private StoreFolderUseCase $storeFolderUseCase;


    #[Rule('required|min:2|max:10')]
    public string $name = '';

    /**
     * @param StoreFolderUseCase $storeFolderUseCase
     * @return void
     */
    public function boot(StoreFolderUseCase $storeFolderUseCase): void
    {
        $this->storeFolderUseCase = $storeFolderUseCase;
    }


    /**
     * @throws Exception
     */
    #[On('save-new-folder')]
    public function save()
    {
        $this->validate();
        try {
            $this->storeFolderUseCase->execute(Auth::id(),$this->name);
            $this->reset(['name']);
            $this->dispatch('notify',message: "Folder Saved");
            return redirect()->to('/');
        }catch (Exception $e){
            $this->addError('name', $e->getMessage());
        }
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.folder.add-folder');
    }
}
