<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $correo = $request->input('correoEmpleado');
        $password = $request->input('passwordEmpleado');

        $usuario = DB::table('empleadocliente')->where('correoEmpleado', $correo)->first();

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 401);
        }

        if (Hash::check($password, $usuario->passwordEmpleado)) {
            // Genera un token simple (puedes cambiar por JWT o Sanctum)
            $token = bin2hex(random_bytes(16));

            return response()->json(['success' => true, 'token' => $token]);
        } else {
            return response()->json(['success' => false, 'message' => 'Contraseña incorrecta'], 401);
        }
    }
}
