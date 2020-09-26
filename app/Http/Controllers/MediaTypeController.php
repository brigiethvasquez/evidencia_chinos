<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MediaType;

class MediaTypeController extends Controller
{
    public function showmass()
    {
        return view("media-types.insert-mass");
    }
    public function storemass(Request $r)
    {
        //arreglo de MediaTypes repetidos en db
        $repetidos = [];

        //Reglas de validacion
        $reglas = [
            'media-types' => 'required|mimes:csv,txt'
        ];

        //Crear Validador
        $validador = Validator::make($r->all(), $reglas);

        //validadr
        if ($validador->fails()) {
            //return $validador->errors()->first('media-types');
            //enviar mensaje de error de validacion a la vista
            return redirect('media-types/insert')->withErrors($validador);
        } else {

            $r->file("media-types")->storeAs('media-types', $r->file("media-types")->getClientOriginalName());

            $ruta = base_path() . '\storage\app\media-types\\' . $r->file('media-types')->getClientOriginalName();

            if (($puntero = fopen($ruta, 'r')) !== false) {
                $contadora = 0;
                while (($linea = fgetcsv($puntero)) !== false) {
                    $conteo = MediaType::where('Name', '=', $linea[0])->get()->count();
                    if ($conteo == 0) {
                        $m = new MediaType();
                        $m->Name = $linea[0];
                        $m->save();  
                        $contadora++;
                    } else { 
                        $repetidos[] = $linea[0];
                    }
                }
                if (count($repetidos) == 0) {
                    return redirect('media-types/insert')->with('exito', "Carga masiva de realizados,Registros ingresados: $contadora");
                } else {
                    return redirect('media-types/insert')->with('exito', "Carga masiva con excepciones:")->with("repetidos", $repetidos);
                }
            }
        }
    }
}
