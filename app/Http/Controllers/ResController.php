<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;

class ResController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Generator $faker)
    {
        // create  
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
            'description' => 'required'
        ]);

        $reservation = new Reservation([
            'name' => $request->get('name'), 
            'description' => $request->get('description')
        ]);
        $reservation->save();
        return redirect('home');
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
        return view('desktop.edit', compact('reservation'));
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
            'description' => 'required'
        ]);

        $reservation = Reservation::find($id);
        $reservation->name = $request->get('name');
        $reservation->description = $request->get('description');
        $reservation->save();

        return redirect('/home')->with('succes', 'Contact updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
