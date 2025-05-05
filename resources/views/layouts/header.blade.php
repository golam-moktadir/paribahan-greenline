<header class="sticky top-0 z-40 w-full border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
    <div class="flex w-full items-center justify-between px-2 py-2 sm:px-4">
        <!-- Left: Toggle and Logo -->
        <div class="flex items-center gap-3">
            <!-- Sidebar Toggle -->
            <button id="sidebar-toggle" aria-label="Toggle sidebar" aria-controls="sidebar"
                class="flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-300 transition-colors duration-150"
                data-collapsed="false">
                <i id="hamburger-icon" class="fas fa-bars text-lg"></i>
                <i id="close-icon" class="fas fa-times text-lg hidden"></i>
            </button>

            <!-- Mobile Logo -->
            <a href="{{ route('dashboard') }}" class="lg:hidden">
                <img class="h-10 w-auto dark:hidden" src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"
                    width="120" height="32" loading="lazy">
                <img class="hidden h-10 w-auto dark:block" src="{{ asset('assets/images/logo/logo-dark.png') }}"
                    alt="Logo" width="120" height="32" loading="lazy">
            </a>
        </div>

        <!-- Center: Desktop Search -->
        <div class="hidden flex-1 max-w-sm px-3 lg:block">
            <form class="relative" role="search">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400 text-sm"></i>
                </div>
                <input id="desktop-search" type="text" placeholder="Search..." aria-label="Search"
                    class="w-full rounded-md border border-gray-200 bg-white py-1.5 pl-9 pr-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-150">
            </form>
        </div>

        <!-- Right: User Menu and Mobile Search -->
        <div class="flex items-center gap-3">
            <!-- Mobile Search Toggle -->
            <button id="mobile-search-toggle" aria-label="Toggle search"
                class="lg:hidden text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-150">
                <i class="fas fa-search text-lg"></i>
            </button>

            <!-- User Menu -->
            <div class="relative">
                <button id="user-menu-button" type="button" aria-label="User menu" aria-expanded="false"
                    aria-haspopup="true"
                    class="flex items-center rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-150">
                    <span
                        class="inline-flex h-8 w-8 shrink-0 overflow-hidden rounded-full border border-gray-200 dark:border-gray-700">
                        <img src="{{ asset('assets/images/default/user.png') }}" alt="User avatar"
                            class="h-full w-full object-cover" loading="lazy" width="32" height="32">
                    </span>
                    <span
                        class="ml-2 hidden text-sm font-medium text-gray-700 dark:text-gray-300 md:block">{{ auth()->user()->name ?? 'User Fullname' }}</span>
                    <i class="fas fa-chevron-down ml-1 hidden h-4 w-4 text-gray-400 md:block"></i>
                </button>

                <!-- User Dropdown -->
                <div id="user-dropdown-menu"
                    class="absolute right-0 mt-2 hidden w-48 sm:w-56 origin-top-right rounded-md bg-white py-1 shadow-md dark:bg-gray-800 dark:shadow-gray-900 focus:outline-none transition-opacity duration-150">
                    <div class="px-4 py-2">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ auth()->user()->name ?? 'User' }}
                        </p>
                        <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ??
                            'useremail@mail.com' }}</p>
                    </div>
                    <hr class="border-gray-200 dark:border-gray-700">
                    <a href=""
                        class="block px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-150">Profile</a>
                    <a href=""
                        class="block px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-150">Settings</a>
                    <hr class="border-gray-200 dark:border-gray-700">
                    <form method="POST" action="">
                        @csrf
                        <button type="submit"
                            class="block w-full px-4 py-1.5 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-150">Sign
                            out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Search -->
    <div id="mobile-search" class="hidden border-t border-gray-200 px-4 py-2 dark:border-gray-700 lg:hidden">
        <form class="relative" role="search">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400 text-sm"></i>
            </div>
            <input id="mobile-search-input" type="text" placeholder="Search..." aria-label="Search"
                class="w-full rounded-md border border-gray-200 bg-white py-1.5 pl-9 pr-9 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-150">
            <button type="button" id="mobile-search-close" aria-label="Close search"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times text-sm"></i>
            </button>
        </form>
    </div>
</header>

@push('scripts')
    <script>
        (function () {
            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    const isCollapsed = sidebarToggle.getAttribute('data-collapsed') === 'true';
                    sidebarToggle.setAttribute('data-collapsed', !isCollapsed);
                    document.getElementById('hamburger-icon').classList.toggle('hidden');
                    document.getElementById('close-icon').classList.toggle('hidden');
                    if (sidebar) {
                        sidebar.classList.toggle('hidden');
                        localStorage.setItem('sidebarCollapsed', !isCollapsed);
                    }
                });
                // Initialize from localStorage
                if (localStorage.getItem('sidebarCollapsed') === 'true') {
                    sidebarToggle.setAttribute('data-collapsed', 'true');
                    document.getElementById('hamburger-icon').classList.add('hidden');
                    document.getElementById('close-icon').classList.remove('hidden');
                    if (sidebar) sidebar.classList.add('hidden');
                }
            }

            // User dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown-menu');
            if (userMenuButton) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isExpanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                    userMenuButton.setAttribute('aria-expanded', !isExpanded);
                    userDropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', (e) => {
                    if (!userMenuButton.contains(e.target)) {
                        userMenuButton.setAttribute('aria-expanded', 'false');
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            // Mobile search toggle
            const mobileSearchToggle = document.getElementById('mobile-search-toggle');
            const mobileSearch = document.getElementById('mobile-search');
            const mobileSearchClose = document.getElementById('mobile-search-close');
            if (mobileSearchToggle) {
                mobileSearchToggle.addEventListener('click', () => {
                    mobileSearch.classList.toggle('hidden');
                });
            }
            if (mobileSearchClose) {
                mobileSearchClose.addEventListener('click', () => {
                    mobileSearch.classList.add('hidden');
                });
            }

            // Load time
            const loadTime = (performance.now() / 1000).toFixed(2);
            console.log(`Fully loaded in ${loadTime} seconds.`);
        })();
    </script>
@endpush