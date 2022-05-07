<div id="modal_show_voucher" class=" bg-opacity-75 bg-gray-50 overflow-y-auto overflow-x-hidden fixed top-4 z-50 justify-center items-center md:inset-0 h-modal sm:h-full" id="small-modal">
    <div class="relative w-80 h-full md:h-auto m-auto top-32 bg-white shadow-xl">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-5 rounded-t border-b border-gray-100">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    {{ __('titles.voucher') }}
                </h3>
                <button id="close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="small-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>  
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <div class="text-base ">
                    <span class="font-bold text-indigo-900">
                        {{ __('titles.reward') }}
                    </span>
                    <span class="block pt-2 text-sm leading-relaxed text-gray-500">
                        {{ __('titles.discount-percent') . ' ' . $voucher->value . config('voucher.discount') }}
                        {{ __('titles.min-spend') . vndKFormat($voucher->condition_min_price) }}
                        {{ __('titles.capped-at') . vndKFormat($voucher->maximum_reduction) }}
                    </span>
                </div>
                <div class="text-base">
                    <span class="font-bold text-indigo-900">
                        {{ __('titles.code') }}
                    </span>
                    <span class="block pt-2 text-sm leading-relaxed text-gray-500">
                        {{ $voucher->code }}
                    </span>
                </div>
                <div class="text-base">
                    <span class="font-bold text-indigo-900">
                        {{ __('titles.date') }}
                    </span>
                    <span class="block pt-2 text-sm leading-relaxed text-gray-500">
                        {{ $voucher->start_date . ' ' . __('titles.to') . ' ' . $voucher->end_date }}
                    </span>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 rounded-b border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('user.use.voucher', $voucher->code) }}" class="text-white bg-indigo-900 hover:bg-white hover:text-indigo-900 hover:border-indigo-900 border hover:border-2 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                    {{ __('titles.use') }}
                </a>
                <button type="button" id="btn_ok" class=" ml-5 text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">
                    {{ __('titles.ok') }}
                </button>
            </div>
        </div>
    </div>
</div>
