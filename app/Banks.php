<?php

/**
 * Loans system - Citites Model
 *
 * @author Julio Hernandez <juliohernandezs@gmail.com>
 *
 * @date(Nov 26 - 2015)
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banks extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banks';
    public $primaryKey = 'id';
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','status'];

}
