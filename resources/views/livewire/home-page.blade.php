<div>
    <livewire:folder.folder-list/>
</div>

@push('js')
    <script>
        telegram.BackButton.onClick(function (event) {
            telegram.close();
        })
    </script>
@endpush