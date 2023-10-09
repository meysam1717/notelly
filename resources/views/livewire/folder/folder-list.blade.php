<div class="w-full max-w-3xl p-4 ">
    <div role="list" class="grid grid-cols-2 mb-3 gap-x-3 gap-y-4 lg:grid-cols-3">
        @foreach($folders as $folder)
            <div class="relative min-w-0 px-4 py-5 text-center rounded-md bg-card sm:px-6"
                 x-data="{ open: false, color: false }" @keydown.escape="open = false"
                 @click.away="open = false" wire:key="FolderId-{{ $folder->id }}">
                <button class="absolute right-3" @click="open = !open">
                    <x-bi-three-dots-vertical class="w-5 h-5 text-gray-400"/>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute mt-2 overflow-hidden origin-top-right rounded-md shadow-lg bg-card right-2 w-36 options drop-shadow-2xl ">
                        <a href="{{ route('edit-folder',['id'=>$folder->id ]) }}"
                           class="flex px-2 py-3 text-sm font-bold text-typograph-sub-header">
                            <span class="mr-auto">Edit</span>
                            <x-bi-pencil/>
                        </a>

                        <a onClick="deleteFolder('{{ $folder->id }}','{{ $folder->name }}')"
                           class="flex px-2 py-3 text-sm font-bold text-error">
                            <span class="mr-auto">Delete</span>
                            <x-bi-trash3/>
                        </a>
                    </div>
                </button>
                <a href="{{ route('note-list',['id'=>$folder->id]) }}">
                    <div class="flex items-center justify-center">
                        <x-bi-folder class="w-24 h-24 text-primary"/>
                    </div>
                    <h3 class="mt-1 text-lg text-typograph-header font-emibold">
                        {{ $folder->name }}
                    </h3>
                    <p>
                        @if($folder->notes['count'])
                            <span class="light-gray badge">{{ $folder->notes['count'] }}</span>
                        @endif

                        <span class="text-sm font-thin text-typograph-sub-header">{{ $folder->notes['title'] }}</span>
                    </p>
                </a>

            </div>
        @endforeach
    </div>
</div>


@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            Livewire.dispatch('get-folder-list');
            telegram.MainButton.text = "Add Folder";
            telegram.MainButton.show();
            telegram.MainButton.onClick(function (event) {
                window.location = "{{ route('add-folder') }}";
            })
        });

        function deleteFolder(id, folderName) {
            telegram.showConfirm('Are you sure delete folder ' + folderName, function (params) {
                if (params) {
                    Livewire.dispatch('delete-folder', {'id': id});
                }
            });
        }
    </script>
@endpush
