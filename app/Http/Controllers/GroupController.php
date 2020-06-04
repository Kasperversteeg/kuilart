<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Reservation;
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

	        $reservations = Reservation::where('type', $type)->get();     
	        $sortedReservations = $this->sortReservationsByDate($reservations); 

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
    
	public function createGroup()
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

	
    public function storeGroup(Request $request)
    {
        //Validate input
        $request = $this->validateGroup($request);
        $request = $this->validateActivity($request);
        $reservation = new Reservation([
            'type' => $this->grp,
            'name' => $request->get('name'),
            'size' => $request->get('size'),  
            'date'  => dateForDB($request->get('date')),
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


    public function updateGroup(Request $request, $id)
    {
        $validateRequest = $this->validateGroup($request);
        $reservation = Reservation::find($id);


        $reservation->type = $request->get('type');
        $reservation->name = $request->get('name');
        $reservation->size = $request->get('size');
        $reservation->date = dateForDB($request->get('date'));
        $reservation->startTime = $request->get('startTime');
        $reservation->notes = $request->get('notes');
        $reservation->save();

        return redirect()->route($route, ['s' => 'all'])->with('success', 'Reservering gewijzigd');
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

}
