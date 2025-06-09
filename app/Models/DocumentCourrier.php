<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentCourrier extends Model
{
    protected $table = 'documents_courriers';

    protected $fillable = [
        'courrier_id',
        'nom_document',
        'nom_fichier',
        'chemin_fichier',
        'type_mime',
        'taille_fichier',
        'type_document',
        'description'
    ];

    public function courrier(): BelongsTo
    {
        return $this->belongsTo(Courrier::class);
    }

    public function getTailleHumaineLisibleAttribute(): string
    {
        $bytes = $this->taille_fichier;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}