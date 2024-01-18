@php $editing = isset($shippingMethod) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $shippingMethod->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="cost"
            label="Cost"
            :value="old('cost', ($editing ? $shippingMethod->cost : ''))"
            max="255"
            step="0.01"
            placeholder="Cost"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
