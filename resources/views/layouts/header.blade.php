<header class="py-6 shadow-sm bg-pink-100 lg:bg-white">
    <div class="container flex items-center space-x-56 m-auto">
        <!-- logo -->
        <a href="{{ route('home') }}"
            class="text-lg font-bold text-teal-800 no-underline">
            TECHNOLOGY WORLD
        </a>
        <!-- logo end -->
        <!-- searchbar -->
        <form class=" xl:max-w-xl lg:max-w-lg lg:flex relative hidden w-96"
            role="search">
            <input type="text" id="input-search"
                class="pl-12 w-full border-2 border-indigo-900 py-3 px-3 rounded-lg focus:border-opacity-0 shadow-2xl"
                placeholder="{{ '     ' . __('titles.Search') }}">
            <i
                class="fas fa-search text-gray-300 text-lg absolute mt-3 ml-6"></i>
            <div
                class="search-ajax-result w-full shadow transition z-50 divide-y divide-gray-300 divide-dashed bg-white absolute mt-14 rounded-md">
            </div>
        </form>
        <!-- searchbar end -->
        <!-- navicons -->
        @if (Auth::check() && Auth::user()->role_id == config('auth.roles.user'))
            <div class="space-x-10 flex items-center justify-center">
                <!-- Notification -->
                @if (Auth::check())
                    <script>
                        var userID = "{{ Auth::user()->id }}";
                    </script>
                @endif
                @auth
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown dropdown-notifications">
                                <a href="" class="dropdown-toggle"
                                    data-toggle="dropdown">
                                    <i data-count="{{ Auth::user()->unreadNotifications->count() }}"
                                        class="far fa-bell notification-icon">
                                    </i>
                                </a>
                                <div class="dropdown-container">
                                    <div class="dropdown-toolbar">
                                        <div class="dropdown-toolbar-actions">
                                        </div>
                                    </div>
                                    <ul class="dropdown-menu" id="notifications">
                                        @foreach (Auth::user()->notifications as $notification)
                                            <a
                                                href="{{ $notification->data['link'] }}?read={{ $notification->id }}">
                                                <li class="notification active">
                                                    <div class="media">
                                                        <div class="media-left">
                                                        </div>
                                                        <div class="media-body">
                                                            <strong
                                                                class="notification-title">
                                                                {{ trans('titles.order_status_update') }}:
                                                                #{{ $notification->data['order_code'] }}</strong>
                                                            <div
                                                                class="notification-meta">
                                                                <small
                                                                    class="timestamp">
                                                                    @if ($notification->data['status_order'] == config('app.confirmed'))
                                                                        {{ trans('messages.order_accepted_at') }}
                                                                    @else
                                                                        {{ trans('messages.order_canceled_at') }}
                                                                    @endif
                                                                    {{ $notification->data['time'] }}
                                                                </small>
                                                                <span
                                                                    class="dot  {{ $notification->unread() ? 'unread-color' : 'read-color' }}"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endauth
                <!-- end Notification -->
                <!-- Cart -->
                <a href="{{ route('carts.index') }}"
                    class="lg:block text-center text-gray-700 hover:text-indigo-900 transition relative">
                    @if (App::getLocale() == 'vi')
                        <span
                            class="absolute left-7 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs count_product"
                            data-url_count_product="{{ route('countProduct') }}">
                            @include(
                                'user.cart.cart_components.count_product'
                            )
                        </span>
                    @else
                        <span
                            class="absolute left-7 bottom-7 w-5 h-5 rounded-full flex items-center justify-center bg-indigo-900 text-white text-xs count_product"
                            data-url_count_product="{{ route('countProduct') }}">
                            @include(
                                'user.cart.cart_components.count_product'
                            )
                        </span>
                    @endif
                    <div class="text-2xl">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <small class="text-xs leading-3">
                        {{ __('titles.Cart') }}
                    </small>
                </a>
                <!-- end Cart -->
                <!-- Account -->
                <a href="{{ route('profile.edit', Auth::user()->id) }}"
                    class="block text-center text-gray-700 hover:text-indigo-900 transition">
                    <div class="text-2xl">
                        <i class="far fa-user"></i>
                    </div>
                    <small class="text-xs leading-3">
                        {{ __('titles.Account') }}
                    </small>
                </a>
                <!-- end Account -->
            </div>
            <!-- navicons end -->
        @elseif (Auth::check() && Auth::user()->role_id == config('auth.roles.admin'))
            <div class="space-x-10 flex items-center justify-center">
                <a href="{{ route('admin') }}"
                    class="block text-center text-gray-700 hover:text-indigo-900 transition">
                    <div class="text-2xl">
                        <i class="far fa-user"></i>
                    </div>
                    <small class="text-xs leading-3">
                        {{ __('titles.admin') }}
                    </small>
                </a>
            </div>
        @endif
        <!-- end navicons -->
    </div>
</header>
