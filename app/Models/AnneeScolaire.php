<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Evaluation;
use App\Models\EmploiDuTemps;

class AnneeScolaire extends Model
{
    use HasFactory;

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

    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function emploiDuTemps(): HasMany
    {
        return $this->hasMany(EmploiDuTemps::class);
    }


     /**
     * Scope pour récupérer l'année active
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Accesseur pour l'affichage
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->nom . ($this->active ? ' (En cours)' : '');
    }

    /**
     * Vérifie si une date est dans cette année scolaire
     */
    public function containsDate($date): bool
    {
        $date = \Carbon\Carbon::parse($date);
        return $date->between($this->date_debut, $this->date_fin);
    }
}
