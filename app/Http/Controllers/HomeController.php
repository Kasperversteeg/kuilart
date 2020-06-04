<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Carbon\Carbon;


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


    public function deviceCheck()
    {
        $agent = new Agent();

        // for development purposes
        $md = 'mobile';
        $dd = 'desktop';
        $agent->setUserAgent($md);

        $device = $agent->getUserAgent();

        if(isMobile()){
            return view('mobile/home');
        }
        return view('desktop/home', [
            'device' => $device, 
            'now' => Carbon::now()
        ]);

        // if($agent->getUserAgent() == 'mobile'){
        //     return view('mobile/home')->with('device', $agent->getUserAgent());
        // } 
        // return view('desktop/home', [
        //     'device' => $device, 
        //     'now' => Carbon::now()
        // ]);


    }
}
