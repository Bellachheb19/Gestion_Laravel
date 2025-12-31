@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 flex">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-900 text-white p-6 hidden md:block shrink-0">
            <h2 class="text-2xl font-bold mb-8 flex items-center gap-2">
                <i class="fas fa-graduation-cap"></i> AdminPanel
            </h2>
            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="block py-3 px-4 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 transition' }}">
                    <i class="fas fa-chart-line mr-2"></i> Tableau de bord
                </a>
                <a href="{{ route('admin.students.index') }}"
                    class="block py-3 px-4 rounded-xl {{ request()->routeIs('admin.students.*') ? 'bg-indigo-700 text-white shadow-lg' : 'text-indigo-100 hover:bg-indigo-800 transition' }}">
                    <i class="fas fa-users mr-2"></i> Étudiants
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-slate-800">
                    @yield('admin_title', 'Tableau de bord')
                </h1>
                <div class="flex items-center gap-4">
                    <span
                        class="text-slate-600 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100 font-medium">
                        <i class="fas fa-user-shield text-indigo-500 mr-2"></i> {{ Auth::user()->nom }}
                        {{ Auth::user()->prenom }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 text-red-500 hover:text-red-600 font-bold px-4 py-2 hover:bg-red-50 rounded-xl transition">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </header>

            @yield('admin_content')
        </div>
    </div>
@endsection