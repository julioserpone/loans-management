<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'installments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loan_id',
        'holyday_id',
        'installment_num',
		'status',
		'expired_date',
		'amount',
		'interest_amount',
		'total_amount'
    ];

    public function loan()
    {
        return $this->belongsTo('App\Loan');
    }

    public function payments()
    {
       return $this->hasMany('App\Payment');
    }

}
