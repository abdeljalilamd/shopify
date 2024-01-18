<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.return_prodcts.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('return-prodcts.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.return_prodcts.inputs.order_id')
                        </h5>
                        <span
                            >{{ optional($returnProdct->order)->status ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.return_prodcts.inputs.reason')
                        </h5>
                        <span>{{ $returnProdct->reason ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('return-prodcts.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\ReturnProdct::class)
                    <a
                        href="{{ route('return-prodcts.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\Refund::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Refunds </x-slot>

                <livewire:return-prodct-refunds-detail
                    :returnProdct="$returnProdct"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
