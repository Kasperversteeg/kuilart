<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Reservation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agent = new Agent();

        // for development purposes
        $md = 'mobile';
        $dd = 'desktop';
        $agent->setUserAgent($dd);

        $device = $agent->getUserAgent();
        $now = Carbon::now()->isoFormat('dddd D MMMM');



        $reservations = Reservation::all();




        if($agent->getUserAgent() == 'mobile'){
            return view('mobile/home')->with('device', $agent->getUserAgent());
        } elseif ($agent->getUserAgent() == 'desktop'){
            // return view('home')->with('device', $agent->getUserAgent());
            return view('desktop/home')->with(compact('device', 'now', 'reservations'))->with('succes', ('test'));
        }

        // Uncomment when going live
        // if($agent->isMobile()) {
        //     return view('mobile/home');
        // } else {
        //     return view('home')->with('device', $agent->getUserAgent());
        // }
    }
}
