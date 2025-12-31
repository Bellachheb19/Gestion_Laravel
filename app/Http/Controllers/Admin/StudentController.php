<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'apogee' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        // 1. Créer l'utilisateur dans Firebase via l'API REST
        // Note: On utilise l'API Key récupérée de votre configuration Firebase
        $apiKey = "AIzaSyAY1cgHEVRYDXvnjMgGI__Riq00yk-FRGQ";
        $firebaseUrl = "https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=" . $apiKey;

        try {
            $response = \Illuminate\Support\Facades\Http::post($firebaseUrl, [
                'email' => $request->email,
                'password' => $request->password,
                'returnSecureToken' => true
            ]);

            if ($response->failed()) {
                $error = $response->json()['error']['message'] ?? 'Erreur inconnue lors de la création Firebase.';
                return back()->withInput()->withErrors(['email' => 'Erreur Firebase: ' . $error]);
            }

            $firebaseUid = $response->json()['localId'];

            // 2. Créer l'utilisateur dans PostgreSQL avec le Firebase UID
            User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'apogee' => $request->apogee,
                'phone' => $request->phone,
                'google_id' => $firebaseUid,
            ]);

            return redirect()->route('admin.students.index')->with('success', 'Étudiant créé et synchronisé avec Firebase.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['email' => 'Une erreur est survenue: ' . $e->getMessage()]);
        }
    }

    public function edit(User $student)
    {
        if ($student->role !== 'student')
            abort(404);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        if ($student->role !== 'student')
            abort(404);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
            'apogee' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $data = $request->only(['nom', 'prenom', 'email', 'apogee', 'phone']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(User $student)
    {
        if ($student->role !== 'student')
            abort(404);

        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
