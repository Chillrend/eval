<?php

namespace Database\Seeders;

// use App\Models\ProdiMand;
use App\Models\ProdiPres;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void_prodi
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::create([
        //     'name' => "Admin",
        //     'role' => "Admin",
        //     'email' => "admin@pnj.ac.id",
        //     'email_verified_at' => date('Y-m-d H:i:s', time()),
        //     'password' => Hash::make('magangUTD2022'),

        // ]);

        $this->call([
            ProdiTesSeeder::class,
            ProdiMandiriSeeder::class,
            ProdiPrestasiSeeder::class
        ]);
    }
}
