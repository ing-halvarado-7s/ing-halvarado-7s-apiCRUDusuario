<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

use Illuminate\Http\Request;


class RoleController extends Controller
{
    //******************** ASIGNAR ROL AL USUARIO */
    public function asignarRol(Request $request, $id){
        $datosUsuario = User::find($id);
        
        if($datosUsuario){
            $status = true;
            $datosUsuario->assignRole($request->nombreRol);
            return response()->json(compact('datosUsuario','status'),201);
        }
        
        return ['status' => false]; 
    }


    //******************** ASIGNAR PERMISO A ROL */
    public function agregarPermisoRol(Request $request){
        $permiso = Permission::where('name','=',$request->nombrePermiso)->get();
        
        if($permiso){
            $status = true;
            $permiso[0]->assignRole($request->nombreRol);
            return response()->json(compact('permiso','status'),201);
        }
        
        return ['status' => false]; 
    }


    //******************** REVOCAR PERMISO A ROL */
    public function quitarPermisoRol(Request $request){
        $permiso = Permission::where('name','=',$request->nombrePermiso)->get();
        
        if($permiso){
            $status = true;
            $permiso[0]->removeRole($request->nombreRol);
            return response()->json(compact('permiso','status'),201);
        }
        
        return ['status' => false]; 
    }





}
