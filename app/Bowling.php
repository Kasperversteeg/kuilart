<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bowling extends Model
{
    protected $fillable = [
    	'name',
    	'startTime',
    	'endTime',
    	'lane',
    	'date'
    ];

    public static function bowlingForDate($date)
    {
    	return Bowling::where('date', $date)->get();
    }
}
