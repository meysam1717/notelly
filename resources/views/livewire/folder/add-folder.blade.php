<div class="w-full max-w-3xl p-4 " >
    <h1 class="mb-2 font-semibold text-center text-typograph-header">ADD Folder</h1>
    <x-forms.input model="name" lable="Name" type="text"/>
</div>

@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            telegram.MainButton.text = "Save";
            telegram.MainButton.show();
            telegram.MainButton.onClick(function () {
                Livewire.dispatch('save-new-folder');
            })
        });

        telegram.BackButton.onClick(function (event) {
            window.location = "{{ route('home') }}"
        });
    </script>
@endpush
