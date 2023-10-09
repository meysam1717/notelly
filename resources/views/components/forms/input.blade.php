<div class="{{ isset($type) && $type == 'hidden' ? "hide" : 'form-group' }} ">
    @if(isset($lable) && !empty($lable))
        <label for="{{ isset($id) ? $id : str_replace('.','_',$model) }}" class="block text-sm font-medium leading-6 text-typograph-sub-header">{{ __($lable) }}</label>
    @endif
    <input wire:model.live.debounce.250ms="{{ $model }}"
           id="{{ isset($id) ? $id : str_replace('.','_',$model) }}"
           type="{{ isset($type) ? $type : 'text' }}"
           class="{{ isset($class) ? $class : 'block w-full py-3 border-0 rounded-md shadow-sm light-slate ring-1 ring-inset ring-light-slate focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6' }}"
           {{ (isset($disabled) && $disabled) ? 'disabled' : '' }}
           placeholder="{{ isset($placeholder) && !empty($placeholder) ? __($placeholder) : '' }}"
           autocomplete="{{ isset($autocomplete) ? $autocomplete : 'off' }}">
    @error($model)
    <p class="mt-2 text-sm text-gray-500">{{ $message }}</p>
    @enderror
</div>

