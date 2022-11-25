<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{


    public function favoriteByUserId($id)
    {
        $favorite = Favorite::where('id_usuario', $id)->get();

        return response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => $favorite
        ]);
    }
    
    public function favoriteAdd(Request $request){
        $request->validate([
            'id_usuario' => 'required',
            'ref_api' => 'required'
        ]);


        $favorite = Favorite::where('id_usuario', $request['id_usuario'])->where('ref_api', $request['ref_api'])->first();
    
        if (isset($favorite->id_usuario)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Favorite already added',
                ],
                400 
            );

            } else {
                $favorite = new Favorite();
                $favorite->id_usuario = $request->id_usuario;
                $favorite->ref_api = $request->ref_api;
                $favorite->save();
    
                    return response()->json([
                        'status' => 'ok',
                        'message' => 'Favorite Added',
                        'data' => $favorite
                    ]);
            };
        }

}