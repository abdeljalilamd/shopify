@php $editing = isset($discount) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $discount->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $discount->amount : ''))"
            max="255"
            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="coupon_code"
            label="Coupon Code"
            :value="old('coupon_code', ($editing ? $discount->coupon_code : ''))"
            maxlength="255"
            placeholder="Coupon Code"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
