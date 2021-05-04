<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Crear Roles

        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'usuario']);

        // //Crear Permisos y Asignar permisos a los roles(synRoles)
        Permission::create(['name' => 'crear'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'listar'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'actualizar'])->syncRoles([$role1]);
        Permission::create(['name' => 'eliminar'])->syncRoles([$role1]);
        Permission::create(['name' => 'mostrarDetalle'])->syncRoles([$role1,$role2]);
        
    }
}
