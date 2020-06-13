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
        'type',
        'mail',
        'phoneNr'
    ];

	public function activities()
	{
		return $this->hasMany('App\Activity')->orderBy('startTime');
	}


    public function updateTableNr($tableNr)
    {
        $this->tableNr = $tableNr;
        $this->save();
        return true;
    }

   
}
