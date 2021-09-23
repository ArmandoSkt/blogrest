<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TopicController extends Controller
{
    public function index(){
        return Topic::all();
    }

    public function get($id){
        $result = Topic::find($id);
        // $result = DB::table("id")->where("id", "=", $id)->get();
        if($result)
            return $result;
        else
            return response() -> json(["status"=>"failed"], 404);
    }

    public function create(Request $req){
        $this->validate($req, [ 
            "tema"=>"required"]);
        //filled no puede ir vacio
        //required- es obligatorio
        $datos = new Topic;
        // $datos->user = $req->user;
        // $datos->pass = Hash::make($req->pass);
        // $datos->user = $req->nombre;
        // $datos->user = $req->rol;
        // $datos->save();
        $result = $datos->fill($req->all())->save();
        if($result)
            return response() -> json(["status"=>"success"], 200);
        else
            return response() -> json(["status"=>"failed"], 404);
    }

    public function update(Request $req, $id){
        $this->validate($req, [
            'id'=>'filled', 
            'tema'=>'filled']);

        $datos = Topic::find($id);
        //$datos->pass = $req->pass;
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function destroy($id){
        
        $datos = Topic::find($id);
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->delete();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

}


