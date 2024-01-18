@php $editing = isset($affiliateProgram) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="affiliate_id" label="Customer" required>
            @php $selected = old('affiliate_id', ($editing ? $affiliateProgram->affiliate_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Customer</option>
            @foreach($customers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="referral_id" label="Referral" required>
            @php $selected = old('referral_id', ($editing ? $affiliateProgram->referral_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Customer</option>
            @foreach($customers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="commission"
            label="Commission"
            :value="old('commission', ($editing ? $affiliateProgram->commission : ''))"
            max="255"
            step="0.01"
            placeholder="Commission"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
