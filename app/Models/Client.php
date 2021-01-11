<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cvr',
        'company_name',
        'company_address',
        'zipcode_id',
        'country_id',
    ];

    public function user()
    {
        return $this->morphMany('App\Model\User', 'company');
    }
}
