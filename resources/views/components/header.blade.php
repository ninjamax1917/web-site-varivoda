<div class="drawer">
    <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
        <nav x-data="{ open: false }" class="relative bg-gray-100 dark:bg-gray-800 shadow-lg">
            <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                    <!-- Drawer button for mobile -->
                    <div class="flex-none md:hidden">
                        <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-6 w-6 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div>
                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex shrink-0 items-center h-16">
                            <!-- Логотип -->
                            <x-partials.header.logo />
                        </div>
                        <x-partials.header.menu-header />
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
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