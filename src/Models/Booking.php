<?php

namespace Selene\Modules\BookingModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static findOrFail($get)
 * @property  code
 */
class Booking extends Model
{
    protected $fillable = [
        'name',
        'tab_id',
        'code',
        'order',
        'is_default',
    ];

    protected $connection = 'mongodb';
    
    public function getTab()
    {
        return Tab::find($this->tab_id);
    }
}