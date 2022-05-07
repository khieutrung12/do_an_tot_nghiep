@foreach ($products as $product)
    <div class="info-product rounded-sm">
        <a href="{{ route('show', [$product->slug]) }}"
            class=" hover:bg-blue-100 hover:text-indigo-900 cursor-pointer flex items-center p-3 m-3 rounded-xl">
            <img src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                class="w-13 h-13 rounded-full" alt="">
            <div class="ml-5 h-11">
                <span class="block font-medium text-lg">
                    {{ $product->name }}
                </span>
                <span class="block text-xs"><br /></span>
                <span class="text-sm text-gray-500">
                    {{ vndFormat($product->price) }}
                </span>
            </div>
        </a>
    </div>
@endforeach
<div class="info-product rounded-sm">
    <a href="{{ route('search.list.products', $key) }}"
        class=" hover:bg-blue-100 hover:text-indigo-900 cursor-pointer flex items-center p-3 m-3 rounded-xl">
        <i
            class="fas fa-search text-white text-lg bg-indigo-900 p-3 rounded-full"></i>
        <span class="ml-5">{{ __('titles.Search') }}</span>
        <span
            class="text-indigo-900 font-medium ml-2">{{ $key }}</span>
    </a>
</div>
