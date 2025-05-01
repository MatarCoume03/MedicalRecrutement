<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Competence extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'competences';

    protected $fillable = [
        'nom',
        'categorie',
        'is_validated'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('niveau', 'description');
    }

    public function offresEmploi()
    {
        return $this->belongsToMany(OffreEmploi::class)
                    ->withPivot('niveau_requis', 'est_obligatoire');
    }

    public function scopeMedicales($query)
    {
        return $query->where('categorie', 'Médical');
    }

    public function scopeValidees($query)
    {
        return $query->where('is_validated', true);
    }
}