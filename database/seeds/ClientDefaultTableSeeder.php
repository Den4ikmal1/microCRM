<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientDefaultTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Client::query()->where('email', Client::DEFAULT_EMAIL)->first()) {
            Client::create([
                'email' => Client::DEFAULT_EMAIL,
                'first_name' => 'secret',
                'last_name' => 'secret',
                'password' => bcrypt('secret')
            ]);
        }
    }
}
