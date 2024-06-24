<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try {
            $usuarios = DB::select('CALL obtener_usuarios()');
            return response()->json($usuarios);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):JsonResponse
    {

        $id_usuario = Uuid::uuid4()->toString();

        DB::select('CALL insertar_usuario(?, ?, ?, ?, ?, ?)', [
            $id_usuario,
            $request->nombre,
            $request->apellidos,
            $request->tipo_usuario_id,
            $request->edad,
            $request->fecha_nacimiento
        ]);

        return response()->json(['message' => 'Usuario creado con éxito'], 201);
    }
    // ?: validar campos en un procedimiento almacenado
    // public function store(Request $request):JsonResponse
    // {
        // Validar los datos de la solicitud manualmente
    //      $validator = Validator::make($request->all(), [
    //         'nombre' => 'required|string|max:100',
    //         'apellidos' => 'required|string|max:100',
    //         'tipo_usuario_id' => 'required|integer',
    //         'edad' => 'required|integer',
    //         'fecha_nacimiento' => 'required|date',
    //     ]);
         // Comprobar si la validación falla
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
       // Generar UUID v4
    //     $id_usuario = Uuid::uuid4()->toString();
         // Llamar al procedimiento almacenado con el UUID generado y los datos validados
    //     DB::select('CALL insertar_usuario(?, ?, ?, ?, ?, ?)', [
    //         $id_usuario,
    //         $request->nombre,
    //         $request->apellidos,
    //         $request->tipo_usuario_id,
    //         $request->edad,
    //         $request->fecha_nacimiento
    //     ]);

    //     return response()->json(['message' => 'Usuario creado con éxito'], 201);
    // }
    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResponse
    {
        $usuario = DB::select('CALL obtener_usuario_por_id(?)', [$id]);
        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):JsonResponse
    {
        DB::select('CALL actualizar_usuario(?, ?, ?, ?, ?, ?)', [
            $id,
            $request->nombre,
            $request->apellidos,
            $request->tipo_usuario_id,
            $request->edad,
            $request->fecha_nacimiento
        ]);

        return response()->json(['message' => 'Usuario actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        DB::select('CALL eliminar_usuario(?)', [$id]);
        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }
}
