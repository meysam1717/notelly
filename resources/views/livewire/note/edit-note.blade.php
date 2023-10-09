<div class="w-full max-w-3xl p-4 ">
    <h1 class="mb-2 font-semibold text-center text-typograph-header">Edit Note</h1>
    <x-forms.input model="title" lable="Title" type="text"/>
    <x-forms.editorjs lable="Note"/>

</div>


@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            Livewire.dispatch('get-note-info',{'folderId':{{ $folderId}} ,'noteId':{{ $noteId }} });
            telegram.MainButton.text = "Save";
            telegram.MainButton.show();
            telegram.MainButton.onClick(function () {
                updateNote();
            })
        });


        function updateNote() {
            editor.save().then((outputData) => {
                Livewire.dispatch('update-note',{'note':outputData,'folderId':{{ $folderId}} ,'noteId':{{ $noteId }} });
            });
        }

        telegram.BackButton.onClick(function (event) {
            window.location = "{{ route('note-list',['id'=>$folderId]) }}"
        });
    </script>
@endpush
