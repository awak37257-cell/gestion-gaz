<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        $client = $admin->client; // Assure-toi d'avoir défini la relation client() dans ton modèle User

        return view('admin.parametres.index', compact('admin', 'client'));
    }

    public function update(Request $request)
    {
        $admin = auth()->user();
        $client = $admin->client;

        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'email_contact' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'admin_nom' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        ]);

        // Mise à jour des informations de l'entreprise
        if ($client) {
            $client->update([
                'nom' => $request->nom_entreprise,
                'email_contact' => $request->email_contact,
                'telephone' => $request->telephone,
            ]);
        }

        // Mise à jour du compte administrateur connecté
        $admin->update([
            'name' => $request->admin_nom,
            'email' => $request->admin_email,
        ]);

        return redirect()->route('admin.parametres.index')->with('success', 'Paramètres mis à jour avec succès.');
    }
}