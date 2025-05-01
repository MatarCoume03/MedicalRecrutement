<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class RecruteurProfil extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'recruteur_profils';

    protected $fillable = [
        'user_id',
        'entreprise',
        'secteur_activite',
        'poste_occupe',
        'site_web',
        'logo',
        'description_entreprise'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}