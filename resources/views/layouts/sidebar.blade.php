<aside id="sidebar"
    class="fixed left-0 top-0 z-40 h-screen w-64 border-r border-gray-200 bg-white transition-all duration-300 ease-in-out dark:border-gray-800 dark:bg-gray-900 lg:static">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-2 dark:border-gray-800">
        <!-- Logo - Hidden when collapsed -->
        <!-- Center: Logo -->
        <div class="flex items-center justify-center h-full w-full">
            <a href="{{ route('dashboard') }}" class="sidebar-logo rounded-md shadow-md bg-white dark:bg-gray-800"
                id="sidebar-logo">
                <img class="h-10 w-auto dark:hidden" src="{{ asset('assets/images/logo/logo.png') }}" alt="Company Logo"
                    width="100" height="30" loading="lazy">
                <img class="hidden h-10 w-auto dark:block" src="{{ asset('assets/images/logo/logo-dark.png') }}"
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
    <div class="h-[calc(100vh-60px)] overflow-y-auto overflow-x-hidden px-3 py-4 shadow-lg bg-white rounded-lg">
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

                    <!-- Booths Menu -->
                    <li>
                        <button type="button" id="booths-menu-button"
                            class="sidebar-menu-item group flex w-full items-center rounded-lg p-2.5 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
                            aria-expanded="false" aria-controls="booths-menu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512"
                                class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                <path
                                    d="M32 64C14.33 64 0 78.33 0 96v32c0 17.67 14.33 32 32 32v288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32V160h64v288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32V160h64v288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32V160c17.7 0 32-14.3 32-32V96c0-17.67-14.3-32-32-32H32zm576 64H32V96h576v32z" />
                            </svg>
                            <span class="sidebar-text ml-3 flex-1 text-left truncate">Booths</span>
                            <svg id="booths-menu-arrow"
                                class="sidebar-arrow h-4 w-4 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- booths Dropdown -->
                        <ul id="booths-menu" class="hidden space-y-1 pl-9 pt-1">
                            <li>
                                <a href="{{ route('booths.index') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('booths.index') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Booth List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('booths.create') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('booths.create') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Add Booth</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Guides Menu -->
                    <li>
                        <button type="button" id="guides-menu-button"
                            class="sidebar-menu-item group flex w-full items-center rounded-lg p-2.5 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
                            aria-expanded="false" aria-controls="guides-menu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512"
                                class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                <path
                                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zM111.9 288c-22.5 0-43.3 9.2-58.3 24.2S29.3 345.5 29.3 368.1c.1 17.5 3.7 34.8 10.9 50.7l72.1 81.4c4.5 5.1 12.1 6.7 18.3 4l45.8-20.3L147 351.2l9.7-7.6 28.7 63.8-9.8 85.1 25.5 19.3 25.5-19.3-9.8-85.1 28.7-63.8 9.7 7.6-29.4 132.7 45.8 20.3c6.2 2.7 13.8 1.1 18.3-4l72.1-81.4c7.1-15.9 10.8-33.2 10.9-50.7c0-22.6-9.2-43.3-24.2-58.3S358.6 288 336.1 288H111.9z" />
                            </svg>
                            <span class="sidebar-text ml-3 flex-1 text-left truncate">Guides</span>
                            <svg id="guides-menu-arrow" class="sidebar-arrow h-4 w-4 transition-transform duration-200"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Guides Dropdown -->
                        <ul id="guides-menu" class="hidden space-y-1 pl-9 pt-1">
                            <li>
                                <a href="{{ route('guides.index') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('guides.index') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Guide List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('guides.create') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('guides.create') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Add Guide</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Offences Menu -->
                    <li>
                        <button type="button" id="offences-menu-button"
                            class="sidebar-menu-item group flex w-full items-center justify-between rounded-lg p-2.5 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
                            aria-expanded="false" aria-controls="offences-menu">
                            <!-- Left: Icon and Text -->
                            <div class="flex items-center space-x-3">
                                <i class="fa fa-balance-scale text-gray-500 dark:text-gray-400 text-base"></i>
                                <span class="sidebar-text truncate">Offences</span>
                            </div>
                            <!-- Right: Dropdown arrow -->
                            <svg id="offences-menu-arrow"
                                class="sidebar-arrow h-4 w-4 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Offences Dropdown -->
                        <ul id="offences-menu" class="hidden space-y-1 pl-9 pt-1">
                            <li>
                                <a href="{{ route('offences.index') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('offences.index') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Offence List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('offences.create') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('offences.create') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Add Offence</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{-- <!-- Booths Menu -->
                    <li>
                        <button type="button" id="booths-menu-button"
                            class="sidebar-menu-item group flex w-full items-center rounded-lg p-2.5 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
                            aria-expanded="false" aria-controls="booths-menu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512"
                                class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                <path
                                    d="M32 64C14.33 64 0 78.33 0 96v32c0 17.67 14.33 32 32 32v288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32V160h64v288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32V160h64v288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32V160c17.7 0 32-14.3 32-32V96c0-17.67-14.3-32-32-32H32zm576 64H32V96h576v32z" />
                            </svg>
                            <span class="sidebar-text ml-3 flex-1 text-left truncate">Booths</span>
                            <svg id="booths-menu-arrow" class="sidebar-arrow h-4 w-4 transition-transform duration-200"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- booths Dropdown -->
                        <ul id="booths-menu" class="hidden space-y-1 pl-9 pt-1">
                            <li>
                                <a href="{{ route('guides.index') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('guides.index') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Booth List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('guides.create') }}"
                                    class="sidebar-submenu-item flex items-center rounded-lg p-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 {{ request()->routeIs('guides.create') ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                    <span class="truncate">Add Booth</span>
                                </a>
                            </li>
                        </ul>
                    </li> --}}


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
    }

    /* Icon alignment */
    .sidebar-icon {
        flex-shrink: 0;
    }
</style>

<script>
    // Self-executing function for faster initialization
    (function () {
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
                // employees
                this.employeesButton = document.getElementById('employees-menu-button');
                this.employeesMenu = document.getElementById('employees-menu');
                this.employeesArrow = document.getElementById('employees-menu-arrow');
                // drivers
                this.driversButton = document.getElementById('drivers-menu-button');
                this.driversMenu = document.getElementById('drivers-menu');
                this.driversArrow = document.getElementById('drivers-menu-arrow');
                // guides
                this.guidesButton = document.getElementById('guides-menu-button');
                this.guidesMenu = document.getElementById('guides-menu');
                this.guidesArrow = document.getElementById('guides-menu-arrow');

                // booths
                this.boothsButton = document.getElementById('booths-menu-button');
                this.boothsMenu = document.getElementById('booths-menu');
                this.boothsArrow = document.getElementById('booths-menu-arrow');

                // offences
                this.offencesButton = document.getElementById('offences-menu-button');
                this.offencesMenu = document.getElementById('offences-menu');
                this.offencesArrow = document.getElementById('offences-menu-arrow');

                const path = window.location.pathname;

                if (path.includes('employees')) {
                    this.openMenu(this.employeesMenu, this.employeesArrow);
                } else if (path.includes('drivers')) {
                    this.openMenu(this.driversMenu, this.driversArrow);
                } else if (path.includes('guides')) {
                    this.openMenu(this.guidesMenu, this.guidesArrow);
                } else if (path.includes('booths')) {
                    this.openMenu(this.boothsMenu, this.boothsArrow);
                } else if (path.includes('offences')) {
                    this.openMenu(this.offencesMenu, this.offencesArrow);
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

                if (this.guidesButton) {
                    this.guidesButton.addEventListener('click', () => {
                        this.toggleMenu(this.guidesMenu, this.guidesArrow);
                    });
                }

                if (this.boothsButton) {
                    this.boothsButton.addEventListener('click', () => {
                        this.toggleMenu(this.boothsMenu, this.boothsArrow);
                    });
                }

                if (this.offencesButton) {
                    this.offencesButton.addEventListener('click', () => {
                        this.toggleMenu(this.offencesMenu, this.offencesArrow);
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