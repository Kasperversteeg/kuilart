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
    }
}
