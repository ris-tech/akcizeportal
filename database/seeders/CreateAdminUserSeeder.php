<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Nikola Ristic', 
            'email' => 'info@ris-tech.de',
            'password' => bcrypt('80l!m3Akcize0308')
        ]);
        
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Controller']);
        Role::create(['name' => 'Employee']);
         
        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}
