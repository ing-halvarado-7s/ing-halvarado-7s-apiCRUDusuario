<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


//****************** INICIAR SESIÓN  *******************************    

public function iniciarsesion(Request $request)
{
$credentials = $request->only('email', 'password');
try {
    if (! $token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'Correo o clave no válidos'], 400);
    }
} catch (JWTException $e) {
    return response()->json(['error' => 'could_not_create_token'], 500);
}
return response()->json(compact('token'));
}//fin de iciarSesion


//******************* VALIDAR TOKEN ***************************** */
// A cada función que necesitemos que solo sea usado por usuarios validados se
// debe agregar esta función antes de escribir el código propio de la function

public function validarToken(){
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
        }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json(['token_absent'], $e->getStatusCode());
        }

}//fin de validarToker


//******************* CERRAR SESIÓN ***************************** */

public  function  cerrarSesion(Request  $request) {
        
    $this->validarToken();

    try {
        JWTAuth::invalidate($request->token);
        return  response()->json([
            'status' => 'ok',
            'message' => 'Cierre de sesión exitoso.'
        ]);
    } catch (JWTException  $exception) {
        return  response()->json([
            'status' => 'unknown_error',
            'message' => 'Al usuario no se le pudo cerrar la sesión.'
        ], 500);
    }
}//fin de cerrar sesión


// ************************** CREAR USUARIO **************************
public function crear(Request $request)
{

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'edad' => 'required|integer|max:100',
            'fecha_nacimiento' =>'required' ,
            'sexo' => 'required|string|max:1|in:F,M',
            'dni' => 'required|string|max:10|unique:users',
            'direccion' => 'required|string|max:250',
            'pais' => 'required|string|max:100',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $datosUsuario = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'edad' => $request->get('edad'),
            'fecha_nacimiento' => $request->get('fecha_nacimiento'),
            'sexo' => $request->get('sexo'),
            'dni' => $request->get('dni'),
            'direccion' => $request->get('direccion'),
            'pais' => $request->get('pais'),
            'telefono' => $request->get('telefono')
        ]);

        $token = JWTAuth::fromUser($datosUsuario);

        

        if($datosUsuario){
            $status = true;
            return response()->json(compact('datosUsuario','token','status'),201);
        }
    
        return ['status' => false];
  
}//fin de crear




//***************** MOSTRAR LISTADO DE USUARIOS *************/
public function listar()
{

        $this->validarToken();
        
        $datosUsuarios = User::all();

        if($datosUsuarios){
            $status = true;
            return response()->json(compact('datosUsuarios','token',''),201);
        }
        return ['status' => false];
}//fin de listar



//*************************ACTUALIZAR USUARIO *************** */

public function actualizar(Request $request, $id)
{

    $this->validarToken();

    $validator = Validator::make($request->all(), [
        'name' => 'string|max:255',
        'email' => 'string|email|max:255|unique:users',
        'password' => 'string|min:6|confirmed',
        'edad' => 'integer|max:100',
        'sexo' => 'string|max:1|in:F,M',
        'dni' => 'string|max:10|unique:users',
        'direccion' => 'string|max:250',
        'pais' => 'string|max:100',
    ]);

    if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
    }


    $datosUsuario = User::find($id);

    if($request->name){
        $datosUsuario->name = $request->name ;
    }

    if($request->password){
        $datosUsuario->password = $request->password ;
    }

    if($request->email){
        $datosUsuario->email = $request->email ;
    }
    
    if($request->edad){
        $datosUsuario->edad = $request->edad ;
    }

    if($request->fecha_nacimiento){
        $datosUsuario->fecha_nacimiento = $request->fecha_nacimiento ;
    }
    
    if($request->sexo){
        $datosUsuario->sexo = $request->sexo ;
    }

    if($request->dni){
        $datosUsuario->dni = $request->dni ;
    }

    if($request->direccion){
        $datosUsuario->direccion = $request->direccion ;
    }

    if($request->pais){
        $datosUsuario->pais = $request->pais ;
    }
    
    if($request->telefono){
        $datosUsuario->telefono = $request->telefono ;
    }

    $datosUsuario->save();

    
    $token = JWTAuth::fromUser($datosUsuario);

     

    if($datosUsuario){
        $status = true;
        return response()->json(compact('datosUsuario','token','status'),201);
    }
    
    return ['status' => false];

}//fin de actualizar



//************************* MOSTRAR DETALLE DE USUARIO *************** */

public function mostrarDetalle($id){
    
    $this->validarToken();
            
    $datosUsuario = User::find($id);

    if($datosUsuario){
        $status = true;
        return response()->json(compact('datosUsuario','status'),201);
    }
    
    return ['status' => false];
}// fin de mostrarDetalle


//************************* BORRAR USUARIO *************** */

public function eliminar($id){
    
    $this->validarToken();

    $datosUsuario = User::find($id);
    if($datosUsuario){
        $datosUsuario->delete();
        return ['status' => true];
    }
    
    return ['status' => false];
}//fin de eliminar


}