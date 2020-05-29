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
    public function index()
    {
        $reservations = Reservation::all();
        
        if($reservations){// get all unique dates from the collection
            $grouped = $reservations->pluck('date')->unique();
            // make new collection
            $collection = new Collection();;
            // loop through plucked collection and get reservations for date
            foreach($grouped as $date) {
               $r = $reservations->where('date', $date);
               $obj = self::createDateObj($date, $r);
               $collection->put($date, $obj);
            }
            $sortedReservations = $collection->sortKeys();


            return view('desktop.reservations.combined.all', [
                'reservations' => $sortedReservations
            ]);
        }
    }
    
    public function indexForType($isGroup)
    {
        
        // check if type is one of the preset types
        if($type = $this->getType($isGroup)){
            $reservations = Reservation::where('type', $type)->get();
            
            if($reservations){// get all unique dates from the collection
                $grouped = $reservations->pluck('date')->unique();
                // make new collection
                $collection = new Collection();;
                // loop through plucked collection and get reservations for date
                foreach($grouped as $date) {
                   $r = $reservations->where('date', $date);
                   $obj = self::createDateObj($date, $r);
                   $collection->put($date, $obj);
                }
                $sortedReservations = $collection->sortKeys();
                return view('desktop.reservations.all', [
                    'reservations' => $sortedReservations,
                    'isGroup' => $isGroup
                ]);
            }
        }

        abort(404);
    }

   
   public function showAll()
    {   
        $today = Carbon::now();
        // show here
        $query = request()->query();

        if(Arr::exists($query, 'd')){
            $reservationsForDay = self::createDayObj($query['d'], 'ALL');
            return view('desktop.reservations.combined.day', [
                'reservationsForDay' => $reservationsForDay
                ]);
        } 
        // week
        if(Arr::exists($query, 'w')){

            $weekObj = self::createWeekObj($query['y'], $query['w'], 'ALL');

            return view('desktop.reservations.combined.week',[
                'week' => $weekObj
            ]);


        }
        // month
        if(Arr::exists($query, 'm')){

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
                $weekObj = self::createWeekObj($query['y'], $startWeekNumber, 'ALL');
                // add it to an array
                $monthArray[] = $weekObj;
            }
            return view('desktop.reservations.combined.month', [
                'month' => $monthArray, 
                'monthName' => $monthName, 
                'year' => $today->year
                ]);

        }

        // all
        if(Arr::exists($query, 's')){
            return self::index();
        }

        // if no query key exists, show 404
        abort(404);

    }

    public function showGroups()
    {   
        $today = Carbon::now();
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

            $weekObj = self::createWeekObj($query['y'], $query['w'], 'GRP');

            return view('desktop.reservations.week',[
                'week' => $weekObj,
                'isGroup' => $isGroup
            ]);


        }
        // month
        if(Arr::exists($query, 'm')){

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
                $weekObj = self::createWeekObj($query['y'], $startWeekNumber, 'GRP');
                // add it to an array
                $monthArray[] = $weekObj;
            }
            return view('desktop.reservations.month', [
                'month' => $monthArray, 
                'monthName' => $monthName, 
                'isGroup' => $isGroup,
                'year' => $today->year
                ]);

        }

        // all
        if(Arr::exists($query, 's')){
            return self::indexForType($isGroup);

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
            $url = 'day';
            $array = [
                'reservationsForDay' => $reservationsForDay,
                'isGroup' => $isGroup
                ];
        } 
        // week
        if(Arr::exists($query, 'w')){
            $weekObj = self::createWeekObj($year, $query['w'], 'RES');

            $url = 'week';
            $array = [
                'week' => $weekObj,
                'isGroup' => $isGroup
                ];
        }
        
        // all
        if(Arr::exists($query, 's')){
            return self::indexForType($isGroup);

        }
        // if no query key exists, show 404
        if (isset($url)) {
            return view('desktop.reservations.'.$url, $array);
        }

        abort(404);
    
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        $date = Carbon::now()->isoFormat('Y-MM-DD');
        return view('desktop.reservations.create', [
            'date' => $date,
            'prevUrl' => url()->previous()
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
                'date'  => $this->dateForDB($request->get('date')),
                'startTime'  => $request->get('startTime'),
                'notes' => $request->get('notes')
            ]);

            $reservation->save();
            $isGroup = true;

            
        return redirect()->route('showGroups', ['s' => 'all'])->with('success', 'Reservering toegevoegd');
            

        } elseif ($request->type === 'RES'){
           $request = self::validateGroup($request);
            $reservation = new Reservation([
                'type' => $request->get('type'),
                'name' => $request->get('name'),
                'size' => $request->get('size'),  
                'date'  => $this->dateForDB($request->get('date')),
                'startTime'  => $request->get('startTime'),
                'notes' => $request->get('notes')
            ]);

            $reservation->save();
            $isGroup = false;

            return redirect()->route('showRestaurant', ['s' => 'all'])->with('success', 'Reservering toegevoegd');
            
        }
    }
    public function getType($isGroup){
        if($isGroup){
            return 'GRP';
        }
        return 'RES';
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
        $reservation = $this->createResObj($id);
        return view('desktop.reservations.edit', compact('reservation'));
    }

    public function createResObj($id){
        $app = app();
        $resObj = $app->make('stdClass');

        $reservation = Reservation::find($id);
        $resObj->type = $reservation->type;
        $resObj->id = $reservation->id;
        $resObj->name = $reservation->name;
        $resObj->size = $reservation->size;
        $resObj->date = $this->formatDate($reservation->date);
        $resObj->startTime = $this->formatTime($reservation->startTime);
        $resObj->notes = $reservation->notes;

        return $resObj;
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


        $reservation->type = $request->get('type');
        $reservation->name = $request->get('name');
        $reservation->size = $request->get('size');
        $reservation->date = $this->dateForDB($request->get('date'));
        $reservation->startTime = $request->get('startTime');
        $reservation->notes = $request->get('notes');
        $reservation->save();

        $isGroup = $request->get('type');

        if($isGroup === "GRP"){
            $succesMsg = 'Groep gewijzigd';
            $route = 'showGroups';
        } else {
            $succesMsg = 'Reservering gewijzigd';
            $route = 'showRestaurant';
        }

        return redirect()->route($route, ['s' => 'all'])->with('success', $succesMsg);
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
        $isGroup = $reservation->type;
        $reservation->delete();
    
        if($isGroup === "GRP"){
            $succesMsg = 'Groep verwijderd';
            $route = 'showGroups';
        } else {
            $succesMsg = 'Reservering verwijderd';
            $route = 'showRestaurant';
        }

        return redirect()->route($route, ['s' => 'all'])->with('success', $succesMsg);

    }

    public function validateGroup($request){

        // update reservation
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'size' => ['required','int'],
            'date' => 'required',
            'startTime' => 'required'
        ]);

        return $request;
    }

    public function validateRes($request){

        // update reservation
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'size' => ['required','int'],
            'date' => 'required',
            'startTime' => 'required'
        ]);

        return $request;
    }


    // day object
    public function createDayObj($date, $type){
        $dateObj = new Carbon($date);
        // create the object in laravel
        $app = app();
        $dayObj = $app->make('stdClass');
        
        // set date for day in a certain format
        $dayObj->date = $date;

        $dayObj->formattedDate = $this->formatDate($date);

        $dayObj->weekNumber = $dateObj->weekOfMonth;
       
        // get the dayname from the carbon object
        $dayObj->day = $dateObj->dayName;
        
        // get the reservations for that day from the model
        $reservations = Reservation::where('date', $date)->get();
        if($type === 'ALL'){
            $reservationsForType = $reservations;
        } else {
            // sort the collection to return the type only
            $reservationsForType = $reservations->where('type', $type);
        }
        // add it to a object attribute
        $sorted = $reservationsForType->sortBy('startTime');
        $dayObj->reservations = $sorted;

        return $dayObj;
    }

    // returns a string
    public function formatDate($date){
        $formatted = date('d-m-Y', strtotime($date));
        return $formatted;
    }

    // returns a string
    public function formatTime($time){
        $formatted = date('H:i', strtotime($time));
        return $formatted;
    }

    public function dateForDB($date){
        $formatted = date('Y-m-d', strtotime($date));
        return $formatted;
    }

    public function createWeekObj($year, $weekNumber, $type){
        // create the object in laravel
        $app = app();
        $weekObj = $app->make('stdClass');
        
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
                $dayObj = self::createDayObj ($date->format('Y-m-d'), $type);
            
                // add them to the array
                $days[] = $dayObj;
            }

        $weekObj->days = $days;

        return $weekObj;

    }
    public function createDateObj($date, $reservations){
        // create the object in laravel
        $app = app();
        $dateObj = $app->make('stdClass');
        
        $dateObj->date = $this->formatDate($date);
       
        $date = new Carbon($date);
        $dateObj->dayName = $date->dayName;

        $dateObj->reservations = $reservations; 
        $groups = $reservations->where('type', 'GRP');
        $dateObj->groups = $groups;
        $res = $reservations->where('type', 'RES');
        $dateObj->res = $res;

        return $dateObj;

    } 
 
    public function change(Request $request){
       
        if ($request){
             $group = $request->get('group');

            if($group){
                $route = 'showGroups';
            } else {
                $route = 'showRestaurant';
            }
            $year = $request->get('y');
            $select = $request->get('select');
            $int = $request->get('int');
            $direction = $request->get('go');
 
            if($select === 'd'){
                // make carbon date from day int
                $date = Carbon::createFromFormat('Y-m-d', $int);
                if($direction === 'prev'){
                    // substract a day from the date
                    $date->subDay();
                }elseif($direction === 'next'){
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
                    if( $int <= 1){
                        $year--;
                        $date->setISODate($year, '52');
                    } else{
                    // substract a week from the date
                    $date->subWeek();
                }
                    
                } elseif($direction === 'next'){
                    if( $int >=  52){
                        $year++;
                        $date->setISODate($year, '1');
                    } else {
                        $date->addWeek();
                    }
                } else{
                    abort(404);
                }
                // make variable url from variables
                $url = $select.'='.$date->weekOfYear.'&y='.$year;
            } 

            if ($select === 'm') {
                $date = Carbon::createFromDate($year,$int,'01');
                if($direction === 'prev'){
                    if( $int <= 1){
                        $year--;
                        $date->month = 12;
                    } else {
                        // substract a day from the date
                        $date->subMonth();
                    }

                } elseif($direction === 'next'){
                    if( $int >= 12){
                        $year++;
                        $date = Carbon::createFromDate($year,'01','01');

                    } else {
                        $date->addMonth();
                    }
                }else{
                    abort(404);
                }
                // make variable url from variables
                $url = $select.'='.$date->month.'&y='.$year;
            }
            if (isset($url)){
                return redirect()->route($route, $url);
            }

            abort(404);
        }
        abort(404);
    }
}