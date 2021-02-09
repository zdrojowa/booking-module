<?php

namespace Selene\Modules\BookingModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static findOrFail($get)
 */
class Tab extends Model
{
    protected $fillable = [
        'name',
        'link',
        'logo',
        'order',
        'include_all_bookings'
    ];

    protected $connection = 'mongodb';

    public function bookings()
    {
        return $this->hasMany('Selene\Modules\BookingModule\Models\Booking')->orderBy('order');
    }

}
