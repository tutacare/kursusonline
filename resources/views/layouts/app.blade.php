<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-gray-800 text-white flex-shrink-0 transition-all duration-300">
            <div class="p-4 text-2xl font-semibold text-center border-b border-gray-700 whitespace-nowrap overflow-hidden"
                id="sidebar-brand-text">
                {{ config('app.name', 'Laravel') }}
            </div>
            <nav class="mt-4">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white group">
                    <i class="fa-solid fa-gauge-high fa-fw text-lg"></i>
                    <span class="ml-3 sidebar-text">Dashboard</span>
                </a>
                @role('student')
                    <a href="{{ route('student.courses.index') }}"
                        class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white group">
                        <i class="fa-solid fa-book-open fa-fw text-lg"></i>
                        <span class="ml-3 sidebar-text">Kursus Saya</span>
                    </a>
                @endrole
                @role(['instructor', 'admin', 'superadmin'])
                    <a href="{{ route('courses.index') }}"
                        class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white group">
                        <i class="fa-solid fa-book fa-fw text-lg"></i>
                        <span class="ml-3 sidebar-text">Manajemen Kursus</span>
                    </a>
                @endrole
                @role('superadmin')
                    <a href="#"
                        class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white group"
                        id="akun-menu-toggle">
                        <i class="fa-solid fa-users-gear fa-fw text-lg"></i>
                        <span class="ml-3 sidebar-text">Akun</span>
                        <i class="fa-solid fa-chevron-down ml-auto text-xs sidebar-text-arrow"></i>
                    </a>
                    <div id="akun-submenu" class="hidden pl-8">
                        <a href="{{ route('users.index') }}"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white group">
                            <span class="ml-3 sidebar-text">Pengguna</span>
                        </a>
                        <a href="{{ route('roles.index') }}"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white group">
                            <span class="ml-3 sidebar-text">Role</span>
                        </a>
                        <a href="{{ route('permissions.index') }}"
                            class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white group">
                            <span class="ml-3 sidebar-text">Permission</span>
                        </a>
                    </div>
                    <!-- Add more menu items here -->
                @endrole
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div id="main-content-area" class="flex-grow flex flex-col transition-all duration-300">
            <!-- Header/Navbar -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <button id="sidebar-toggle" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="text-xl font-semibold">
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>
                <!-- User Dropdown (if authenticated) -->
                @auth
                    <div class="relative">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700"
                            onclick="document.getElementById('user-dropdown').classList.toggle('hidden')">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <div id="user-dropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                @endauth
            </header>

            <!-- Breadcrumbs -->
            <div class="p-4 bg-white border-b">
                <nav class="flex items-center text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                    @yield('breadcrumbs')
                </nav>
            </div>

            <!-- Page Content -->
            <main class="p-4 flex-grow">
                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>

            <!-- Footer -->
            <footer class="bg-white shadow p-4 text-center text-sm text-gray-500">
                {{-- <a href="{{ url('sitemap.xml') }}" target="_blank" class="hover:underline">Sitemap</a> --}}
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarBrandText = document.getElementById('sidebar-brand-text');
            const sidebarTexts = sidebar.querySelectorAll('.sidebar-text');

            sidebarToggle.addEventListener('click', function() {
                // Toggle sidebar width
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-20'); // Collapsed width

                // Toggle visibility of text elements
                sidebarBrandText.classList.toggle('hidden');
                sidebarTexts.forEach(text => {
                    text.classList.toggle('hidden');
                });
            });

            const akunMenuToggle = document.getElementById('akun-menu-toggle');
            const akunSubmenu = document.getElementById('akun-submenu');
            const akunMenuArrow = akunMenuToggle.querySelector('.sidebar-text-arrow');

            akunMenuToggle.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                akunSubmenu.classList.toggle('hidden');
                akunMenuArrow.classList.toggle('fa-chevron-down');
                akunMenuArrow.classList.toggle('fa-chevron-up');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>
