<?php

/**
 * Loans System - Loans Model
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentFreq extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments_freq';
    public $timestamps = true;

    public function loans()
    {
        return $this->hasMany('App\Loan');
    }
}
