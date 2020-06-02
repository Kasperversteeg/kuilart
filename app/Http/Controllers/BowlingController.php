<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Bowling;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BowlingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = request()->query();
        // dd($query);
        if($query){
            if(Arr::exists($query, 'd')){
                // $reservations = Bowling::bowlingForDate($query['d']);  

                // $forTime = $reservations->whereBetween('startTime' , ['21:00', '22:00']); 

                $rows = [
                    $this->createRow($query['d'], '17:00', '18:00'),
                    $this->createRow($query['d'], '18:00', '19:00'),
                    $this->createRow($query['d'], '19:00', '20:00'),
                    $this->createRow($query['d'], '20:00', '21:00'),
                    $this->createRow($query['d'], '21:00', '22:00'),
                ];
                return view('desktop.bowling.index',[
                'rows' => $rows
                ]);
            }
        } else {
            $reservations = Bowling::all(); 
            return view('desktop.bowling.home', [
            'reservations' => $reservations
            ]);
        }  
    }

    public function createRow($date, $start, $end)
    {
        $app = app();
        $rowObj = $app->make('stdClass');
        $rowObj->startTime = $start;
        $rowObj->endTime = $end;

        $reservations = Bowling::where('date', $date)
                            ->where('startTime', '>=' , $start)
                            ->where('endTime', '<=', $end)
                            ->get();

        // get id's from reservations where starttime >=  startime  
       $lanes = new Collection;

        for ($i=1; $i <= 4; $i++) { 
            $res = $reservations->where('lane', $i)->first();
            if($res){
                $lanes->put($i,$res);
            } else {
                $lanes->put($i,false);
            }
        }

        $rowObj->lanes = $lanes;

        return $rowObj;
    }




    public function createRows()
    {
        return view('desktop.bowling.home');
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

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $date = Carbon::now()->isoFormat('DD-MM-Y');
        return view('desktop.bowling.create', [
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
        $request = $this->validateRequest($request);

        $bowling = new Bowling([
            'name' => $request->get('name'),
            'startTime' => $request->get('startTime'),
            'endTime' => $request->get('endTime'),
            'date' => $this->dateForDB($request->get('date')),
            'lane' => $request->get('lane')
            ]);

        $bowling->save();

        return redirect()->route('bowling.index')->with('succes', 'Bowlingbaan gereserveerd'); 
    }

    public function validateRequest($request)
    {
        $request->validate([
            'name' => 'required',
            'startTime' => 'required|date_format:H:i|after:16:59',
            'endTime' => 'required|date_format:H:i|after:startTime|',
            'date' => 'required|date',
            'lane' => 'required|integer'
        ]);

        return $request;
    }

    public function change(Request $request){
        $date = $request->get('date');
        $direction = $request->get('go');

        // make carbon date from date
        $carbon = Carbon::createFromFormat('Y-m-d', $date);
        if($direction === 'prev'){
            // substract a day from the date
            $carbon->subDay();
        }elseif($direction === 'next'){
            $carbon->addDay();
        }else{
            abort(404);
        }
        // convert to usable format
        $dateToString = $carbon->isoFormat('Y-MM-DD');
        // make variable url from variables
        $url = 'd='.$dateToString;

        if (isset($url)){
            return redirect()->route('bowling.index', $url);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Bowling  $bowling
     * @return \Illuminate\Http\Response
     */
    public function show(Bowling $bowling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bowling  $bowling
     * @return \Illuminate\Http\Response
     */
    public function edit(Bowling $bowling)
    {
        
        return view('desktop.bowling.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bowling  $bowling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bowling $bowling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bowling  $bowling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bowling $bowling)
    {
        //
    }


}
