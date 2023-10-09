<div class="w-full max-w-3xl p-4 ">
    <h1 class="mb-2 font-semibold text-center text-typograph-header">Edit Folder</h1>
    <x-forms.input model="name" lable="Name" type="text"/>
</div>


@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            Livewire.dispatch('get-folder-info',{'folderId':"{{ request()->route('id')}}"});
            telegram.MainButton.text = "Save";
            telegram.MainButton.show();
            telegram.MainButton.onClick(function () {
                Livewire.dispatch('update-folder',{'folderId':"{{ request()->route('id')}}"});
            })
        });

        telegram.BackButton.onClick(function (event) {
            window.location = "{{ route('home') }}"
        });
    </script>
@endpush
