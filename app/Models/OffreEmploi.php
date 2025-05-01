<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class OffreEmploi extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'offre_emplois';

    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'specialite_requise',
        'annees_experience_requises',
        'niveau_etude_requis',
        'type_contrat',
        'localisation',
        'salaire_min',
        'salaire_max',
        'date_limite',
        'statut',
        'is_urgent'
    ];

    protected $casts = [
        'date_limite' => 'datetime',
        'is_urgent' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
    
    public function competences()
    {
        return $this->embedsMany(Competence::class);
    }
    
    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'offre_emploi_id', '_id');
    }

    public function scopeApprouvees($query)
    {
        return $query->where('statut', 'approuve');
    }

    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }

    public function scopeUrgentes($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeValides($query)
    {
        return $query->where('statut', 'approuve')
                    ->where('date_limite', '>=', new \MongoDB\BSON\UTCDateTime(now()));
    }

    public function estExpiree()
    {
        return $this->date_limite < now();
    }
}