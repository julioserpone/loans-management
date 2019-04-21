<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surcharge extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surcharges';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'loan_id',
        'concept',
        'amount'
    ];

    public function loan()
    {
        return $this->belongsTo('App\Loan');
    }

    public function payments()
    {
       return $this->hasMany('App\Payment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
