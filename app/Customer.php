<?php

/**
 * Loans system - Customer Model
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * @date(Nov 24 - 2015)
 */

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';
    public $timestamps = true;
    public $primaryKey = 'user_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'bank_id',
        'card_number',
        'card_key',
        'city_id',
        'address',
        'notes',
        'email',
        'company',
        'contract_type',
        'company_temporal',
        'company_position',
        'company_salary',
        'company_time_worked',
        'company_eps',
        'company_affiliation_type',
        'company_city_id',
        'company_address',
        'company_cellphone',
        'company_landphone',
        'reference_type',
        'reference_relationship',
        'reference_identification_type',
        'reference_identification',
        'reference_first_name',
        'reference_last_name',
        'reference_city_id',
        'reference_address',
        'reference_cellphone',
        'reference_landphone',
        'reference_email',
    ];

    /**
     * Get business user
     * @return belongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get city customer
     * @return belongsTo
     */
    public function city() {
        return $this->belongsTo('App\Cities')->withTrashed();
    }

    /**
     * Get city company
     * @return belongsTo
     */
    public function cityCompany() {
        return $this->belongsTo('App\Cities', 'company_city_id')->withTrashed();
    }

    /**
     * Get city reference
     * @return belongsTo
     */
    public function cityReference() {
        return $this->belongsTo('App\Cities', 'reference_city_id')->withTrashed();
    }

    /**
     * Get bank
     * @return belongsTo
     */
    public function bank() {
        return $this->belongsTo('App\Banks')->withTrashed();
    }

    /**
     * Get the documents for the customer.
     */
    public function documents() {
        return $this->hasMany('App\Document');
    }

    /**
     * Get Loans for the customer.
     */
    public function loans() {
        return $this->hasMany('App\Loan', 'user_id');
    }

    public static function create(array $attr = []) {
        if (!isset($attr['user_id']) && isset($attr['user'])) {
            $user = User::create($attr['user']);
            $attr['user_id'] = $user->id;
            unset($attr['user']);
        }
        return parent::create($attr);
    }
}
