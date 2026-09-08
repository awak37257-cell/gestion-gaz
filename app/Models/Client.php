<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'email_contact',
        'telephone',
        'periode_abonnement',
        'montant_abonnement',
        'date_debut_abonnement',
        'date_fin_abonnement',
        'statut',
    ];

    protected $casts = [
        'date_debut_abonnement' => 'date',
        'date_fin_abonnement' => 'date',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function depots(): HasMany
    {
        return $this->hasMany(Depot::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    // Un abonnement est expiré si la date de fin est dépassée, même si le
    // statut en base n'a pas encore été mis à jour par une tâche planifiée.
    public function estActif(): bool
    {
        return $this->statut === 'actif' && $this->date_fin_abonnement->isFuture();
    }
}