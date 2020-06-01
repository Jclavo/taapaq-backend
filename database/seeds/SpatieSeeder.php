<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SpatieSeeder extends Seeder
{

    protected $permissions = [
        'user/create',
        'user/update',
        'user/read',
        'user/delete',
        'user/pagination',
        'product/create',
        'product/update',
        'product/read',
        'product/delete',
        'product/pagination',
    ];

    protected $roles = [
        'admin',
        'user',
        'client',
    ];

    public function run()
    {
        // $this->permissions();
        // $this->roles();        
    }

    public function permissions(){
        
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

    public function roles(){
        
        foreach ($this->roles as $role) {
            $newRole = Role::create(['name' => $role]);

            switch ($role) {
                case 'admin':
                    foreach ($this->permissions as $permission) {
                        $newRole->givePermissionTo($permission);
                    }
                    break;
                case 'user':
                    foreach ($this->permissions as $permission) {
                        if (strncmp($permission, "user", 4) === 0){
                            $newRole->givePermissionTo($permission);
                        }  
                    }
                    break;
                case 'client':
                    foreach ($this->permissions as $permission) {
                        if (strncmp($permission, "product", 7) === 0){
                            $newRole->givePermissionTo($permission);
                        }  
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }

    public function role_has_permissions(){
        //Role Admin

    }


}
