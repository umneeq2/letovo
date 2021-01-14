<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pupil extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'mobile_phone', 'email', 'address', 'address_normalized', 'geo_lat', 'geo_lon'
    ];
}
