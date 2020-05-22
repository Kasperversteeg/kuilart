<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Reservation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class ResController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // day object
    public function createDayObj($date, $dayName){
        // create the object in laravel
        $app = app();
        $dayObj = $app->make('stdClass');
        
        // set date for day in a certain format
        $dayObj->date = $date;
       
        // get the dayname from the carbon object
        $dayObj->day = $dayName;
        
        // get the reservations for that day from the model
        $reservations = Reservation::where('date', $date)->get();
        $dayObj->reservations = $reservations;

        return $dayObj;
    }
    public function createWeekObj($weekNumber, $days){
        // create the object in laravel
        $app = app();
        $weekObj = $app->make('stdClass');
        
        $weekObj->weekNumber = $weekNumber;
        
        $weekObj->days = $days;

        return $weekObj;

    }


    // function for getting reservations for specific period, it recieves the period from the url
    public function showReservationsFor($period){
        
        // get current date
        $date = Carbon::now();
        $today = $date->isoFormat('Y-MM-DD');


        if($period === 'day'){
            $reservationsForDay = self::createDayObj($today, $date->dayName);
        
            return view('desktop.reservations.show.day', [
                'reservationsForDay' => $reservationsForDay
                ]);
        }

        if($period === 'week'){
            // week periode
            $reservations = [];                 

            $firstDay = $date->startOfWeek()->format('Y-m-d');
            $lastDay = $date->endOfWeek()->format('Y-m-d');
            $weekNumber = $date->weekOfYear;
            $dateRange = CarbonPeriod::create($firstDay, $lastDay);

            $datesOfWeek = [];
            foreach($dateRange as $date) {
                // make dayObj object
                $dayObj = self::createDayObj ($date->format('Y-m-d'), $date->dayName);
            
                // add them to the array
                $datesOFWeek[] = $dayObj;
            }

            return view('desktop.reservations.show.week',[
                'today' => $today, 
                'reservations' => $reservations,
                'week' => $weekNumber,
                'firstDay' => $firstDay, 
                'lastDay' => $lastDay,
                'dates' => $datesOFWeek
            ]);
        }

        if($period === 'month'){
            $monthName = $date->monthName; 
            $firstDay = $date->firstOfMonth()->format('Y-m-d');
            $lastDay = $date->lastOfMonth()->format('Y-m-d');
            $dateRange = CarbonPeriod::create($firstDay, $lastDay);


            $weeksOfMonth = Carbon::create($lastDay)->weekOfMonth;
            $weekNumber = 1;
            $monthArray = [];
            $weekArray = [];

            foreach ($dateRange as $date) {

                $w = $date->weekOfMonth;
                $dayObj = self::createDayObj ($date->format('Y-m-d'), $date->dayName);
                $weekArray[] = $dayObj;

                if ($date->dayName == 'zondag'){
                    $weekObj = self::createWeekObj ($weekNumber, $weekArray);
                    $monthArray = Arr::add($monthArray, $weekNumber, $weekObj);
                    // clear weakarray
                    $weekArray = [];

                    $weekNumber++; 
                }
            }
            // dd($monthArray);
            return view('desktop.reservations.show.month', [
                'month' => $monthArray, 
                'monthName' => $monthName
                ]);
        }

        if($period === 'all'){
            return self::index();
        }
    }


    public function index()
    {
        // get all reservations
        $reservations = Reservation::all();
        $sortedReservations = $reservations->sortby('date');
        // get current date and format it
        $now = Carbon::now()->isoFormat('dddd D MMMM');

        return view('desktop.home', [
            'reservations' => $sortedReservations, 
            'now' => $now
        ]);

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
        $request->validate([
            'name'=>'required',
            'date' => 'required',
            'description' => 'required'
        ]);

        $reservation = new Reservation([
            'name' => $request->get('name'), 
            'date'  => $request->get('date'),
            'description' => $request->get('description')
        ]);
        $reservation->save();
        return redirect('home')->with('success', 'Reservering toegevoegd');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        // update reservation
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'description' => 'required'
        ]);

        $reservation = Reservation::find($id);
        $reservation->name = $request->get('name');
        $reservation->description = $request->get('description');
        $reservation->save();

        return redirect('/home')->with('success', 'Reservering toegevoegd');
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

        return redirect('/home')->with('success', 'Reservering verwijderd');

    }
}
