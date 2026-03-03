<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Inscription;
use App\Models\Classe;

class AnneeScolaire extends Model
{
    use HasFactory;

    // Spécifiez le nom exact de la table
    protected $table = 'annee_scolaires';

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'active',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'active' => 'boolean',
    ];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class, 'annee_scolaire_id');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class, 'annee_scolaire_id');
    }
}