<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sedeController extends Controller
{
    public function index()
    {
        try {
            $sedes = Sede::select(
                'sede.ID_S',
                'sede.Dic_S',
                'sede.Sec_V',
                'sede.est_sed',
                DB::raw("CASE WHEN sede.est_sed = 1 THEN 'Activo' WHEN sede.est_sed = 0 THEN 'Inactivo' ELSE 'Otro' END AS est_sed"),
                'empresa.Nom_E as id_empresa'
            )
                ->join('empresa', 'sede.id_e', '=', 'empresa.id_e')
                ->get();

            if ($sedes->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron Sedes',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Sedes encontradas correctamente',
                    'data' => $sedes,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar las Sedes: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function show(Sede $sede)
    {
        try {
            $resultado = Sede::select(
                'sede.ID_S',
                'sede.Dic_S',
                'sede.Sec_V',
                'sede.est_sed',
                DB::raw("CASE WHEN sede.est_sed = 1 THEN 'Activo' WHEN sede.est_sed = 0 THEN 'Inactivo' ELSE 'Otro' END AS est_sed"),
                'empresa.Nom_E as id_empresa'
            )
                ->join('empresa', 'sede.id_e', '=', 'empresa.id_e')
                ->where('sede.ID_S', $sede->ID_S)
                ->first();

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Sede encontrada correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Sede no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar la Sede: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
