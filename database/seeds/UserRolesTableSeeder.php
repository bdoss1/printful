<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles = ['super-admin', 'standard-user', 'vendor-company', 'building-company'];
    	foreach ($roles as $role) {		
	        Role::create(['name' => $role]);
    	}
    }
}
