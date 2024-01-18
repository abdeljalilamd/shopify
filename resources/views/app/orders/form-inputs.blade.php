@php $editing = isset($order) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="customer_id" label="Customer" required>
            @php $selected = old('customer_id', ($editing ? $order->customer_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Customer</option>
            @foreach($customers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="total"
            label="Total"
            :value="old('total', ($editing ? $order->total : ''))"
            max="255"
            step="0.01"
            placeholder="Total"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="status"
            label="Status"
            :value="old('status', ($editing ? $order->status : ''))"
            maxlength="255"
            placeholder="Status"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
