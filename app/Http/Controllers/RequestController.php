<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CurrentRequest;
use App\Http\Resources\CurrentRequests;
use Sentinel;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Bitvise SSH Client; Ip: 139.162.60.218
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Sentinel::authenticate($request->all());
        if($user) {
            $requests = CurrentRequest::where('user_id', $user->id)->where('status', 1)->get();  
            $requests->each(function ($item, $key) {
                $item->status = "3"; //time out
                $item->save();
            });

            $user_request = new CurrentRequest;
            $user_request->user_id = $user->id;
            $user_request->share_with = $user->share_with;
            $user_request->lat = $request->lat;
            $user_request->lng = $request->lng;
            $user_request->des_lat = $request->des_lat;
            $user_request->des_lng = $request->des_lng;
            $user_request->country_code = $request->country_code;
            $user_request->address = $request->address;
            $user_request->save();

            if($user->share_with == "B") {
                $current_requests = CurrentRequest::where('status', 1)
                                    ->where('user_id', '!=', $user->id)                                    
                                    ->where('share_with', 'B')
                                    ->orWhere('share_with', $user->gender)
                                    ->get();
            } else{
                $current_requests = CurrentRequest::where('status', 1)
                                    ->where('share_with', $user->share_with)
                                    ->where('user_id', '!=', $user->id)
                                    ->get();       
            }            
            return new CurrentRequests($current_requests);
        } else {
            return abort("401");
        }        
    }

    public function change_status(Request $request)
    {
        $user = Sentinel::authenticate($request->all());
        if($user)
        {
            $requests = CurrentRequest::where('user_id', $user->id)->where('status', 1)->get();  
            $requests->each(function ($item, $key) {
                $item->status = $request->status;
                $item->save();
            });
            return ["status"=>"success"];
        }
        else{
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
