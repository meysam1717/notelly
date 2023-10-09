import {Livewire, Alpine} from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'
Alpine.plugin(Clipboard)
Livewire.start()

Livewire.hook('request', ({uri, options, payload, respond, succeed, fail}) => {
    options.headers = {
        "Content-type": "application/json",
        "init-data": telegram.initData,
        "X-Livewire": ""
    };
})