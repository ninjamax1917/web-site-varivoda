<div class="drawer select-none">
    <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
        <nav x-data="{ open: false }" class="relative bg-gray-100 dark:bg-[#161617] shadow-lg">
            <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
                <div class="relative flex h-20 items-center justify-between">
                    <!-- Drawer button visible for widths <= 1040px -->
                    <div class="flex-none min-[1041px]:hidden text-[#39393A]">
                        <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block h-9 w-9 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div>
                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div
                            class="flex shrink-0 items-center h-20 ml-2 sm:ml-3 min-[1041px]:ml-0 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 min-[1041px]:static min-[1041px]:left-auto min-[1041px]:top-auto min-[1041px]:translate-x-0 min-[1041px]:translate-y-0">
                            <!-- Логотип -->
                            <x-partials.header.logo />
                        </div>
                        <x-partials.header.menu-header />
                    </div>
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        <span class="mr-8">
                            <x-partials.header.swiper-theme />
                        </span>
                        <x-partials.header.auth />
                    </div>
                </div>
            </div>
        </nav>
        <!-- Page content here -->
    </div>
    <div class="drawer-side">
        <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
        @include('components.partials.header.drawer-menu')
    </div>
</div>
