<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'name', 
        'notes', 
        'date',  
        'size', 
        'startTime', 
        'type'
    ];

	public function activities()
	{
		return $this->hasMany('App\Activity');
	}

}
