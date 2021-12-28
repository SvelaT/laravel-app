<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MLController extends Controller
{
    public function run(Request $request)
    {
        $data = $request->all();
        $result = shell_exec("python C:\Users\artur\Documents\ProjetoSeeHealth\laravel\laravel-app\\resources\python\model.py ".$data['neurons']." ".$data['val_checks']." ".$data['num_epochs']);
        return response()->json(['result' => $result], 200);
    }
}
