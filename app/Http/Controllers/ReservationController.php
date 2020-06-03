<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Reservation;
use App\Activity;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class ReservationController extends Controller
{
    private $grp, $res, $all;
    public function __construct()
    {
        $this->grp = config('constants.types.group');
        $this->res = config('constants.types.restaurant');
        $this->all = config('constants.types.all');
    }

    public function updateTableNr(Request $request, $id){

        $reservation = Reservation::find($id);
        $validated = $request->validate([ 'tableNr' => ['required', 'int']]);
        $reservation->updateTableNr($validated['tableNr']);

        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // for now is set to false, need to make global function
    public function isMobile(){
        return false;
    }

    public function index($isGroup)
    {

        if($this->isAll($isGroup)){           
            $reservations = Reservation::all();
            $sortedReservations = $this->sortReservationsByDate($reservations);
        } else {
              // check if type is one of the preset types
            if($type = $this->getType($isGroup)){
                $reservations = Reservation::where('type', $type)->get();     
                $sortedReservations = $this->sortReservationsByDate($reservations);        
            }
        }
        

        if(isset($sortedReservations)){
            if($this->isMobile()){
                return view('mobile.reservations.all', [
                    'reservations' => $sortedReservations,
                    'isGroup' => $isGroup
                ]);
            }
            return view('desktop.reservations.all', [
                'reservations' => $sortedReservations,
                'isGroup' => $isGroup
            ]);
        }

        abort(404);
    }
    // later i found out there is a 'grouped' function.... implement later
    public function sortReservationsByDate($reservations)
    {
        if($reservations){
        // get all unique dates from the collection
            $grouped = $reservations->pluck('date')->unique();
            // make new collection
            $collection = new Collection();;
            // loop through plucked collection and get reservations for date
            foreach($grouped as $date) {
               $r = $reservations->where('date', $date);
               $obj = $this->createDateObj($date, $r);
               $collection->put($date, $obj);
            }
            $sortedReservations = $collection->sortKeys();
            return $sortedReservations;
        }
        abort(404);
    }


    // going to be the one show function
    public function show(Reservation $reservation)
    {
        //
    }
    
   
   public function showAll()
    {  
        // get array with requests
        $query = request()->query();

       // all
        if(Arr::exists($query, 's')){
            return $this->index($this->all);
        } else {
            $groupObj = $this->getReservationsForType($query, $this->all);

            if (isset($groupObj)) {
                if($this->isMobile()){
                    $groupObj->array['isGroup'] =  $this->all;  
                    return view('mobile.reservations.'.$groupObj->url, $groupObj->array);
                }
                $groupObj->array['isGroup'] =  $this->all;
                return view('desktop.reservations.'.$groupObj->url, $groupObj->array);
            }
        }
        // if no query key exists, show 404
        abort(404);
    }
    
    public function showGroups()
    {   
        // get array with requests
        $query = request()->query();

       // all
        if(Arr::exists($query, 's')){
            return $this->index($this->grp);
        } else {
            $groupObj = $this->getReservationsForType($query, $this->grp);

            if (isset($groupObj)) {
                if($this->isMobile()){
                    $groupObj->array['isGroup'] =  $this->grp;
                    return view('mobile.reservations.'.$groupObj->url, $groupObj->array);
                }
                $groupObj->array['isGroup'] =  $this->grp;
                return view('desktop.reservations.'.$groupObj->url, $groupObj->array);
            }
        }
        // if no query key exists, show 404
        abort(404);
    }

    public function showRestaurant()
    {
        // get array with requests
        $query = request()->query();

       // all
        if(Arr::exists($query, 's')){
            return $this->index($this->res);
        } else {
            $groupObj = $this->getReservationsForType($query, $this->res);

            if (isset($groupObj)) {
                if($this->isMobile()){
                    $groupObj->array['isGroup'] =  $this->res;
                    return view('mobile.reservations.'.$groupObj->url, $groupObj->array);
                }
                $groupObj->array['isGroup'] =  $this->res;
                return view('desktop.reservations.'.$groupObj->url, $groupObj->array);
        }
        }

        // if no query key exists, show 404
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
            'date' => $date
        ]);
    }
    public function createGroup()
    {   
        $date = Carbon::now()->isoFormat('Y-MM-DD');
        return view('desktop.reservations.createGroup', [
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
            $request = $this->validateRes($request);
            $reservation = new Reservation([
                'type' => $this->res,
                'name' => $request->get('name'),
                'size' => $request->get('size'),  
                'date'  => $this->dateForDB($request->get('date')),
                'startTime'  => $request->get('startTime'),
                'notes' => $request->get('notes')
            ]);

            $reservation->save();

            return redirect()->route('showRestaurant', ['s' => 'all'])->with('success', 'Reservering toegevoegd');
    }
    public function storeGroup(Request $request)
        {
                //Validate input
                $request = $this->validateGroup($request);
                $request = $this->validateActivity($request);
                $reservation = new Reservation([
                    'type' => $this->grp,
                    'name' => $request->get('name'),
                    'size' => $request->get('size'),  
                    'date'  => $this->dateForDB($request->get('date')),
                    'startTime'  => $request->get('startTime'),
                    'notes' => $request->get('notes')
                ]);

                $reservation->save();

                $activity = new Activity([
                    'startTime' => $request->get('act-startTime'), 
                    'endTime' => $request->get('act-endTime'), 
                    'description' => $request->get('act-description'), 
                    'reservation_id' => $reservation->id, 
                    'size' => $request->get('act-size')
                ]); 
                $activity->save();
      
            return redirect()->route('showGroups', ['s' => 'all'])->with('success', 'Reservering toegevoegd');
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
        if($reservation->type === $this->grp){
            $activities = $reservation->activities;
            return view('desktop.reservations.editGroup', [
                'reservation' => $reservation,
                'activities' => $activities
            ]);
        }
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
        $resObj->activities = $reservation->activities;

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

        return redirect()->route($route, ['s' => 'all'])->with('success', 'Reservering gewijzigd');
    }

    public function updateGroup(Request $request, $id)
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

        return redirect()->route($route, ['s' => 'all'])->with('success', 'Reservering gewijzigd');
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
    
        if($isGroup === $this->grp){
            $succesMsg = 'Groep verwijderd';
            $route = 'showGroups';
        } else {
            $succesMsg = 'Reservering verwijderd';
            $route = 'showRestaurant';
        }

        return redirect()->route($route, ['s' => 'all'])->with('success', $succesMsg);

    }

   public function validateActivity($request)
    {
        // check activity input
         $request->validate([
            'act-startTime' => 'required',
            'act-endTime' => 'required',
            'act-description' => 'required'
        ]);

        return $request;
    }

    public function validateGroup($request)
    {
        // check group input
        $request->validate([
            'name' => 'required',
            'size' => ['required','int'],
            'date' => 'required',
            'startTime' => 'required'
        ]);

        return $request;
    }

    public function validateRes($request)
    {
        // check reservation input
        $request->validate([
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

        if($this->isAll($type)){
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
                $dayObj = $this->createDayObj ($date->format('Y-m-d'), $type);
            
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
        $dateObj->groups = $reservations->where('type', $this->grp);
        $dateObj->res = $reservations->where('type', $this->res);

        return $dateObj;

    } 

    public function getReservationsForType($query, $type){
        $app = app();
        $object = $app->make('stdClass');
        $object->type = $type;
        if($query){
            // check for D in array, if yes retun day view
            if(Arr::exists($query, 'd')){
                $dayObj = $this->createDayObj($query['d'], $type);

                $object->url = 'day';
                $object->array = [
                    'day' => $dayObj
                    ];
            }

            // check for w in array, if yes retun week view
            if(Arr::exists($query, 'w')){

                $weekObj = $this->createWeekObj($query['y'], $query['w'], $type);
                $object->url = 'week';
                $object->array = [
                    'week' => $weekObj
                ];

            }
            // check for m in array, if yes retun month view
            if(Arr::exists($query, 'm')){
              
                $obj = $this->getObjForMonth($query, $type);
                $object->url = $obj->url;
                $object->array = $obj->array;      
            }

            return $object;
        }
        abort(404);
    }
    public function getObjForMonth($query, $type){
        $app = app();
        $object = $app->make('stdClass');

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
        $object->url = 'month';
        $object->array = [
            'month' => $monthArray, 
            'monthName' => $monthName,
            'year' => $query['y']
        ];
        return $object;
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


    public function isAll($isGroup)
    {
        if($isGroup === $this->all){
            return true;
        }
        return false;
    }
    public function getType($isGroup)
    {
        if($isGroup === $this->grp){
            return $this->grp;
        }
        return $this->res;
    }

    public function change(Request $request){
        if ($request){
             $group = $request->get('group');
            if($this->isAll($group)){
                $route = 'showAll';
            } else {
                if($group === $this->grp){
                    $route = 'showGroups';
                } else {
                    $route = 'showRestaurant';
                }
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