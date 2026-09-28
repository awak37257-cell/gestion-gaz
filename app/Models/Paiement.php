<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
'client_id',
        'montant',
        'methode',
        'reference',     // <--- VÉRIFIEZ QUE CECI EST BIEN PRÉSENT !
        'date_paiement',
        'notes',
    ];

    protected $casts = [
        'date_paiement' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}