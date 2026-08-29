<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'depot_id',
        'nom',
        'token_qr',
        'actif',
    ];

    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class);
    }

    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class);
    }

    public function demandesApprovisionnement(): HasMany
    {
        return $this->hasMany(DemandeApprovisionnement::class);
    }
}