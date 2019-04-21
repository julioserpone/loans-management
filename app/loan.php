<?php

/**
 * Loans system - Loans Model
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Dec 01 - 2015)
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'loans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'interest_rate',
        'payment_freq_id',
        'installments',
        'first_payment',
        'penalty_rate'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function paymentFreq()
    {
        return $this->belongsTo('App\PaymentFreq');
    }

    public function _installments()
    {
        return $this->hasMany('App\Installment');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function surcharges()
    {
        return $this->hasMany('App\Surcharge');
    }

    public function scopeFromUser($query, $id = '')
    {
        if ($id != '') {
            $query->where('user_id', $id);
        }
    }
}
