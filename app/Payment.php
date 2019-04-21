<?php

/**
 * Loans System - Loans Model
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'debt_collector_id',
        'loan_id',
        'installment_id',
        'surcharge_id',
        'status',
        'method',
        'type',
        'concept',
        'payment',
        'penalty_amount',
        'notes'
    ];

    public function loan()
    {
        return $this->belongsTo('App\Loan');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function debt_collector()
    {
        return $this->belongsTo('App\User', 'debt_collector_id');
    }

    public function installments()
    {
        return $this->belongsTo('App\Installment');
    }

    public function surcharges()
    {
        return $this->belongsTo('App\Surcharge');
    }
}
