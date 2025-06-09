<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'reference',
        'annee',
        'mois',
        'salaire_base',
        'primes',
        'heures_supplementaires',
        'indemnites',
        'deductions',
        'retenues_fiscales',
        'cotisations_sociales',
        'avances',
        'net_a_payer',
        'status',
        'date_paiement',
        'mode_paiement',
        'observations'
    ];

    protected $casts = [
        'annee' => 'integer',
        'mois' => 'integer',
        'salaire_base' => 'decimal:2',
        'primes' => 'decimal:2',
        'heures_supplementaires' => 'decimal:2',
        'indemnites' => 'decimal:2',
        'deductions' => 'decimal:2',
        'retenues_fiscales' => 'decimal:2',
        'cotisations_sociales' => 'decimal:2',
        'avances' => 'decimal:2',
        'net_a_payer' => 'decimal:2',
        'date_paiement' => 'date',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function genererReference(): string
    {
        $prefix = 'PAY';
        $annee = date('Y');
        $mois = date('m');
        $numero = static::whereYear('created_at', $annee)
            ->whereMonth('created_at', $mois)
            ->count() + 1;
        return sprintf('%s-%s%s-%04d', $prefix, $annee, $mois, $numero);
    }

    public function calculerNetAPayer(): float
    {
        $brut = $this->salaire_base + $this->primes + $this->heures_supplementaires + $this->indemnites;
        $total_deductions = $this->deductions + $this->retenues_fiscales + $this->cotisations_sociales + $this->avances;

        return $brut - $total_deductions;
    }

    public function getBrutAttribute(): float
    {
        return $this->salaire_base + $this->primes + $this->heures_supplementaires + $this->indemnites;
    }

    public function getTotalDeductionsAttribute(): float
    {
        return $this->deductions + $this->retenues_fiscales + $this->cotisations_sociales + $this->avances;
    }

    public function getNomMoisAttribute(): string
    {
        $mois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        return $mois[$this->mois] ?? '';
    }

    public function getPeriodeAttribute(): string
    {
        return $this->nom_mois . ' ' . $this->annee;
    }
}
