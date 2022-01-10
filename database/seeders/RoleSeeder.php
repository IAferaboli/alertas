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
        $role1 = Role::create(['name'=>'Administrador']);
        $role2 = Role::create(['name'=>'Supervisor de Monitoreo']);
        $role3 = Role::create(['name'=>'Operador de Monitoreo']);
        $role4 = Role::create(['name'=>'Ejecutivo']);

        Permission::create(['name'=>'panel.home'
        ,'description' => 'Ver el dashboard'])->syncRoles([$role1, $role2, $role3, $role4]);

        //     --- MONITOREO / INTERVENCIONES --- 
        Permission::create(['name'=>'panel.monitoreo.interventions.index'
        ,'description' => 'Monitoreo - Ver intervenciones'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name'=>'panel.monitoreo.interventions.create'
        ,'description' => 'Monitoreo - Crear Intervenciones'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name'=>'panel.monitoreo.interventions.edit'
        ,'description' => 'Monitoreo - Editar Intervenciones'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name'=>'panel.monitoreo.interventions.destroy'
        ,'description' => 'Monitoreo - Eliminar Intervenciones'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'panel.monitoreo.interventions.viewrecord'
        ,'description' => 'Monitoreo - Ver grabaciones'])->syncRoles([$role1, $role2, $role3]);

        //     --- MONITOREO / FALLAS --- 
        Permission::create(['name'=>'panel.monitoreo.flaws.index'
        ,'description' => 'Monitoreo - Ver Fallas'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name'=>'panel.monitoreo.flaws.create'
        ,'description' => 'Monitoreo - Crear Fallas'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name'=>'panel.monitoreo.flaws.edit'
        ,'description' => 'Monitoreo - Editar Fallas'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name'=>'panel.monitoreo.flaws.destroy'
        ,'description' => 'Monitoreo - Eliminar Fallas'])->syncRoles([$role1, $role2]);

        //     --- MONITOREO / EXPEDIENTES --- 
        Permission::create(['name'=>'panel.monitoreo.files.index'
        ,'description' => 'Monitoreo - Ver Expedientes'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'panel.monitoreo.files.create'
        ,'description' => 'Monitoreo - Crear Expedientes'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'panel.monitoreo.files.edit'
        ,'description' => 'Monitoreo - Editar Expedientes'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'panel.monitoreo.files.destroy'
        ,'description' => 'Monitoreo - Eliminar Expedientes'])->syncRoles([$role1, $role2]);

        //     --- MONITOREO / LISTADO DE CÁMARAS --- 
        Permission::create(['name'=>'panel.monitoreo.cameras.index'
        ,'description' => 'Monitoreo - Ver listado cámaras'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name'=>'panel.monitoreo.cameras.viewcamera'
        ,'description' => 'Monitoreo - Ver cámara en vivo'])->syncRoles([$role1, $role2, $role3]);

        //     --- MONITOREO / MAPAS ---
        Permission::create(['name'=>'panel.monitoreo.maps.index'
        ,'description' => 'Monitoreo - Ver listado cámaras'])->syncRoles([$role1, $role2, $role3]);

        //     --- ADMINISTRACIÓN --- 
        Permission::create(['name'=>'panel.users.index'
        ,'description' => 'Asignar roles a usuarios'])->syncRoles([$role1]);
        Permission::create(['name'=>'panel.users.edit'
        ,'description' => 'Editar roles de usuarios'])->syncRoles([$role1]);
        Permission::create(['name'=>'panel.users.update'
        ,'description' => 'Actualizar roles de usuarios'])->syncRoles([$role1]);

        Permission::create(['name'=>'panel.roles.index'
        ,'description' => 'Ver roles'])->syncRoles([$role1]);
        Permission::create(['name'=>'panel.roles.create'
        ,'description' => 'Crear roles'])->syncRoles([$role1]);
        Permission::create(['name'=>'panel.roles.edit'
        ,'description' => 'Editar roles'])->syncRoles([$role1]);
        Permission::create(['name'=>'panel.roles.destroy'
        ,'description' => 'Eliminar roles'])->syncRoles([$role1]);

       
    }
}
