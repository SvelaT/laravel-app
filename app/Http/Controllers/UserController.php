<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = json_decode($request->input('sort'));
        $range = json_decode($request->input('range'));
        $filter = json_decode($request->input('filter'));
        $numUsers = $range[1]-$range[0]+1;
        $totalUsers = DB::table('users')->count();
        if(is_null($range)){
            if(strcmp($sort[1],"ASC") == 0){
                $users = User::orderBy($sort[0])->get();
            }
            else{
                $users = User::orderByDesc($sort[0])->get();
            }
        }
        else{
            if(strcmp($sort[1],"ASC") == 0){
                $users = User::orderBy($sort[0])->skip($range[0])->take($numUsers)->get();
            }
            else{
                $users = User::orderByDesc($sort[0])->skip($range[0])->take($numUsers)->get();
            }
        }
        $response = response()->json($users,200);
        $response->header('Content-Range',"posts 0-".$numUsers."/".$totalUsers);
        $response->header('Access-Control-Expose-Headers','Content-Range');
        return $response;
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $userdata = $request->all();
        $userdata['password'] = Hash::make($userdata['password']);
        $user = User::create($userdata);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
