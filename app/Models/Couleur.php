<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Couleur extends Model
{
    use HasFactory;

    protected $fillable = [
        'marque_id',
        'type',
        'nom_couleur',
        'poids',
        'prix_unitaire',
    ];

    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    // Ventes où cette couleur a été effectivement vendue
    public function ventesVendues(): HasMany
    {
        return $this->hasMany(Vente::class, 'couleur_vendue_id');
    }

    // Ventes où cette couleur avait été demandée à l'origine (avant substitution)
    public function ventesDemandees(): HasMany
    {
        return $this->hasMany(Vente::class, 'couleur_demandee_id');
    }

    public function demandesApprovisionnement(): HasMany
    {
        return $this->hasMany(DemandeApprovisionnement::class);
    }

public function nomComplet()
{
    return $this->marque->nom . ' - ' . $this->type . ' (' . $this->nom . ')';
}
}