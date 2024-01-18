<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.seo_settings.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('seo-settings.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.seo_settings.inputs.meta_description')
                        </h5>
                        <span>{{ $seoSetting->meta_description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.seo_settings.inputs.image')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $seoSetting->image ? \Storage::url($seoSetting->image) : '' }}"
                            size="150"
                        />
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('seo-settings.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\SeoSetting::class)
                    <a href="{{ route('seo-settings.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\SeoMeta::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Seo Metas </x-slot>

                <livewire:seo-setting-seo-metas-detail
                    :seoSetting="$seoSetting"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
