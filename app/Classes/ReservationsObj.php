<?php
namespace App\Classes;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Reservation;
use Illuminate\Support\Arr;

class ReservationsObj{
	public $date;

	public $grp;
	public $res;
	public $all;

    public function __construct()
    {
        $this->grp = config('constants.types.group');
        $this->res = config('constants.types.restaurant');
        $this->all = config('constants.types.all');
    }

    public function getReservationsForType($query, $type){
        $resObject = new \stdClass();
        $resObject->type = $type;
        if($query){
            // check for D in array, if yes retun day view
            if(Arr::exists($query, 'd')){
                $resObject->url = 'day';
                $resObject->array = [
                    'day' => $this->createDayObj($query['d'], $type)
                    ];
            }

            // check for w in array, if yes retun week view
            if(Arr::exists($query, 'w')){
                $resObject->url = 'week';
                $resObject->array = [
                    'week' => $this->createWeekObj($query['y'], $query['w'], $type)
                ];

            }
            // check for m in array, if yes retun month view
            if(Arr::exists($query, 'm')){
                $obj = $this->createMonthObj($query, $type);
                $resObject->url = $obj->url;
                $resObject->array = $obj->array;      
            }
            return $resObject;
        }
        abort(404);
    }

	public function createDayObj($date, $type){
        $dayObj = new \stdClass();
        $this->date = new Carbon($date);
        // set date for day in a certain format
        $dayObj->date = $date;
        $dayObj->formattedDate = formatDate($date);
        $dayObj->weekNumber = $this->date->weekOfMonth;

        // get the dayname from the carbon object
        $dayObj->day = $this->date->dayName;
        // get the reservations for that day from the model
        $reservations = Reservation::where('date', $date)->get();

	    if($type === $this->all){
           $sorted = $reservations->sortBy('startTime');
        } else {
            // sort the collection to return the type only
            $reservationsForType = $reservations->where('type', $type);
            $sorted = $reservationsForType->sortBy('startTime');
        }

        $dayObj->reservations = $sorted;

        return $dayObj;
    }

    public function createWeekObj($year, $weekNumber, $type){
        // create the object in laravel
        $app = app();
        $weekObj = new \stdClass();
        
        $weekObj->weekNumber = $weekNumber;
        $weekObj->year = $year;

        // set date for weeknr and year
        $date = new Carbon();
        $date->setISODate($year, $weekNumber);

        // get the first and last day
        $weekObj->start = $date->startOfWeek()->format('Y-m-d');
        $weekObj->end = $date->endOfWeek()->format('Y-m-d');
        // make carbon period for week
        $dateRange = CarbonPeriod::create($weekObj->start, $weekObj->end);

        $days = [];
        foreach($dateRange as $date) {
            // make dayObj object
            $dayObj = $this->createDayObj ($date->format('Y-m-d'), $type);
        
            // add them to the array
            $days[] = $dayObj;
        }

        $weekObj->days = $days;

        return $weekObj;
    }

     // month class
    public function createMonthObj($query, $type){
        $monthObj = new \stdClass();

        $date = Carbon::createFromDate($query['y'],$query['m'],'01');
        $monthName = $date->monthName; 

        // create month array
        $monthArray = [];

        //start of month
        $startWeekNumber = $date->firstOfMonth()->weekOfYear;
        //end of month
        $endWeekNumber = $date->lastOfMonth()->weekOfYear;

        if($startWeekNumber == 52){
            $startWeekNumber = 1; 
        }
        // loop from start of week to end of the week
        for ($startWeekNumber; $startWeekNumber <= $endWeekNumber; $startWeekNumber++) { 
            // create weekobj with reservations within for weeknumber
            $weekObj = $this->createWeekObj($query['y'], $startWeekNumber, $type);
            // add it to an array
            $monthArray[] = $weekObj;
        }
        $monthObj->url = 'month';
        $monthObj->array = [
            'month' => $monthArray, 
            'monthName' => $monthName,
            'year' => $query['y']
        ];
        return $monthObj;
   }
	
}

