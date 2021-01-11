<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Partner extends Authenticatable
{
    use HasFactory;
    /**
     *
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partners';

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

    /**
     * Relation
     *
     * @return void
     */
    public function user()
    {
        return $this->morphMany('App\Model\User', 'company');
    }

    /**
     * Relation
     *
     * @return void
     */
    public function zipcode()
    {
        return $this->belongsTo(Zipcode::class, 'zipcode_id','id');
    }

    /**
     * Relation
     *
     * @return void
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id','id');
    }

    /**
     * Relation
     *
     * @return void
     */
    public function certifications()
    {
        return $this->belongsToMany(Certification::class);
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCertificate($query, $certificate)
    {
        return $query->whereHas('certifications', function($q) use ($certificate){
            $q->where('certification_name', '=', $certificate);
        })->get();
    }

}
