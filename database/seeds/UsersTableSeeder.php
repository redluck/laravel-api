<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
    
    public function run() {
		//Creiamo 50 utenti mock
        factory(App\User::class, 50)->create();
    }
}
