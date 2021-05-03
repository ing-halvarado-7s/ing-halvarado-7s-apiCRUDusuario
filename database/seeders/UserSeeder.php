<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //Crear el usuario por defecto
         $usu = new User();

         $usu->name = 'Heimys M. Alvarado';
         $usu->email = 'ing.halvarado.7s@gmail.com';
         $usu->email_verified_at = now();
         $usu->password = bcrypt('Venezuela2021');
         $usu->edad = '40';
         $usu->fecha_nacimiento = '1980-08-06';
         $usu->sexo = 'F';
         $usu->dni = '11447788';
         $usu->direccion = 'Chivacoa';
         $usu->pais = 'Venezuela';
         $usu->telefono = '+584125600786';
         $usu->remember_token = Str::random(10);
         
         $usu->save();
        //  $usu->assignRole('admin');
 
 
         //Llenar la tabla user con valores de Faker
         User::factory(10)->create();
    }
}
