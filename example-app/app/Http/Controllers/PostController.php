<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    public function __construct()
{
    $this->middleware('auth:api');
}

    public function upload(Request $req)
    {

        $fields = $req->validate([

            "video"  => "required|file|max:20000",
            "tag1"     => "string",
            "tag2"     => "string",
            "tag3"     => "string"
          
           
        ]);
      
                               

                    $result=$req->file('video')->store('videosDocs');
                    $null = 0;      
                    $posts = Post::create([
                        /*"tags"  => $fields['tags'],*/
                        "tag1"  => $req->tag1,
                        "tag2"  => $req->tag2,
                        "tag3"  => $req->tag3,
                        "video" => $result,
                        "validated_by_admin" => false,
                        //note - vu
                        "nb_views" => $null,
                        "nb_note" => $null,
                        "note" => $null,
                        "user_categorie" => Auth::user()->user_categorie,
                        "user_id" =>Auth::user()->id  

                        
                    ]);
                    $posts = $posts->refresh();
                    return ["user_id"=>Auth::user()->id];
        
    }

    public function delete_my_Video(Request $request)
    {
        $base=Post::where('_id', '=',  $request->video_id)->delete();

    }

    public function GetVideos_all(Request $request)
    { 

          $base=Post::where('user_id', '!=', Auth::user()->id)
          ->where('user_categorie', '=', $request->user_categorie)
          ->where('validated_by_admin', '=', true)
          ->get();
       
        return ["videos" => $base]; 

    
    }
      public function Get_my_Videos()
    { 
       
        $base=Post::where('user_id', '=', Auth::user()->id)
        ->where('validated_by_admin', '=', true)
        ->get();
       
        return ["videos" => $base]; 
    
    }

    public function Get_my_infos()
    { 
       
        $views = DB::table('posts')
        ->where('user_id', '=', Auth::user()->id)->get()
        ->sum('nb_views');
       
        return ["total_views" => $views]; 
    
    }
    

    public function Get_plus_vues()
    {     


        $base = DB::table('posts')
                ->orderBy('nb_views', 'desc')
                ->having('nb_views', '!=', 0)
                ->take(2)
                ->get();

        return ["videos" => $base]; 

    
    }


    public function Get_mieux_notes()
    {     
    
        $base = DB::table('posts')
                ->orderBy('note', 'desc')
                ->having('note', '!=', 0)
                ->take(2)
                ->get();

        return ["videos" => $base]; 
    }


    public function Get_plus_recents()
    {
        $base = DB::table('posts')
                ->latest()
                ->take(2)
                ->get();
        return ["videos" => $base]; 

    }

    public function Get_offre(Request $request)
    {
       
        $fields = $request->validate([
          
            "offre"  => "required|string",          
           
        ]);

        $base = User::where('_id', '=', Auth::user()->id )->first();
        $base->offre = $request->offre;
        $base->save();

        return ["offre"=>$base];

    }


    public function incrementView(Request $request)
    {      
        $base = Post::where('_id', '=', $request->_id )
        ->where('validated_by_admin', '=', true)
        ->first();
        $base->nb_views = $base->nb_views + 1;
        $base->save();
        return ["nb_views" => $base->nb_views]; 
    }

    public function notation(Request $request)
    {      
        $base = Post::where('user_id', '=', $request->user_id )
        ->where('validated_by_admin', '=', true)->first();
        
        $note = 0;
        $nb_note = 0;

        if ($base->note === null){
            $note = $request->note;
        }

        elseif ( $request->note <= 5 ) {
            $total = $base->note * $base->nb_note;
            $nb_note = $base->nb_note + 1;
            $note = ($total + $request->note)/$nb_note;

        }

        $updated = Post::where('user_id', '=', $request->user_id )
        ->where('validated_by_admin', '=', true)
              ->update(['note' => $note,
              'nb_note' => $nb_note]);
        
        return ["result" => $updated];
       // return ["note" => $note, "nb_note"=> $nb_note ]; 
    }

    public function upload_image(Request $req)
    {
        $fields = $req->validate([
         
            "image"  => "required|file|max:2000",
           
           
        ]);

        $result=$req->file('image')->store('profilsDocs');


        $base = User::where('_id', '=', Auth::user()->id )->first();
        $base->image = $result;
        $base->save();

        return ["result"=>$result];
    }


    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Post::where('updated_at', '<', Carbon::now()->subDays(1))->delete();
        })->weekly();
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
        $post = Post::create($request->all());
        return response($post, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Post::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post = Post::find($id);
        $post->update($request->only('title', 'description', 'user_id'));
        return response($post, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Post::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
