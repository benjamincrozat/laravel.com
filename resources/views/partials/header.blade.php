<header
    x-trap.inert.noscroll="navIsOpen"
    class="relative z-50 text-gray-700 main-header"
    @keydown.window.escape="navIsOpen = false"
    @click.away="navIsOpen = false"
>
    <div class="relative py-4 mx-auto w-full max-w-screen-2xl bg-white transition duration-200 lg:bg-transparent lg:py-6">
        <div class="flex justify-between items-center px-5 mx-auto max-w-screen-xl">
            <ul class="hidden relative lg:flex lg:items-center lg:justify-center lg:gap-6 xl:gap-10">
                <li><a href="https://forge.laravel.com">Forge</a></li>
                <li><a href="https://vapor.laravel.com">Vapor</a></li>
                <li x-data="{ expanded: false }" class="relative" @keydown.window.escape="expanded = false">
                    <button class="flex justify-center items-center" @click="expanded = !expanded">
                        Ecosystem
                        <span class="ml-3 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': expanded }" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </button>
                    <div
                        x-show="expanded"
                        x-cloak
                        class="absolute left-28 z-20 transition transform -translate-x-1/2"
                        x-transition:enter="duration-250 ease-out"
                        x-transition:enter-start="opacity-0 -translate-y-8"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="duration-250 ease-in"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0 -translate-y-8"
                    >
                        <div
                            class="p-8 mt-4 bg-white shadow-lg transition-transform transform origin-top w-224"
                            @click.away="expanded = false"
                        >
                            <ul class="grid relative gap-6 sm:grid-cols-2 md:grid-cols-3">

                                {{-- @foreach (App\Ecosystem::items() as $ecosystemItemId => $ecosystemItem)
                                    <li>
                                        <a href="{{ $ecosystemItem['href'] }}" class="flex">
                                            <div class="relative shrink-0 w-12 h-12 bg-{{ $ecosystemItemId }} flex items-center justify-center rounded-lg overflow-hidden">
                                                <span class="absolute inset-0 w-full h-full bg-gradient-to-b from-[rgba(255,255,255,.2)] to-[rgba(255,255,255,0)]"></span>
                                                <img src="/img/ecosystem/{{ $ecosystemItemId }}.min.svg" alt="{{ $ecosystemItem['image-alt'] }}" class="@if ($ecosystemItemId === 'pennant') w-9 h-9 @else w-7 h-7 @endif" @if ($ecosystemItemId === 'pennant') width="36" height="36" @else width="28" height="28" @endif loading="lazy">
                                            </div>
                                            <div class="ml-4 leading-5">
                                                <div class="text-gray-900">{{ $ecosystemItem['name'] }}</div>
                                                <span class="text-xs text-gray-700">{{ $ecosystemItem['description'] }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach --}}
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="https://laravel-news.com">News</a></li>
                <li><a href="https://partners.laravel.com">Partners</a></li>
                <li><a href="{{ route('careers') }}">Careers</a></li>
                {{-- <li><a href="https://laravel.bigcartel.com/">Shop</a></li> --}}
            </ul>
            <div class="flex flex-1 justify-end items-center">
                <button id="docsearch"></button>
                <x-button.secondary href="/docs/{{ DEFAULT_VERSION }}" class="hidden lg:ml-4 lg:inline-flex">Documentation</x-button.secondary>
                <button
                    class="inline-flex relative justify-center items-center p-2 ml-2 w-10 h-10 text-gray-700 lg:hidden"
                    aria-label="Toggle Menu"
                    @click.prevent="navIsOpen = !navIsOpen"
                >
                    <svg x-show="! navIsOpen" class="w-6" viewBox="0 0 28 12" fill="none" xmlns="http://www.w3.org/2000/svg"><line y1="1" x2="28" y2="1" stroke="currentColor" stroke-width="2"/><line y1="11" x2="28" y2="11" stroke="currentColor" stroke-width="2"/></svg>
                    <svg x-show="navIsOpen" x-cloak class="absolute inset-0 mt-2.5 ml-2.5 w-5" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="1.41406" width="2" height="24" transform="rotate(-45 0 1.41406)" fill="currentColor"/><rect width="2" height="24" transform="matrix(0.707107 0.707107 0.707107 -0.707107 0.192383 16.9707)" fill="currentColor"/></svg>
                </button>
            </div>
        </div>
    </div>
    <div
        x-show="navIsOpen"
        class="lg:hidden"
        x-transition:enter="duration-150"
        x-transition:leave="duration-100 ease-in"
        x-cloak
    >
        <nav
            x-show="navIsOpen"
            x-transition.opacity
            x-cloak
            class="fixed inset-0 w-full pt-[4.2rem] z-10 pointer-events-none"
        >
            <div class="overflow-y-auto relative px-5 py-8 w-full h-full bg-white pointer-events-auto">
                <ul>
                    <li><a class="block py-2 w-full" href="https://forge.laravel.com">Forge</a></li>
                    <li><a class="block py-2 w-full" href="https://vapor.laravel.com">Vapor</a></li>
                    <li><a class="block py-3 w-full" href="https://laravel-news.com">News</a></li>
                    <li><a class="block py-3 w-full" href="https://partners.laravel.com">Partners</a></li>
                    <li><a class="block py-3 w-full" href="{{ route('careers') }}">Careers</a></li>
                    {{-- <li><a class="block py-3 w-full" href="https://laravel.bigcartel.com/products">Shop</a></li> --}}
                    <li class="flex sm:justify-center"><x-button.secondary class="mt-3 w-full max-w-md" href="/docs/{{ DEFAULT_VERSION }}">Documentation</x-button.secondary></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
