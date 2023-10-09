<div class="w-full max-w-3xl p-4 ">
    <div role="list" class="grid grid-cols-1 mb-3 gap-x-3 gap-y-4 lg:grid-cols-2">
        @foreach($notes as $note)
            <div class="px-4 py-5 rounded-md bg-card sm:px-6" wire:key="NoteId-{{ $note->id }}">
                <div class="flex space-x-3">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('edit-note',['id'=>$note->folder_id,'noteId'=>$note->id]) }}" class="">
                            <p class="text-sm font-semibold text-typograph-header">
                                {{ $note->title }}
                            </p>
                            <p class="text-sm text-typograph-sub-header">{{ $note->created_at }}</p>
                        </a>
                    </div>
                    <div class="flex self-center flex-shrink-0">
                        <div class="relative inline-block text-left">
                            <div>
                                <button onclick="deleteNote({{ $note->folder_id }},{{ $note->id }},'{{ $note->title }}')"
                                        class="flex items-center p-2 -m-2 rounded-full hover:text-gray-600"
                                        type="button">
                                    <x-bi-trash3 class="w-5 h-5 text-gray-400"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            Livewire.dispatch('get-note-list',{'folderId':"{{ $folderId }}"});
            telegram.expand();
            telegram.MainButton.text = "Add Note";
            telegram.MainButton.show();
            telegram.MainButton.onClick(function (event) {
                window.location = "{{ route('add-note',['id'=> $folderId]) }}";
            })
        });

        function deleteNote(folderId,noteId, noteTitle) {
            telegram.showConfirm('Are you sure delete note ' + noteTitle, function (params) {
                if (params) {
                    Livewire.dispatch('delete-note', {'folderId':folderId,'noteId': noteId});
                }
            });
        }

        telegram.BackButton.onClick(function (event) {
            window.location = "{{ route('home') }}"
        });
    </script>
@endpush