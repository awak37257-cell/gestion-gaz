<?php

namespace App\Models;

use App\Models\Scopes\ClientScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'vendeur_id',
        'couleur_vendue_id',
        'couleur_demandee_id',
        'quantite',
        'prix_unitaire',
        'date_heure',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ClientScope);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function couleurVendue(): BelongsTo
    {
        return $this->belongsTo(Couleur::class, 'couleur_vendue_id');
    }

    public function couleurDemandee(): BelongsTo
    {
        return $this->belongsTo(Couleur::class, 'couleur_demandee_id');
    }

    // Une vente est une substitution si une couleur demandée a été précisée
    // et qu'elle diffère de la couleur réellement vendue.
    public function estSubstitution(): bool
    {
        return $this->couleur_demandee_id !== null
            && $this->couleur_demandee_id !== $this->couleur_vendue_id;
    }

    public function montantTotal(): int
    {
        return $this->prix_unitaire * $this->quantite;
    }
}