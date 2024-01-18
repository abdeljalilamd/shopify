@php $editing = isset($emailTemplate) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $emailTemplate->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="subject"
            label="Subject"
            :value="old('subject', ($editing ? $emailTemplate->subject : ''))"
            maxlength="255"
            placeholder="Subject"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="content"
            label="Content"
            maxlength="255"
            required
            >{{ old('content', ($editing ? $emailTemplate->content : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
