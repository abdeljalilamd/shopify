<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.products.show_title')
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

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.categorie_id')
                        </h5>
                        <span
                            >{{ optional($product->categorie)->title ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.title')
                        </h5>
                        <span>{{ $product->title ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.slug')
                        </h5>
                        <span>{{ $product->slug ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.image')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $product->image ? \Storage::url($product->image) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.description')
                        </h5>
                        <span>{{ $product->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.price')
                        </h5>
                        <span>{{ $product->price ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.products.inputs.content')
                        </h5>
                        <span>{{ $product->content ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('products.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Product::class)
                    <a href="{{ route('products.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
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
