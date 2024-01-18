<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.products.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('products.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-form
                    method="PUT"
                    action="{{ route('products.update', $product) }}"
                    has-files
                    class="mt-4"
                >
                    @include('app.products.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('products.index') }}" class="button">
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('products.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-form>
            </x-partials.card>

            @can('view-any', App\Models\ProductImage::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Product Images </x-slot>

                <livewire:product-product-images-detail :product="$product" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\ProductVariant::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Product Variants </x-slot>

                <livewire:product-product-variants-detail :product="$product" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\ProductAttribute::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Product Attributes </x-slot>

                <livewire:product-product-attributes-detail
                    :product="$product"
                />
            </x-partials.card>
            @endcan @can('view-any', App\Models\ProductTag::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Product Tags </x-slot>

                <livewire:product-product-tags-detail :product="$product" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\Inventory::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Inventories </x-slot>

                <livewire:product-inventories-detail :product="$product" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\ProductReview::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Product Reviews </x-slot>

                <livewire:product-product-reviews-detail :product="$product" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
