<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'depot_id',
        'date_heure',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
    ];

    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(InventaireLigne::class);
    }
}