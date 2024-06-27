<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'usuario' => 'required|string',
            'contrasenia' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $usuario = $request->input('usuario');
        $contrasenia = $request->input('contrasenia');

        try {
            // Lprocedimiento almacenado
            $result = DB::select('CALL SP_login(?, ?)', [$usuario, $contrasenia]);

            if ($result && count($result) > 0) {

                return response()->json([
                    'message' => 'Login exitoso',
                    'data' => $result,
                ]);
            } else {
                return response()->json([
                    'message' => 'Credenciales incorrectas',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al autenticar',
                'error' => $e->getMessage(),
            ], 500);
        }


    }


    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Sesión cerrada con éxito']);
    }
}
