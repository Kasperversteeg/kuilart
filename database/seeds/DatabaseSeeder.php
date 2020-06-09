<?php

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

        factory(App\Bowling::class, 3)->create(['startTime' => '17:00', 'endTime' => '18:00']);
        factory(App\Bowling::class, 2)->create(['startTime' => '19:00', 'endTime' => '20:00']);
        factory(App\Bowling::class, 4)->create(['startTime' => '21:00', 'endTime' => '22:00']);



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
