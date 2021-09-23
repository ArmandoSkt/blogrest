<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $req){
        return User::all();
    }
    public function get($user){
        $result = User::find($user);
        // $result = DB::table("users")->where("user", "=", $user)->get();
        if($result)
            return $result;
        else
            return response() -> json(["status"=>"failed"], 404);

        return $result;
    }

    public function create(Request $req){
        $this->validate($req, [
            "user"=>"required", 
            "nombre"=>"required",
            "pass"=>"required",
            "rol"=>"required"]);
        //filled no puede ir vacio
        //required- es obligatorio
        $datos = new User;
        // $datos->user = $req->user;
        $datos->pass = Hash::make($req->pass);
        // $datos->user = $req->nombre;
        // $datos->user = $req->rol;
        // $datos->save();
        $result = $datos->fill($req->all())->save();
        if($result)
            return response() -> json(["status"=>"success"], 200);
        else
            return response() -> json(["status"=>"failed"], 404);
    }

    public function update(Request $req, $user){
        $this->validate($req, [
            'user'=>'filled', 
            'nombre'=>'filled',
            'pass'=>'filled',
            'rol'=>'filled']);

        $datos = User::find($user);
        //$datos->pass = $req->pass;
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function destroy($user){
        
        $datos = User::find($user);
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->delete();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

}


