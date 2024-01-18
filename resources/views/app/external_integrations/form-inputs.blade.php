@php $editing = isset($externalIntegration) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $externalIntegration->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="api_key"
            label="Api Key"
            :value="old('api_key', ($editing ? $externalIntegration->api_key : ''))"
            maxlength="255"
            placeholder="Api Key"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="token"
            label="Token"
            :value="old('token', ($editing ? $externalIntegration->token : ''))"
            maxlength="255"
            placeholder="Token"
        ></x-inputs.text>
    </x-inputs.group>
</div>
