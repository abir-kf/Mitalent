<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function rejectPost(Request $request )
    {
       
        if( Auth::user()->role === "admin")
        {
            $post = Post::where('_id', '=', $request->_id)->delete();
            $post->post_statut = $request->statut;
            $response = array(
            'status' => 'success',
            'msg' => $request->message,
        );
        }
        return response()->json($response); 
        
    }


    public function approvePost(Request $request )
    {
        
        if( Auth::user()->role == "admin")
        {
        $post = Post::find($request->_id);
        $post->validated_by_admin = true;
        $post->post_statut = $request->statut;
        $post->save();
        $response = array(
            'status' => 'success',
            'msg' => $request->message,
        );
        }
       
        return response()->json($response); 
    }


    
    public function getUsers()
    {
        
        if( Auth::user()->role === "admin")
        { 
            $users=User::where('user_id', '!=', Auth::user()->id)->get();
        }
        return ["users" => $users]; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
