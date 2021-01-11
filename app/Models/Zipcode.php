<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'zipcodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zipcode',
        'city',
        'country_id',
    ];

    public function partner()
    {
        return $this->hasMany(Partner::class);
    }
}
