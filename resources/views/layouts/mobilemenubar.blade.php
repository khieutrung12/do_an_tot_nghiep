<div
    class="fixed w-full border-t border-gray-200 shadow-sm bg-white py-3 bottom-0 left-0 flex justify-around items-start px-6 lg:hidden z-40">
    <a href="javascript:void(0)"
        class="block text-center text-gray-700 hover:text-indigo-900 transition relative">
        <div class="text-2xl" id="menuBar">
            <i class="fas fa-bars"></i>
        </div>
        <div class="text-xs leading-3">{{ __('titles.Menu') }}</div>
    </a>
    <a href="#"
        class="block text-center text-gray-700 hover:text-indigo-900 transition relative">
        <div class="text-2xl">
            <i class="fas fa-list-ul"></i>
        </div>
        <div class="text-xs leading-3">{{ __('titles.Category') }}
        </div>
    </a>
    <a href="#"
        class="block text-center text-gray-700 hover:text-indigo-900 transition relative">
        <div class="text-2xl">
            <i class="fas fa-search"></i>
        </div>
        <div class="text-xs leading-3">{{ __('titles.Search') }}
        </div>
    </a>
    <a href="#"
        class="text-center text-gray-700 hover:text-indigo-900 transition relative">
        @if (App::getLocale() == 'en')
            <span
                class="absolute left-4 bottom-5 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs">
                3
            </span>
        @else
            <span
                class="absolute left-7 bottom-5 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs">
                3
            </span>
        @endif
        <div class="text-2xl">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="text-xs leading-3">{{ __('titles.Cart') }}</div>
    </a>
</div>
