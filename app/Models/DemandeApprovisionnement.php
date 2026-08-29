<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeApprovisionnement extends Model
{
    use HasFactory;

    protected $table = 'demandes_approvisionnements';

    protected $fillable = [
        'vendeur_id',
        'marque_id',
        'couleur_id',
        'quantite_demandee',
        'statut',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class);
    }

    public function couleur(): BelongsTo
    {
        return $this->belongsTo(Couleur::class);
    }
}