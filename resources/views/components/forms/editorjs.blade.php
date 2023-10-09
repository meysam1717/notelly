<div wire:ignore>
    <label for="editorjs" class="block text-sm font-medium leading-6 text-typograph-sub-header mt-2">{{ __($lable) }}</label>
    <div id="editorjs" class="w-full h-full p-2 light-slate"></div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script>
        const editor = new EditorJS({
            holder: "editorjs",
            tools: {
                header: Header,
                checklist: {
                    class: Checklist,
                    inlineToolbar: true,
                },
            },
        });

        document.addEventListener('livewire:initialized', function () {
            Livewire.on('loadEditorJs', (event) => {
                editor.isReady
                    .then(function () {
                        editor.render(JSON.parse(event.data));
                    })
                    .catch(function (error) {
                        console.error('Editor.js initialization error:', error);
                    });
            });
        });
    </script>

@endpush