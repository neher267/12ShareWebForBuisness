<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Sentinel;
use Carbon\Carbon;
use App\Gift;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Resources\UserResource;
use App\Http\Resources\GiftResource;

class PassportController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
		$user = Sentinel::registerAndActivate($request->all());        
        $role = Sentinel::findRoleBySlug('user');
        if($role){ 
            $role->users()->attach($user);
        }

        return response()->json(['name'=>$user->name]);
    }

    public function login(Request $request){
        $user = Sentinel::authenticate($request->all());
        if($user)
            return new UserResource($user);
        else
            return abort("401");
    }

    public function getDetails()
    {
    	$user = Auth::user();
        return new UserResource($user);
    }

    public function updateUserInfo(Request $request)
    {
        $user = Auth::user();
        $user->marks = (int) $request->game_score;
        $user->save();

        return "200";
    }

    public function gifts()
    {
        $gifts = Gift::latest()->get();
        return new GiftResource($gifts);
    }
}
