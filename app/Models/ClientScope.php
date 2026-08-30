<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ClientScope implements Scope
{
    // Appliqué automatiquement à chaque requête sur les modèles qui l'utilisent.
    // Si un admin de client est connecté, ne renvoie que les lignes de son client.
    // Si personne n'est connecté (contexte vendeur via QR) ou si c'est le
    // super-admin (client_id null), aucun filtre n'est appliqué ici — le
    // filtrage se fait alors par la relation directe (ex: vendeur->depot_id).
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check() && Auth::user()->client_id !== null) {
            $builder->where($model->getTable() . '.client_id', Auth::user()->client_id);
        }
    }
}