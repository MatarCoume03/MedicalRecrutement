<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Candidature extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'candidatures';

    protected $fillable = [
        'user_id',
        'offre_emploi_id',
        'lettre_motivation',
        'statut',
        'feedback'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offreEmploi()
    {
        return $this->belongsTo(OffreEmploi::class, 'offre_emploi_id', '_id');
    }
    
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeAcceptees($query)
    {
        return $query->where('statut', 'accepte');
    }

    public function marquerCommeAcceptee()
    {
        $this->update(['statut' => 'accepte']);
    }

    public function marquerCommeRejetee($feedback = null)
    {
        $this->update([
            'statut' => 'rejete',
            'feedback' => $feedback
        ]);
    }
}