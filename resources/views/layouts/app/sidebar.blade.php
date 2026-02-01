<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <style>
            .sidebar-maroon { background: linear-gradient(to bottom, #800000, #5a0000); }
            .sidebar-text { color: #ffffff; }
            .sidebar-text-muted { color: rgba(255,255,255,0.6); }
            .sidebar-text-dim { color: rgba(255,255,255,0.4); }
            .sidebar-link { color: #ffffff; }
            .sidebar-link:hover { background: rgba(255,255,255,0.1); }
            .sidebar-link.active { background: #ffffff; color: #800000; font-weight: 600; }
        </style>
    </head>
    <body class="min-h-screen bg-gray-50">
        <div class="drawer lg:drawer-open">
            <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />

            <!-- Main content -->
            <div class="drawer-content flex flex-col">
                <!-- Mobile Navbar -->
                <div class="navbar lg:hidden" style="background: #800000; color: white;">
                    <div class="flex-none">
                        <label for="sidebar-drawer" class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                    </div>
                    <div class="flex-1">
                        <a class="btn btn-ghost text-xl font-bold" href="{{ route('dashboard') }}">i-Alqori</a>
                    </div>
                </div>

                <!-- Page content -->
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>

            <!-- Sidebar -->
            <div class="drawer-side z-40">
                <label for="sidebar-drawer" class="drawer-overlay"></label>
                <aside class="w-72 min-h-screen sidebar-maroon shadow-2xl">
                    <!-- Logo -->
                    <div class="p-6 border-b" style="border-color: rgba(255,255,255,0.1);">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(255,255,255,0.2);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold" style="color: white;">i-Alqori</h1>
                                <p class="text-xs" style="color: rgba(255,255,255,0.6);">Sistem Pengurusan</p>
                            </div>
                        </a>
                    </div>

                    <!-- User Info -->
                    <div class="p-4 mx-4 mt-4 rounded-xl" style="background: rgba(255,255,255,0.1);">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold" style="background: rgba(255,255,255,0.2); color: white;">
                                {{ auth()->user()?->initials() }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold truncate" style="color: white;">{{ auth()->user()?->name }}</p>
                                <p class="text-xs capitalize" style="color: rgba(255,255,255,0.6);">{{ auth()->user()?->getPrimaryRole() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="p-4">
                        @php $role = auth()->user()?->getPrimaryRole() @endphp

                        {{-- Admin Navigation --}}
                        @if(auth()->user()?->isAdmin())
                            <div class="mb-6">
                                <h3 class="px-4 text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Dashboard</h3>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-link active' : 'sidebar-link' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users') ? 'sidebar-link active' : 'sidebar-link' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                            <span>Users</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h3 class="px-4 text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Class Management</h3>
                                <ul class="space-y-1">
                                    <li><a href="{{ route('admin.class-names') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.class-names') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg><span>Class Names</span></a></li>
                                    <li><a href="{{ route('admin.class-packages') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.class-packages') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg><span>Class Packages</span></a></li>
                                    <li><a href="{{ route('admin.class-types') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.class-types') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg><span>Class Types</span></a></li>
                                    <li><a href="{{ route('admin.class-numbers') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.class-numbers') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /></svg><span>Class Numbers</span></a></li>
                                    <li><a href="{{ route('admin.fee-rates') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.fee-rates') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Fee Rates</span></a></li>
                                    <li><a href="{{ route('admin.assign-class-teachers') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.assign-class-teachers') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg><span>Assign Teachers</span></a></li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h3 class="px-4 text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Reports</h3>
                                <ul class="space-y-1">
                                    <li><a href="{{ route('admin.report-classes') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.report-classes') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg><span>Report Classes</span></a></li>
                                    <li><a href="{{ route('admin.overdue-pay-list') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.overdue-pay-list') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Overdue Payments</span></a></li>
                                    <li><a href="{{ route('admin.add-class') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.add-class') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg><span>Add Class</span></a></li>
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h3 class="px-4 text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Tools</h3>
                                <ul class="space-y-1">
                                    <li><a href="{{ route('admin.calculator-fee') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.calculator-fee') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg><span>Fee Calculator</span></a></li>
                                    <li><a href="{{ route('admin.record-student') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.record-student') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg><span>Record Student</span></a></li>
                                    <li><a href="{{ route('admin.student-info') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.student-info') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Student Info</span></a></li>
                                </ul>
                            </div>
                        @endif

                        {{-- Teacher Navigation --}}
                        @if(auth()->user()?->isTeacher())
                            <div class="mb-6">
                                <h3 class="px-4 text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Teacher Menu</h3>
                                <ul class="space-y-1">
                                    <li><a href="{{ route('teacher.your-class') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('teacher.your-class') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg><span>Your Classes</span></a></li>
                                    <li><a href="{{ route('teacher.fee-student') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('teacher.fee-student') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Student Fees</span></a></li>
                                    <li><a href="{{ route('teacher.allowance') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('teacher.allowance') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg><span>Allowance</span></a></li>
                                    <li><a href="{{ route('teacher.info') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('teacher.info') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Memo / Info</span></a></li>
                                </ul>
                            </div>
                        @endif

                        {{-- Client Navigation --}}
                        @if(auth()->user()?->isClient())
                            <div class="mb-6">
                                <h3 class="px-4 text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Client Menu</h3>
                                <ul class="space-y-1">
                                    <li><a href="{{ route('client.my-clients') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('client.my-clients') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg><span>My Teachers</span></a></li>
                                    <li><a href="{{ route('client.client-class') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('client.client-class') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg><span>My Classes</span></a></li>
                                    <li><a href="{{ route('client.monthly-fee') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('client.monthly-fee') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Monthly Fees</span></a></li>
                                    <li><a href="{{ route('client.transaction') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('client.transaction') ? 'sidebar-link active' : 'sidebar-link' }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg><span>Transactions</span></a></li>
                                </ul>
                            </div>
                        @endif

                        <!-- Account Section -->
                        <div class="pt-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                            <h3 class="px-4 text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Account</h3>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all sidebar-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all sidebar-link w-full text-left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </aside>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
