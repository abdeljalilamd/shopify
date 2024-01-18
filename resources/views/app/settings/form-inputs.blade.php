@php $editing = isset($setting) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="key"
            label="Key"
            :value="old('key', ($editing ? $setting->key : ''))"
            maxlength="255"
            placeholder="Key"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="value"
            label="Value"
            :value="old('value', ($editing ? $setting->value : ''))"
            maxlength="255"
            placeholder="Value"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
