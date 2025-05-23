<?php

use App\Http\controllers\empleadoControlador;
use App\Http\controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController; // Nuevo controlador
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LoginController;


Route::get('/empleado', [empleadocontrolador::class, 'index']);
Route::post('/empleado', [empleadoControlador::class, 'store']);
Route::get('/empleado/{idEmpleado}', [empleadocontrolador::class, 'show']);
Route::post('/empleado', [empleadocontrolador::class, 'store']);
Route::put('/empleado/{idEmpleado}', [empleadocontrolador::class, 'update']);
Route::delete('/empleado/{idEmpleado}', [empleadocontrolador::class, 'destroy']);
Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/pedidos', [PedidoController::class, 'index']);
Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
Route::post('/pedidos', [PedidoController::class, 'store']);
Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/login', function(Request $request) {
    $correo = $request->input('correoEmpleado');
    $password = $request->input('passwordEmpleado');

    $usuario = DB::table('empleadocliente')->where('correoEmpleado', $correo)->first();

    if (!$usuario) {
        return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 401);
    }

    if (Hash::check($password, $usuario->passwordEmpleado)) {
        // Contraseña correcta
        return response()->json(['success' => true, 'token' => bin2hex(random_bytes(16))]);
    } else {
        // Contraseña incorrecta
        return response()->json(['success' => false, 'message' => 'Contraseña incorrecta'], 401);
    }
});