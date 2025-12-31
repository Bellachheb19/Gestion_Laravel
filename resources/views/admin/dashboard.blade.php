@extends('layouts.admin')

@section('admin_title', 'Tableau de bord')

@section('admin_content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="premium-card p-6 rounded-2xl border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-500 text-sm font-semibold mb-2">Total Étudiants</h3>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_students'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>
        <div class="premium-card p-6 rounded-2xl border-l-4 border-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-slate-500 text-sm font-semibold mb-2">Inscriptions (7j)</h3>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['recent_registrations'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-card p-8 rounded-3xl bg-white">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Bienvenue dans votre espace de gestion</h3>
        <p class="text-slate-600 leading-relaxed">
            Utilisez le menu latéral pour gérer les comptes étudiants, consulter les dossiers ou mettre à jour les
            informations académiques.
        </p>
    </div>
@endsection