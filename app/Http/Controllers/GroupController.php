<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Reservation;
use App\Activity;
use Carbon\Carbon;
use App\Classes\ReservationsObj;


class GroupController extends Controller
{
    private $grp, $res, $all;
    public function __construct()
    {
        $this->grp = config('constants.types.group');
        $this->res = config('constants.types.restaurant');
        $this->all = config('constants.types.all');
    }

	public function index()
    {

 		 // get array with requests
        $query = request()->query();

       // all
        if(Arr::exists($query, 's')){

	        $reservations = Reservation::where('type', $this->grp)->get();     
	        $sortedReservations = $this->sortReservationsByDate($reservations); 

	        if(isMobile()){
                return view('mobile.reservations.all', [
                    'reservations' => $sortedReservations,
                    'isGroup' => $this->grp
                ]);
            }
            return view('desktop.reservations.all', [
                'reservations' => $sortedReservations,
                'isGroup' => $this->grp
            ]); 
    
        } else {
            $reservations = new ReservationsObj();
            $resObj = $reservations->getReservationsForType($query, $this->grp);

            // $groupObj = $this->getReservationsForType($query, $this->grp);

            if (isset($reservations)) {
                if(isMobile()){
                    $resObj->array['isGroup'] =  $this->grp;
                    return view('mobile.reservations.'.$resObj->url, $resObj->array);
                }
                $resObj->array['isGroup'] =  $this->grp;
                return view('desktop.reservations.'.$resObj->url, $resObj->array);
            }
        }
        // if no query key exists, show 404
        abort(404);

    }    

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
    
	public function create()
    {   
        $date = Carbon::now()->isoFormat('Y-MM-DD');
        if(isMobile()){
            return view('mobile.reservations.createGroup', [
                'date' => $date
            ]);
        }
        return view('desktop.reservations.createGroup', [
            'date' => $date
        ]);
    }

	
    public function store(Request $request)
    {        

        //Validate group input
        $request = $this->validateGroup($request);
        // validate activities
        // $request = $this->validateActivity($request);

        $reservation = new Reservation([
            'type' => $this->grp,
            'name' => $request->get('name'),
            'size' => $request->get('size'),  
            'date'  => dateForDB($request->get('date')),
            'startTime'  => $request->get('startTime'),
            'notes' => $request->get('notes'),
            'phoneNr' => $request->get('phoneNr'),
            'mail'  => $request->get('mail')
        ]);

        $reservation->save();

        // $activity = new Activity([
        //     'startTime' => $request->get('act-startTime'), 
        //     'endTime' => $request->get('act-endTime'), 
        //     'description' => $request->get('act-description'), 
        //     'reservation_id' => $reservation->id, 
        //     'size' => $request->get('act-size')
        // ]); 
        // $activity->save();

    // return redirect()->route('groups.index', ['s' => 'all'])->with('success', 'Reservering toegevoegd');
    }

 public function edit($id)
    {
       
        $reservation = Reservation::find($id);
        return response()->json([
            'reservation' => $reservation,
            'activities' => $reservation->activities
        ]);
    }

  
    public function update(Request $request, $id)
    {
        $validateRequest = $this->validateGroup($request);
        $reservation = Reservation::find($id);

        $reservation->name = $request->get('name');
        $reservation->size = $request->get('size');
        $reservation->date = dateForDB($request->get('date'));
        $reservation->startTime = $request->get('startTime');
        $reservation->notes = $request->get('notes');
        $reservation->save();

        return redirect()->route('groups.index', ['s' => 'all'])->with('success', 'Reservering gewijzigd');
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
            'startTime' => 'required',
            'mail' => 'nullable|email',
            'phoneNr' => 'nullable|regex:/(01)[0-9]{9}/'
        ]);

        return $request;
    }

}
