<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OHA-HRMS') }} - @yield('title', 'Admin Panel')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js for interactivity -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        
        /* Sidebar transition */
        .sidebar-transition {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Active link styling */
        .nav-link-active {
            background-color: #3b82f6;
            color: white;
        }
        
        .nav-link-active svg {
            color: white;
        }
        
        /* Card hover effects */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Button hover effects */
        .btn-hover {
            transition: all 0.2s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-64 min-h-screen fixed lg:static inset-y-0 left-0 z-30 transform transition-transform duration-300 ease-in-out lg:translate-x-0" 
               :class="{'-translate-x-full': !sidebarOpen}" 
               x-show="sidebarOpen || window.innerWidth >= 1024"
               x-cloak>
            
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">OHA-HRMS</h1>
                        <p class="text-xs text-gray-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4">
                <ul class="space-y-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Employee Management -->
                    <li>
                        <a href="{{ route('admin.employees.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.employees.*') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Employees
                        </a>
                    </li>

                    <!-- Role Management -->
                    <li>
                        <a href="{{ route('admin.roles.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.roles.*') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-5 0v2a2 2 0 002 2h2M19 19a2 2 0 01-2 2h-2a2 2 0 01-2-2m2-4a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Roles
                        </a>
                    </li>

                    <!-- Leave Management -->
                    <li>
                        <a href="{{ route('admin.leaves.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.leaves.*') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Leave Requests
                        </a>
                    </li>

                    <!-- Letter Management -->
                    <li>
                        <a href="{{ route('admin.letters.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.letters.*') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Letters
                        </a>
                    </li>

                    <!-- Letter Templates -->
                    <li>
                        <a href="{{ route('admin.letter-templates.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.letter-templates.*') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                            </svg>
                            Letter Templates
                        </a>
                    </li>

                    <!-- IP Restrictions -->
                    <li>
                        <a href="{{ route('admin.ip-restrictions.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.ip-restrictions.*') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            IP Restrictions
                        </a>
                    </li>

                    <!-- Salary Slips -->
                    <li>
                        <a href="{{ route('admin.salary-slips.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.salary-slips.*') ? 'nav-link-active' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM6.507 11.507A2.5 2.5 0 014 14c0 1.38.895 2.55 2.12 2.893M19.5 14a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm-2.5 2.893C18.105 16.55 19 15.38 19 14a2.5 2.5 0 00-2.5-2.5M9 14l6-6"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM6.507 11.507A2.5 2.5 0 014 14c0 1.38.895 2.55 2.12 2.893M19.5 14a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm-2.5 2.893C18.105 16.55 19 15.38 19 14a2.5 2.5 0 00-2.5-2.5M9 14l6-6"></path>
                            </svg>
                            Salary Slips
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden" 
             x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Admin Dashboard')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            Welcome, {{ Auth::user()->name }}
                        </div>
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-gray-700 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script>
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('aside');
            const toggleButton = document.querySelector('[x-on\\:click]');
            
            if (window.innerWidth < 1024 && 
                !sidebar.contains(event.target) && 
                !toggleButton.contains(event.target)) {
                Alpine.store('sidebarOpen', false);
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                Alpine.store('sidebarOpen', false);
            }
        });
    </script>
</body>
</html>