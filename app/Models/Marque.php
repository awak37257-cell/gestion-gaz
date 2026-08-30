<?php

namespace App\Models;

use App\Models\Scopes\ClientScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marque extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'nom',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ClientScope);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function couleurs(): HasMany
    {
        return $this->hasMany(Couleur::class);
    }

    public function demandesApprovisionnement(): HasMany
    {
        return $this->hasMany(DemandeApprovisionnement::class);
    }
}