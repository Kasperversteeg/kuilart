<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(App\User::class)->create([
		    'name' => 'kasper',
		    'email' => 'kasperversteeg@gmail.com', 
		    'password' => bcrypt('kasper')
		]);
        
        factory(App\Reservation::class, 50)->create();

        factory(App\Activity::class, 100)->create();

        $date = Carbon::now();
        $today = $date->isoFormat('Y-MM-DD');

        factory(App\Bowling::class, 3)->create(['date' => $today, 'startTime' => '17:00', 'endTime' => '18:00']);
        factory(App\Bowling::class, 2)->create(['date' => $today, 'startTime' => '19:00', 'endTime' => '20:00']);
        factory(App\Bowling::class, 4)->create(['date' => $today, 'startTime' => '21:00', 'endTime' => '22:00']);

        $date->addDay();
        $tomorrow = $date->isoFormat('Y-MM-DD');

        factory(App\Bowling::class, 3)->create(['date' => $date, 'startTime' => '17:00', 'endTime' => '18:00']);
        factory(App\Bowling::class, 2)->create(['date' => $date, 'startTime' => '19:00', 'endTime' => '20:00']);
        factory(App\Bowling::class, 4)->create(['date' => $date, 'startTime' => '21:00', 'endTime' => '22:00']);



        // factory(App\Bowling::class, 3)->create([
        //     'startTime' => '17:00', 
        //     'endTime' => '18:00',
        //     'date' => '2020-06-03'
        // ]);
        // factory(App\Bowling::class, 3)->create([
        //     'startTime' => '19:00', 
        //     'endTime' => '20:00',
        //     'date' => '2020-06-03'
        // ]);

        // factory(App\Bowling::class, 4)->create([
        //     'startTime' => '18:00', 
        //     'endTime' => '19:00',
        //     'date' => '2020-06-03'
        // ]);
    }
}
