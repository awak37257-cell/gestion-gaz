<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ParametreController extends Controller
{
    public function index()
    {
        // Récupérer directement le client connecté via le guard 'client'
        $client = Auth::guard('client')->user();

        return view('admin.parametres.index', compact('client'));
    }

    public function update(Request $request)
    {
        $client = Auth::guard('client')->user();

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:clients,email,' . $client->id],
            'telephone' => ['nullable', 'string', 'max:20'],
            // Validation optionnelle pour le mot de passe
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Mise à jour des informations de base
        $client->nom = $request->input('nom');
        $client->email = $request->input('email');
        $client->telephone = $request->input('telephone');

        // Gestion de la modification du mot de passe si rempli
        if ($request->filled('password')) {
            if (!Hash::check($request->input('current_password'), $client->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['Le mot de passe actuel est incorrect.'],
                ]);
            }

            $client->password = Hash::make($request->input('password'));
        }

        $client->save();

        return redirect()->route('admin.parametres.index')->with('success', 'Paramètres mis à jour avec succès.');
    }
}