<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-base-200">
        <div class="drawer lg:drawer-open">
            <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />

            <!-- Main content -->
            <div class="drawer-content flex flex-col">
                <!-- Navbar -->
                <div class="navbar bg-base-100 shadow-sm lg:hidden">
                    <div class="flex-none">
                        <label for="sidebar-drawer" class="btn btn-square btn-ghost drawer-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                    </div>
                    <div class="flex-1">
                        <a class="btn btn-ghost text-xl" href="{{ route('dashboard') }}">i-Alqori</a>
                    </div>
                    <div class="flex-none">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                <div class="w-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                                    <span>{{ auth()->user()?->initials() }}</span>
                                </div>
                            </div>
                            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                                <li class="menu-title">
                                    <span>{{ auth()->user()?->name }}</span>
                                </li>
                                <li><a href="{{ route('profile.edit') }}">Settings</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Page content -->
                <main class="flex-1 p-4">
                    {{ $slot }}
                </main>
            </div>

            <!-- Sidebar -->
            <div class="drawer-side z-40">
                <label for="sidebar-drawer" class="drawer-overlay"></label>
                <aside class="w-64 min-h-screen bg-base-100 shadow-xl">
                    <!-- Logo -->
                    <div class="p-4 border-b">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-primary">i-Alqori</a>
                        <p class="text-xs text-base-content/60">Tuition Management System</p>
                    </div>

                    <!-- Navigation -->
                    <ul class="menu p-4 text-base-content">
                        @php $role = auth()->user()?->getPrimaryRole() @endphp

                        {{-- Admin Navigation --}}
                        @if(auth()->user()?->isAdmin())
                            <li class="menu-title"><span>Admin</span></li>
                            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                Dashboard
                            </a></li>
                            <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                Users
                            </a></li>

                            <li class="menu-title mt-4"><span>Class Management</span></li>
                            <li><a href="{{ route('admin.class-names') }}" class="{{ request()->routeIs('admin.class-names') ? 'active' : '' }}">Class Names</a></li>
                            <li><a href="{{ route('admin.class-packages') }}" class="{{ request()->routeIs('admin.class-packages') ? 'active' : '' }}">Class Packages</a></li>
                            <li><a href="{{ route('admin.class-types') }}" class="{{ request()->routeIs('admin.class-types') ? 'active' : '' }}">Class Types</a></li>
                            <li><a href="{{ route('admin.class-numbers') }}" class="{{ request()->routeIs('admin.class-numbers') ? 'active' : '' }}">Class Numbers</a></li>
                            <li><a href="{{ route('admin.fee-rates') }}" class="{{ request()->routeIs('admin.fee-rates') ? 'active' : '' }}">Fee Rates</a></li>
                            <li><a href="{{ route('admin.assign-class-teachers') }}" class="{{ request()->routeIs('admin.assign-class-teachers') ? 'active' : '' }}">Assign Teachers</a></li>

                            <li class="menu-title mt-4"><span>Reports</span></li>
                            <li><a href="{{ route('admin.report-classes') }}" class="{{ request()->routeIs('admin.report-classes') ? 'active' : '' }}">Report Classes</a></li>
                            <li><a href="{{ route('admin.overdue-pay-list') }}" class="{{ request()->routeIs('admin.overdue-pay-list') ? 'active' : '' }}">Overdue Payments</a></li>
                            <li><a href="{{ route('admin.add-class') }}" class="{{ request()->routeIs('admin.add-class') ? 'active' : '' }}">Add Class</a></li>

                            <li class="menu-title mt-4"><span>Tools</span></li>
                            <li><a href="{{ route('admin.calculator-fee') }}" class="{{ request()->routeIs('admin.calculator-fee') ? 'active' : '' }}">Fee Calculator</a></li>
                            <li><a href="{{ route('admin.record-student') }}" class="{{ request()->routeIs('admin.record-student') ? 'active' : '' }}">Record Student</a></li>
                            <li><a href="{{ route('admin.student-info') }}" class="{{ request()->routeIs('admin.student-info') ? 'active' : '' }}">Student Info</a></li>
                        @endif

                        {{-- Teacher Navigation --}}
                        @if(auth()->user()?->isTeacher())
                            <li class="menu-title"><span>Teacher</span></li>
                            <li><a href="{{ route('teacher.your-class') }}" class="{{ request()->routeIs('teacher.your-class') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                Your Classes
                            </a></li>
                            <li><a href="{{ route('teacher.fee-student') }}" class="{{ request()->routeIs('teacher.fee-student') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Student Fees
                            </a></li>
                            <li><a href="{{ route('teacher.allowance') }}" class="{{ request()->routeIs('teacher.allowance') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Allowance
                            </a></li>
                            <li><a href="{{ route('teacher.info') }}" class="{{ request()->routeIs('teacher.info') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Memo / Info
                            </a></li>
                        @endif

                        {{-- Client Navigation --}}
                        @if(auth()->user()?->isClient())
                            <li class="menu-title"><span>Client</span></li>
                            <li><a href="{{ route('client.my-clients') }}" class="{{ request()->routeIs('client.my-clients') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                My Teachers
                            </a></li>
                            <li><a href="{{ route('client.client-class') }}" class="{{ request()->routeIs('client.client-class') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                My Classes
                            </a></li>
                            <li><a href="{{ route('client.monthly-fee') }}" class="{{ request()->routeIs('client.monthly-fee') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Monthly Fees
                            </a></li>
                            <li><a href="{{ route('client.transaction') }}" class="{{ request()->routeIs('client.transaction') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                Transactions
                            </a></li>
                        @endif

                        <li class="menu-title mt-6"><span>Account</span></li>
                        <li><a href="{{ route('profile.edit') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Settings
                        </a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </body>
</html>
