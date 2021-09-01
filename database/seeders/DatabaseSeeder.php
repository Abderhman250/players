<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data =array(
            "admin",
            "user",
            "player",
            "team",
            "company"
        );
        $Role =array();

        foreach($data as $value){
         $Role[$value] = Role ::create(["name" => $value]); 
        }


        $User= User::create([
            "name"=>"admin",
            "email"=>"admin@gmail.com",
            "password"=>Hash::make('123456'),
            "phone"=>"admin",
            "isActive"=>0,
            "role_id"=>$Role[$value]->id,
        ]);
        // \App\Models\User::factory(10)->create();
        // $this->call(Role::class);
    }
}
