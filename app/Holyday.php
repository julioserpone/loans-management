<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holyday extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'holydays';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'responsable_id',
        'holyday'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'responsable_id');
    }
}
