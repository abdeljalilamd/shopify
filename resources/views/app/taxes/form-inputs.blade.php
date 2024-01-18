@php $editing = isset($taxe) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $taxe->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="rate"
            label="Rate"
            :value="old('rate', ($editing ? $taxe->rate : ''))"
            max="255"
            step="0.01"
            placeholder="Rate"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
