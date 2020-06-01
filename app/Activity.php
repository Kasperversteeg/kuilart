<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
    	'reservation_id',
        'startTime', 
        'endTime',
        'description',
        'size'
    ];
    public function reservation()
    {
    	return $this->belongsTo('App\Reservation');
    }
}
