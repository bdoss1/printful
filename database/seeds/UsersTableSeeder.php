<?php

use Illuminate\Database\Seeder;
use App\Helpers\Multitenant;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            
        $className = Multitenant::getModel('User');
        
        $user = new $className();
        $user->name = 'Administrator';
        $user->email = 'admin@brayn.io';
        $user->password = bcrypt('ten2dvag');
        $user->save();

        $user->assignRole('super-admin');
    }
}
