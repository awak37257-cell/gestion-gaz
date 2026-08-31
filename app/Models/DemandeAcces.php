<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeAcces extends Model
{
    use HasFactory;

    protected $table = 'demandes_acces';

    protected $fillable = [
        'nom_entreprise',
        'nom_contact',
        'email',
        'telephone',
        'periode_souhaitee',
        'message',
        'statut',
        'client_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
