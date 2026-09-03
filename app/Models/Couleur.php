<?php

namespace App\Models;

use App\Models\Scopes\ClientScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Couleur extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'marque_id',
        'type',
        'nom_couleur',
        'poids',
        'prix_unitaire',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ClientScope);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

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

    public function nomComplet(): string
    {
        return "{$this->marque->nom} {$this->nom_couleur} ({$this->poids})";
    }
}