<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
    	'reservation_id',
        'startTime', 
        'endTime',
        'description'
    ];
    public function reservation()
    {
    	return $this->belongsTo('App\Reservation');
    }
}
