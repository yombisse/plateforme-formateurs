<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'nom_complet',
        'telephone',
        'email',
        'mode_paiement',
        'statut_paiement',
        'statut_inscription',
        'motif_rejet',
        'rejet_par',
        'valide_par',
        'date_validation',
        'date_rejet',
    ];

    protected $casts = [
        'statut_paiement' => 'string',
        'statut_inscription' => 'string',
        'date_validation' => 'datetime',
        'date_rejet' => 'datetime',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejet_par');
    }
}
