<?php

use Illuminate\Database\Seeder;
use App\Reservation;

class ReservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Reservation::class, 30)->create();
    }
}
