<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'type',
        'telephone',
        'adresse',
        'photo',
        'is_active',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function candidatProfil()
    {
        return $this->hasOne(CandidatProfil::class);
    }

    public function recruteurProfil()
    {
        return $this->hasOne(RecruteurProfil::class);
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class)
                    ->withPivot('niveau', 'description');
    }

    public function offresEmploi()
    {
        return $this->hasMany(OffreEmploi::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function scopeCandidats($query)
    {
        return $query->where('type', 'candidat');
    }

    public function scopeRecruteurs($query)
    {
        return $query->where('type', 'recruteur');
    }

    public function isCandidat()
    {
        return $this->type === 'candidat';
    }

    public function isRecruteur()
    {
        return $this->type === 'recruteur';
    }

    public function isAdmin()
    {
        return $this->type === 'admin';
    }

    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}