<?php

namespace App;
/*
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Helpers;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract*/
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers;

class User extends Authenticatable
{
    //use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
        'first_name',
        'last_name',
        'pic_url',
        'gender',
        'identification_type',
        'identification',
        'birth_date',
        'cellphone_number',
        'homephone_number',
        'email',
        'password',
        'verified',
        'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function scopeActives($query)
    {
        $query->where('status', '!=', 'delete');
    }

    /**
     * checking Identification numbers in the table, in order to guarantee its unique value
     *
     * @param  [string] $type Identification type
     * @param  [string] $iden Identification string
     * @param  [string] $id User
     * @return query
     */
    public function scopeExistsIdentification($query, $type, $iden, $id = '')
    {
        $query->where('identification_type', $type)
            ->where('identification', $iden)
            ->where(function ($query) use ($id) {
                if ($id != '') {
                    $query->whereRaw("id != '".$id."'");
                }
            });
    }

    public function customer()
    {
        return $this->hasOne('App\Customer');
    }

    public function loans()
    {
        return $this->hasMany('App\Loan');
    }

    public function surcharges()
    {
        return $this->hasMany('App\Surcharge');
    }

    public function Holyday()
    {
        return $this->hasMany('App\Holyday', 'responsable_id');
    }

    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->attributes['role'], $role);
        }

        return $this->attributes['role'] == $role;
    }

    public function isAdministrator()
    {
        return $this->attributes['role'] == 'admin';
    }

    public function isCustomer()
    {
        return $this->attributes['role'] == 'customer';
    }

    static function cantUpdate($id)
    {
        return \Auth::check() &&
               ( \Auth::id() == $id ||
               ( \Auth::user() && in_array( \Auth::user()->role, ['admin']) ) ) ;
    }

    static function cantDelete($id)
    {
        return \Auth::user() && in_array(\Auth::user()->role, ['admin']) ;
    }

    public function fullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    public function getFullIdentificationAttribute()
    {
        return trans('globals.identification_type.'.$this->identification_type).' - '.\Utility::codeMasked($this->identification);
    }

    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->birth_date)->age;
    }

    public function scopeInactives($query)
    {
        return $query->where('status', 0);
    }

    public function payments()
    {
        return $this->hasMany('App\Payments');
    }

    public function debt_collector()
    {
        return $this->hasMany('App\Payments', 'id', 'debt_collector_id');
    }

}
