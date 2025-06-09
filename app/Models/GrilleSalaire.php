<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrilleSalaire extends Model
{
    protected $table = 'grilles_salaire';

    protected $fillable = [
        'grade',
        'echelon',
        'salaire_base',
        'indice',
        'date_effet',
        'actif'
    ];

    protected $casts = [
        'salaire_base' => 'decimal:2',
        'indice' => 'decimal:2',
        'date_effet' => 'date',
        'actif' => 'boolean',
    ];

    public static function getSalaireBase(string $grade, string $echelon): ?float
    {
        $grille = static::where('grade', $grade)
            ->where('echelon', $echelon)
            ->where('actif', true)
            ->first();

        return $grille?->salaire_base;
    }
}