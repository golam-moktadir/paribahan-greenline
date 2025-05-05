<aside id="sidebar"
    class="fixed left-0 top-0 z-40 h-screen w-64 border-r border-gray-200 bg-white transition-all duration-300 ease-in-out dark:border-gray-800 dark:bg-gray-900 lg:static">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2 dark:border-gray-800">
        <!-- Logo - Hidden when collapsed -->
        <!-- Center: Logo -->
        <div class="flex justify-center">
            <a href="{{ route('dashboard') }}"
                class="sidebar-logo focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded-md transition-all duration-150 hover:scale-105 hover:opacity-95"
                id="sidebar-logo">
                <img class="h-6 w-auto sm:h-10 dark:hidden" src="{{ asset('assets/images/logo/logo.png') }}"
                    alt="Company Logo" width="100" height="30" loading="lazy">
                <img class="hidden h-6 w-auto sm:h-10 dark:block" src="{{ asset('assets/images/logo/logo-dark.png') }}"
                    alt="Company Logo Dark" width="100" height="30" loading="lazy">
            </a>
        </div>
        <!-- Close Button - Mobile -->
        <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
            aria-label="Close sidebar">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <!-- Sidebar Menu -->
    <div class="h-[calc(100vh-73px)] overflow-y-auto overflow-x-hidden px-3 py-4">
        <nav>
            <!-- Menu Group -->
            <div class="mb-6">
                <h3
                    class="sidebar-section-title mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Menu
                </h3>

                <ul class="space-y-1.5">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="sidebar-menu-item group flex items-center rounded-lg p-2.5 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('dashboard') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                            <svg class="sidebar-icon h-5 w-5 flex-shrink-0 text-gray-500 dark:text-gray-400"
                                fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span class="sidebar-text ml-3 truncate">Dashboard</span>
                        </a>
                    </li>

                    <!-- Employees Menu -->
                    <li>
                        <button type="button" id="employees-menu-button"
                            class="sidebar-menu-item group flex w-full items-center rounded-lg p-2.5 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
                            aria-expanded="false" aria-controls="employees-menu">
                            <svg class="sidebar-icon h-5 w-5 flex-shrink-0 text-gray-500 dark:text-gray-400"
                                fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 6a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5zM18.75 9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM15 15.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 18.75a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                                <path
                                    d="M12 15a6 6 0 00-6 6h12a6 6 0 00-6-6zM21 21a3 3 0 11-6 0 3 3 0 016 0zM3 21a3 3 0 116 0 3 3 0 01-6 0z" />
                            </svg>
                            <span class="sidebar-text ml-3 flex-1 text-left truncate">Employees</span>
                            <svg id="employees-menu-arrow"
                                class="sidebar-arrow h-4 w-4 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Employees Dropdown -->
                        <ul id="employees-menu" class="hidden space-y-1 pl-9 pt-1">
                            <li>
                                <a href="{{ route('employees.index') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('employees.index') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Employee List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('employees.create') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('employees.create') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Add Employee</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Drivers Menu -->
                    <li>
                        <button type="button" id="drivers-menu-button"
                            class="sidebar-menu-item group flex w-full items-center rounded-lg p-2.5 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
                            aria-expanded="false" aria-controls="drivers-menu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12a9.93 9.93 0 001.76 5.71l.6.89A9.96 9.96 0 0012 22a9.96 9.96 0 007.64-3.4l.6-.89A9.93 9.93 0 0022 12c0-5.52-4.48-10-10-10zm0 2a8 8 0 018 8c0 1.53-.44 2.95-1.2 4.15L13 12.83V4.1A8.05 8.05 0 0012 4zm-1 0v8.83L5.2 14.15A8 8 0 0111 4zM4 12a8 8 0 015.2-7.57V11H4.1A7.96 7.96 0 004 12zm8 8a8 8 0 01-6.41-3.24l5.41-2.91V20zm1-6.15l5.41 2.91A8 8 0 0113 20v-6.15z" />
                            </svg>
                            <span class="sidebar-text ml-3 flex-1 text-left truncate">Drivers</span>
                            <svg id="drivers-menu-arrow" class="sidebar-arrow h-4 w-4 transition-transform duration-200"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Drivers Dropdown -->
                        <ul id="drivers-menu" class="hidden space-y-1 pl-9 pt-1">
                            <li>
                                <a href="{{ route('drivers.index') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('drivers.index') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Driver List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('drivers.create') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('drivers.create') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Add Driver</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</aside>

<style>
    /* Collapsed state styles */
    #sidebar.collapsed {
        width: 5rem;
    }

    #sidebar.collapsed .sidebar-text,
    #sidebar.collapsed .sidebar-section-title,
    #sidebar.collapsed .sidebar-logo,
    #sidebar.collapsed .sidebar-arrow {
        display: none;
    }

    #sidebar.collapsed .sidebar-menu-item {
        justify-content: center;
        padding: 0.75rem;
    }

    #sidebar.collapsed #employees-menu-button {
        padding-right: 0.75rem;
    }

    #sidebar.collapsed .sidebar-submenu-item {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* Expanded state styles */
    #sidebar:not(.collapsed) {
        width: 16rem;
        /* Full width */
    }

    /* Icon alignment */
    .sidebar-icon {
        flex-shrink: 0;
    }
</style>

<script>
    // Self-executing function for faster initialization
    (function() {
        // Sidebar state management
        const sidebar = {
            init() {
                this.sidebarEl = document.getElementById('sidebar');
                this.collapseBtn = document.getElementById('sidebar-collapse');
                this.closeBtn = document.getElementById('sidebar-close');

                this.loadState();
                this.bindEvents();
            },
            loadState() {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    this.sidebarEl.classList.add('collapsed');
                }
            },
            bindEvents() {
                if (this.collapseBtn) {
                    this.collapseBtn.addEventListener('click', () => this.toggle());
                }
                if (this.closeBtn) {
                    this.closeBtn.addEventListener('click', () => this.hide());
                }
            },
            toggle() {
                this.sidebarEl.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', this.sidebarEl.classList.contains('collapsed'));

                // Rotate collapse icon
                const icon = this.collapseBtn.querySelector('svg');
                if (this.sidebarEl.classList.contains('collapsed')) {
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    icon.style.transform = 'rotate(0deg)';
                }
            },
            hide() {
                this.sidebarEl.classList.add('hidden');
            }
        };

        // Menu toggle
        const menu = {
            init() {
                this.employeesButton = document.getElementById('employees-menu-button');
                this.employeesMenu = document.getElementById('employees-menu');
                this.employeesArrow = document.getElementById('employees-menu-arrow');

                // drivers
                this.driversButton = document.getElementById('drivers-menu-button');
                this.driversMenu = document.getElementById('drivers-menu');
                this.driversArrow = document.getElementById('drivers-menu-arrow');

                const path = window.location.pathname;

                if (path.includes('employees')) {
                    this.openMenu(this.employeesMenu, this.employeesArrow);
                } else if (path.includes('drivers')) {
                    this.openMenu(this.driversMenu, this.driversArrow);
                }

                this.bindEvents();
            },
            bindEvents() {
                if (this.employeesButton) {
                    this.employeesButton.addEventListener('click', () => {
                        this.toggleMenu(this.employeesMenu, this.employeesArrow);
                    });
                }

                if (this.driversButton) {
                    this.driversButton.addEventListener('click', () => {
                        this.toggleMenu(this.driversMenu, this.driversArrow);
                    });
                }
            },
            toggleMenu(menu, arrow) {
                menu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            },

            openMenu(menu, arrow) {
                menu.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            }

        };

        // Initialize components
        sidebar.init();
        menu.init();

        // Sync with header toggle
        const headerToggle = document.getElementById('sidebar-toggle');
        if (headerToggle) {
            headerToggle.addEventListener('click', () => {
                sidebar.toggle();
            });
        }
    })();
</script>
