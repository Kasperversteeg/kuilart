<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Reservation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // for now a workaround to return to the pages you've created or altered a reservation from
    protected $prevUrl = '';
    protected function setPrevious(){
        $prevUrl = url()->previous();
    }

    // day object
    public function createDayObj($date, $type){
        $dateObj = new Carbon($date);
        // create the object in laravel
        $app = app();
        $dayObj = $app->make('stdClass');
        
        // set date for day in a certain format
        $dayObj->date = $date;

        $dayObj->weekNumber = $dateObj->weekOfMonth;
       
        // get the dayname from the carbon object
        $dayObj->day = $dateObj->dayName;
        
        // get the reservations for that day from the model
        $reservations = Reservation::where('date', $date)->get();
        // sort the collection to return the type only
        $reservationsForType = $reservations->where('type', $type);
        // add it to a object attribute
        $dayObj->reservations = $reservationsForType;

        return $dayObj;
    }

    public function createWeekObj($year, $weekNumber, $type){
        // create the object in laravel
        $app = app();
        $weekObj = $app->make('stdClass');
        
        $weekObj->weekNumber = $weekNumber;

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
                $dayObj = self::createDayObj ($date->format('Y-m-d'), $type);
            
                // add them to the array
                $days[] = $dayObj;
            }

        $weekObj->days = $days;

        return $weekObj;

    }
    
 
    public function change(Request $request){
       
        if ($request){
             $group = $request->get('group');

            if($group){
                $route = 'showGroups';
            } else {
                $route = 'showRestaurant';
            }
            $year = '2020';
            $select = $request->get('select');
            $int = $request->get('int');
            $direction = $request->get('go');
 
            if($select === 'd'){
                // make carbon date from day int
                $date = Carbon::createFromFormat('Y-m-d', $int);
                if($direction === 'prev'){
                    // substract a day from the date
                    $date->subDay();
                } elseif($direction === 'next'){
                    $date->addDay();
                }else{
                    abort(404);
                }
                // convert to usable format
                $dateToString = $date->isoFormat('Y-MM-DD');
                // make variable url from variables
                $url = $select.'='.$dateToString;
            } 
            if ($select === 'w') {
                $date = new Carbon();
                $date->setISODate($year, $int);
                if($direction === 'prev'){
                    // substract a day from the date
                    $date->subWeek();
                } elseif($direction === 'next'){
                    $date->addWeek();
                } else{
                    abort(404);
                }
                // make variable url from variables
                $url = $select.'='.$date->weekOfYear;
            } 

            if ($select === 'm') {
                $date = Carbon::createFromDate($year,$int,'01');
                if($direction === 'prev'){
                    // substract a day from the date
                    $date->subMonth();
                } elseif($direction === 'next'){
                    $date->addMonth();
                }else{
                    abort(404);
                }
                // make variable url from variables
                $url = $select.'='.$date->month;
            }
            if (isset($url)){
                return redirect()->route($route, $url);
            }

            abort(404);
        }
        abort(404);
    }
    
    
    public function index($isGroup)
    {

        $today = Carbon::now()->isoFormat('dddd D MMMM');

        if($isGroup === true){
            //get all reservations for type
            $reservations = Reservation::where('type', 'GRP')->get();
            // get all unique dates from the collection
            $grouped = $reservations->pluck('date')->unique();
            // make new collection
            $collection = new Collection();;
            // loop through plucked collection and get reservations for date
            foreach($grouped as $date) {
               $r = $reservations->where('date', $date);
               $collection->put($date, $r);
            }
            $sortedReservations = $collection->sortKeys();

            return view('desktop.reservations.all', [
                'reservations' => $sortedReservations,
                'today' => $today,
                'isGroup' => $isGroup
            ]);

        } elseif ($isGroup === false){
            //get all reservations for type
            $reservations = Reservation::where('type', 'RES')->get();
            // get all unique dates from the collection
            $grouped = $reservations->pluck('date')->unique();
            // make new collection
            $collection = new Collection();;
            // loop through plucked collection and get reservations for date
            foreach($grouped as $date) {
               $r = $reservations->where('date', $date);
                $collection->put($date, $r);
            }
            $sortedReservations = $collection->sortKeys();

            return view('desktop.reservations.all', [
                'reservations' => $sortedReservations,
                'today' => $today,
                'isGroup' => $isGroup
            ]);


        } else {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        self::setPrevious();
        $date = Carbon::now()->isoFormat('Y-MM-DD');
        return view('desktop.reservations.create', [
            'date' => $date
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->type === 'GRP'){
            $request = self::validateGroup($request);
            $reservation = new Reservation([
                'type' => $request->get('type'),
                'name' => $request->get('name'),
                'size' => $request->get('size'),  
                'date'  => $request->get('date'),
                'startTime'  => $request->get('startTime'),
                'notes' => $request->get('notes')
            ]);
        
            $reservation->save();

            return redirect(self::$prevUrl)->with('success', 'Reservering toegevoegd');
        } elseif ($request->type === 'RES'){
            $request = self::validateGroup($request);
            $reservation = new Reservation([
                'name' => $request->get('name'),
                'size' => $request->get('size'),  
                'date'  => $request->get('date'),
                'startTime'  => $request->get('startTime'),
                'notes' => $request->get('notes')
            ]);
        
            $reservation->save();

            return redirect(self::$prevUrl)->with('success', 'Reservering toegevoegd');
        } else {
           abort(404); 
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showGroups()
    {   
        $today = Carbon::now();
        $year = $today->year;
        // show here
        $query = request()->query();
        $isGroup = true;

        if(Arr::exists($query, 'd')){
            $reservationsForDay = self::createDayObj($query['d'], 'GRP');
            return view('desktop.reservations.day', [
                'reservationsForDay' => $reservationsForDay, 
                'isGroup' => $isGroup
                ]);
        } 
        // week
        if(Arr::exists($query, 'w')){

            $weekObj = self::createWeekObj($year, $query['w'], 'GRP');

            return view('desktop.reservations.week',[
                'week' => $weekObj,
                'isGroup' => $isGroup
            ]);


        }
        // month
        if(Arr::exists($query, 'm')){

            $date = Carbon::createFromDate($year,$query['m'],'01');
            $monthName = $date->monthName; 

            // create month array
            $monthArray = [];

            //start of month
            $startWeekNumber = $date->firstOfMonth()->weekOfYear;
            //end of month
            $endWeekNumber = $date->lastOfMonth()->weekOfYear;

            // loop from start of week to end of the week
            for ($startWeekNumber; $startWeekNumber <= $endWeekNumber; $startWeekNumber++) { 
                // create weekobj with reservations within for weeknumber
                $weekObj = self::createWeekObj($year, $startWeekNumber, 'GRP');
                // add it to an array
                $monthArray[] = $weekObj;
            }

            return view('desktop.reservations.month', [
                'month' => $monthArray, 
                'monthName' => $monthName, 
                'isGroup' => $isGroup
                ]);

        }

        // all
        if(Arr::exists($query, 's')){
            return self::index($isGroup);

        }
        // if no query key exists, show 404
        abort(404);

    }

    public function showRestaurant()
    {
   
        $today = Carbon::now();
        $year = $today->year;
        // show here
        $query = request()->query();
        $isGroup = false;

        if(Arr::exists($query, 'd')){
            $reservationsForDay = self::createDayObj($query['d'], 'RES');
            return view('desktop.reservations.day', [
                'reservationsForDay' => $reservationsForDay, 
                'isGroup' => $isGroup
                ]);
        } 
        // week
        if(Arr::exists($query, 'w')){

            $weekObj = self::createWeekObj($year, $query['w'], 'RES');

            return view('desktop.reservations.week',[
                'week' => $weekObj,
                'isGroup' => $isGroup
            ]);


        }
        // month
        if(Arr::exists($query, 'm')){

            $date = Carbon::createFromDate($year,$query['m'],'01');
           
            $monthName = $date->monthName; 

            // create month array
            $monthArray = [];

            //start of month
            $startWeekNumber = $today->firstOfMonth()->weekOfYear;
            //end of month
            $endWeekNumber = $today->lastOfMonth()->weekOfYear;

            // loop from start of week to end of the week
            for ($startWeekNumber; $startWeekNumber <= $endWeekNumber; $startWeekNumber++) { 
                // create weekobj with reservations within for weeknumber
                $weekObj = self::createWeekObj($year, $startWeekNumber, 'RES');
                // add it to an array
                $monthArray[] = $weekObj;
            }

            return view('desktop.reservations.month', [
                'month' => $monthArray, 
                'monthName' => $monthName, 
                'isGroup' => $isGroup
                ]);

        }

        // all
        if(Arr::exists($query, 's')){
            return self::index($isGroup);

        }
        // if no query key exists, show 404
        abort(404);

    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // redirect to update view
        $reservation = Reservation::find($id);
        return view('desktop.reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateRequest = self::validateGroup($request);
        $reservation = Reservation::find($id);
        $reservation->name = $request->get('name');
        $reservation->size = $request->get('size');
        $reservation->date = $request->get('date');
        $reservation->time = $request->get('time');
        $reservation->notes = $request->get('notes');
        $reservation->save();

        return redirect(route('showReservations', 'all'))->with('success', 'Reservering gewijzigd');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();

        return redirect(route('showReservations', 'all'))->with('success', 'Reservering verwijderd');

    }

    public function validateGroup($request){

        // update reservation
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'size' => ['required','int'],
            'date' => 'required',
            'startTime' => ['required', 'date_format:H:i']
        ]);

        return $request;
    }


}

