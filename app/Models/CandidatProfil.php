<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CandidatProfil extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'candidat_profils';

    protected $fillable = [
        'user_id',
        'date_naissance',
        'genre',
        'nationalite',
        'ville',
        'bio',
        'specialite_medicale',
        'annees_experience',
        'niveau_etude',
        'langues'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'langues' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAgeAttribute()
    {
        return $this->date_naissance?->diffInYears(now());
    }
}