<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Reservation;
use App\Http\Requests\ReservationRequest;
use Carbon\Carbon;
use App\Classes\ReservationsObj;


class ReservationController extends Controller
{
    private $grp, $res, $all;
    public function __construct()
    {
        $this->grp = config('constants.types.group');
        $this->res = config('constants.types.restaurant');
        $this->all = config('constants.types.all');
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
            if(isMobile()){
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

    // date class
    public function createDateObj($date, $reservations){
        // create the object in laravel
        $app = app();
        $dateObj = $app->make('stdClass');
        
        $dateObj->date = formatDate($date);
       
        $date = new Carbon($date);
        $dateObj->dayName = $date->dayName;

        $dateObj->reservations = $reservations; 
        $dateObj->groups = $reservations->where('type', $this->grp);
        $dateObj->res = $reservations->where('type', $this->res);

        return $dateObj;

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
            $reservations = new ReservationsObj();
            $resObj = $reservations->getReservationsForType($query, $this->all);

            if (isset($resObj)) {
                if(isMobile()){
                    $resObj->array['isGroup'] =  $this->all;  
                    return view('mobile.reservations.'.$resObj->url, $resObj->array);
                }
                $resObj->array['isGroup'] =  $this->all;
                return view('desktop.reservations.'.$resObj->url, $resObj->array);
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
            $reservations = new ReservationsObj();
            $resObj = $reservations->getReservationsForType($query, $this->res);

            if (isset($resObj)) {
                if(isMobile()){
                    $resObj->array['isGroup'] =  $this->res;
                    return view('mobile.reservations.'.$resObj->url, $resObj->array);
                }
                $resObj->array['isGroup'] =  $this->res;
                return view('desktop.reservations.'.$resObj->url, $resObj->array);
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
        if(isMobile()){           
            return view('mobile.reservations.create', [
                'date' => $date
            ]);
        }
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
            $request = $this->validateRes($request);

            $reservation = new Reservation([
                'type' => $this->res,
                'name' => $request->get('name'),
                'size' => $request->get('size'),  
                'date'  => dateForDB($request->get('date')),
                'startTime'  => $request->get('startTime'),
                'notes' => $request->get('notes')
            ]);

            $reservation->save();
    }

    // public function edit($id)
    // {
    //     $r= 'desktop';
    //     if(isMobile()){
    //         $r= 'mobile';
    //     }

    //     // redirect to update view
    //     $reservation = Reservation::find($id);
    //     return view($r.'.reservations.edit', compact('reservation'));
    // }

    public function edit($id)
    {
        // redirect to update view
        $reservation = Reservation::find($id);

       return response()->json([
            'reservation' => $reservation
       ]);
        
    }

    public function update(Request $request, $id)
    {
        $validateRequest = self::validateRes($request);
        $reservation = Reservation::find($id);

        $reservation->type = $request->get('type');
        $reservation->name = $request->get('name');
        $reservation->size = $request->get('size');
        $reservation->date = dateForDB($request->get('date'));
        $reservation->startTime = $request->get('startTime');
        $reservation->notes = $request->get('notes');
        $reservation->save();

        return redirect()->route('restaurants.index', ['s' => 'all'])->with('success', 'Reservering gewijzigd');
    }

    public function updateTableNr(Request $request, $id){

        $reservation = Reservation::find($id);
        $validated = $request->validate([ 'tableNr' => ['required', 'int']]);
        $reservation->updateTableNr($validated['tableNr']);

        return back();
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
            $route = 'groups.index';
        } else {
            $succesMsg = 'Reservering verwijderd';
            $route = 'restaurants.index';
        }

        return redirect()->route($route, ['s' => 'all'])->with('success', $succesMsg);

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



    // helpers
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

    
    // public helper function
    public function change(Request $request){
        if ($request){
             $group = $request->get('group');
            if($this->isAll($group)){
                $route = 'all.index';
            } else {
                if($group === $this->grp){
                    $route = 'groups.index';
                } else {
                    $route = 'restaurants.index';
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