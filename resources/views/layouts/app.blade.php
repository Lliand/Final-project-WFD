<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéVault - Grading & Collection</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen">

    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
        </svg>
    </button>

    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-xl">
            
            <a href="{{ route('halloffame.index') }}" class="flex items-center justify-center mb-6 mt-2 w-full">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/International_Pok%C3%A9mon_logo.svg" class="h-8 sm:h-9" alt="Pokemon Logo" />
            </a>

            <ul class="space-y-2 font-medium">
                @if(Auth::check() && Auth::user()->role === 'Admin')
                    <li class="px-3 py-3">
                        <div class="bg-green-600 text-white text-[10px] font-black uppercase tracking-widest px-3 py-2 rounded-lg text-center shadow-md shadow-green-900/30 border border-green-500">
                            Admin Panel
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('admin.card-sets.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.card-sets.*') ? 'bg-gray-100 dark:bg-gray-700 text-white border-l-4 border-green-500' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-green-500 dark:group-hover:text-green-500 {{ request()->routeIs('admin.card-sets.*') ? 'text-green-500 dark:text-green-500' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13c-2.819-.831-4.715-1-7-1v14c2.285 0 4.181.169 7 1m0-14c2.819-.831 4.715-1 7-1v14c-2.285 0-4.181.169-7 1"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Master Card Sets</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.grading-packages.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.grading-packages.*') ? 'bg-gray-100 dark:bg-gray-700 text-white border-l-4 border-green-500' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-green-500 dark:group-hover:text-green-500 {{ request()->routeIs('admin.grading-packages.*') ? 'text-green-500 dark:text-green-500' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Master Packages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 dark:bg-gray-700 text-white border-l-4 border-green-500' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-green-500 dark:group-hover:text-green-500 {{ request()->routeIs('admin.users.*') ? 'text-green-500 dark:text-green-500' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9h4a5 5 0 0 1 5 5v2a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-2a5 5 0 0 1 5-5Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">User Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.audit-trail') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.audit-trail') ? 'bg-gray-100 dark:bg-gray-700 text-white border-l-4 border-green-500' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-green-500 dark:group-hover:text-green-500 {{ request()->routeIs('admin.audit-trail') ? 'text-green-500 dark:text-green-500' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Grading Audit</span>
                        </a>
                    </li>

                @elseif(Auth::check() && Auth::user()->role === 'Staff')
                    <li class="px-3 py-3">
                        <div class="bg-orange-800 text-white text-[10px] font-black uppercase tracking-widest px-3 py-2 rounded-lg text-center shadow-md shadow-orange-900/30 border border-orange-600">
                            Staff
                        </div>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-orange-500 dark:group-hover:text-orange-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5v14m-6-8h18"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Grading Requests</span>
                        </a>
                    </li>

                @else
                    <li class="px-3 py-3">
                        <div class="bg-yellow-500 text-gray-950 text-[10px] font-black uppercase tracking-widest px-3 py-2 rounded-lg text-center shadow-md shadow-yellow-900/30 border border-yellow-400">
                            User Vault
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('halloffame.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('halloffame.*') ? 'bg-gray-100 dark:bg-gray-700 border-l-4 border-yellow-500' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-yellow-500 dark:group-hover:text-yellow-500 {{ request()->routeIs('halloffame.*') ? 'text-yellow-500 dark:text-yellow-500' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
                            <span class="ms-3">Hall of Fame</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('collection.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('collection.index') ? 'bg-gray-100 dark:bg-gray-700 border-l-4 border-yellow-500' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-yellow-500 dark:group-hover:text-yellow-500 {{ request()->routeIs('collection.index') ? 'text-yellow-500 dark:text-yellow-500' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">My Collection</span>
                        </a>
                    </li>
                    <li class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('collection.create') }}" class="flex items-center p-2 text-gray-950 bg-yellow-500 rounded-lg hover:bg-yellow-400 group transition-colors shadow-lg shadow-yellow-900/20">
                            <svg class="shrink-0 w-5 h-5 text-gray-950 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/></svg>
                            <span class="flex-1 ms-3 font-bold whitespace-nowrap">Add New Card</span>
                        </a>
                    </li>
                    <li class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('grading.request.create') }}" class="flex items-center p-2 text-gray-950 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg hover:from-yellow-500 hover:to-yellow-700 group transition-all shadow-lg shadow-yellow-900/40 transform hover:-translate-y-0.5">
                            <svg class="shrink-0 w-5 h-5 text-gray-950 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3Z"/></svg>
                            <span class="flex-1 ms-3 font-extrabold whitespace-nowrap">Submit Grading</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('grading.history') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('grading.history') ? 'bg-gray-100 dark:bg-gray-700 text-white border-l-4 border-yellow-500' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-yellow-500 dark:group-hover:text-yellow-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Transaction History</span>
                        </a>
                    </li>
                @endif

                <li class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center p-2 text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 group transition-colors">
                            <svg class="shrink-0 w-5 h-5 text-red-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                            </svg>
                            <span class="flex-1 ms-3 font-bold text-left whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>
    <div class="p-4 sm:ml-64">
        @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>