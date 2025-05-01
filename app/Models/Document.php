<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Document extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'documents';

    protected $fillable = [
        'user_id',
        'type',
        'nom_fichier',
        'chemin',
        'mime_type',
        'taille',
        'est_public'
    ];

    protected $casts = [
        'est_public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documentable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return asset("storage/{$this->chemin}");
    }

    public function getTailleFormateeAttribute()
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->taille;
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}