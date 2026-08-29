<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function index(): View
    {
        $marques = Marque::withCount('couleurs')->get();

        return view('admin.marques.index', compact('marques'));
    }

    public function create(): View
    {
        return view('admin.marques.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:marques,nom'],
        ]);

        Marque::create($donnees);

        return redirect()->route('admin.marques.index')->with('succes', 'Marque créée.');
    }

    public function edit(Marque $marque): View
    {
        return view('admin.marques.edit', compact('marque'));
    }

    public function update(Request $request, Marque $marque): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:marques,nom,' . $marque->id],
        ]);

        $marque->update($donnees);

        return redirect()->route('admin.marques.index')->with('succes', 'Marque mise à jour.');
    }

    public function destroy(Marque $marque): RedirectResponse
    {
        $marque->delete();

        return redirect()->route('admin.marques.index')->with('succes', 'Marque supprimée.');
    }
}