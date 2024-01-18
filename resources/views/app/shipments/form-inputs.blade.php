@php $editing = isset($shipment) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="order_id" label="Order" required>
            @php $selected = old('order_id', ($editing ? $shipment->order_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Order</option>
            @foreach($orders as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="tracking_number"
            label="Tracking Number"
            :value="old('tracking_number', ($editing ? $shipment->tracking_number : ''))"
            maxlength="255"
            placeholder="Tracking Number"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="shipping_method_id"
            label="Shipping Method"
            required
        >
            @php $selected = old('shipping_method_id', ($editing ? $shipment->shipping_method_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Shipping Method</option>
            @foreach($shippingMethods as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
