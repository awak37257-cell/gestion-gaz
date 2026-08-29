<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventaireLigne extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventaire_id',
        'couleur_id',
        'quantite_pleines_comptee',
        'quantite_vides_comptee',
        'quantite_pleines_theorique',
        'quantite_vides_theorique',
    ];

    public function inventaire(): BelongsTo
    {
        return $this->belongsTo(Inventaire::class);
    }

    public function couleur(): BelongsTo
    {
        return $this->belongsTo(Couleur::class);
    }

    public function ecartPleines(): int
    {
        return $this->quantite_pleines_comptee - $this->quantite_pleines_theorique;
    }

    public function ecartVides(): int
    {
        return $this->quantite_vides_comptee - $this->quantite_vides_theorique;
    }
}