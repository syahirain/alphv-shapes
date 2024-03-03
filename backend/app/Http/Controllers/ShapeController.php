<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shapes;

class ShapeController extends Controller
{
    public function index(){
        $shapes = Shapes::all()->toArray();

        foreach($shapes as $key => $val){
            $name_arr = explode(" ", $val['name']);

            if(count($name_arr) > 1){
                $initial = $name_arr[0][0].$name_arr[1][0];
            }else{
                $initial = $val['name'][0].$val['name'][1];
            }

            $shapes[$key]['initial'] = strtoupper($initial);
        }
        return array_reverse($shapes);
    }

    public function store(Request $request){
        $shape = new Shapes([
            'name' => $request->input('name'),
            'shape' => $request->input('shape'),
            'color' => $request->input('color')
        ]);
        $shape->save();

        return response()->json(['message' => 'Shape created'], 200);
    }

    public function show($id){
        $shape = Shapes::find($id);
        return response()->json($shape);
    }

    public function update(Request $request, $id){
        $shape = Shapes::findOrFail($id);
        $shape->update($request->all());

        return response()->json(['message' => 'Shape updated'], 200);
    }

    public function destroy($id){
        Shapes::find($id)->delete();

        return response()->json(['message' => 'Shape deleted'], 204);
    }

    public function overview_data(){
        $shapes = Shapes::all()->toArray();
        $total_shapes = count($shapes);
        $users_arr = [];
        $shapes_arr = [];

        foreach($shapes as $key => $val){
            if (!in_array($val['name'], $users_arr)){ $users_arr[] = $val['name']; }

            if (array_key_exists($val['shape'], $shapes_arr)){ 
                $shapes_arr[$val['shape']] += 1; 
            }else{
                $shapes_arr[$val['shape']] = 1;
            }
        }

        $maxValue = max($shapes_arr);
        $maxKeys = array_keys($shapes_arr, $maxValue);

        return response()->json([
            'message' => 'Overview data send success',
            'total_users' => count($users_arr),
            'total_shapes' => $total_shapes,
            'max_num_shape' => $maxValue,
            'highest_shape' => $maxKeys[0]
        ], 200);
    }
}
