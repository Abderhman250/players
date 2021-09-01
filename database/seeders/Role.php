<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  create static role  on project 
        $data =array(
            "admin",
            "user"
        );

        // foreach($data as $value){
         $Role = Role ::create(["name" => 'admin'] ); 
        // }

    }
}
