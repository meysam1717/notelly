<div class="w-full max-w-3xl p-4 ">
    <h1 class="mb-2 font-semibold text-center text-typograph-header">ADD Note</h1>
    <x-forms.input model="title" lable="Title" type="text"/>
    <x-forms.editorjs lable="Note"/>
</div>

@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            telegram.MainButton.text = "Save";
            telegram.MainButton.show();
            telegram.MainButton.onClick(function () {
                saveNote();
            })
        });


        function saveNote() {
            editor.save().then((outputData) => {
                Livewire.dispatch('save-new-note',{'note':outputData,'folderId':{{ request()->route('id') }}});
            });
        }

        telegram.BackButton.onClick(function (event) {
            window.location = "{{ route('note-list',['id'=>$folderId]) }}"
        });
    </script>
@endpush
