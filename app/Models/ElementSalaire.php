<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementSalaire extends Model
{
    protected $table = 'elements_salaire';

    protected $fillable = [
        'nom',
        'code',
        'type',
        'mode_calcul',
        'valeur',
        'obligatoire',
        'imposable',
        'description'
    ];

    protected $casts = [
        'valeur' => 'decimal:2',
        'obligatoire' => 'boolean',
        'imposable' => 'boolean',
    ];

    public function calculerMontant(float $salaireBase, float $montantVariable = null): float
    {
        switch ($this->mode_calcul) {
            case 'fixe':
                return $this->valeur;
            case 'pourcentage':
                return ($salaireBase * $this->valeur) / 100;
            case 'variable':
                return $montantVariable ?? 0;
            default:
                return 0;
        }
    }
}