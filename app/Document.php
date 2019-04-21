<?php

/**
 * Loans system - Customer Model
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Nov 24 - 2015)
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {

    protected $table = 'documents';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'document_type',
        'document_description',
        'document_url',
    ];
}
