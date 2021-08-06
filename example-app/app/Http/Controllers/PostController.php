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
      // $post=Post::find("test"); //id = test
     //  $post->user;//function user to get table user
   
    // $user = $req->getUser();

        $fields = $req->validate([
          
           /* "tags"  => "required|string|min:2",*/
            "video"  => "required|file|max:20000",
            "tag1"     => "string",
            "tag2"     => "string",
            "tag3"     => "string"
          
           
        ]);
       /* $user = User::where('email', '=',  $fields['email'])->first();
        
        if ($user === null) {//si l'email n'existait pas
           return ["email doesnt exist"];
        }

        else{
            $post = Post::where('email', '=',  $fields['email'])->first();
        
                if ($post === null) {//premier video
                    $result=$req->file('video')->store('videosDocs');

                    $posts = Post::create([
                        //"email"  => $fields['email'],
                        "tags"  => 'first video',
                        "video" => $result,
                        //"categorie" => $fields['categorie'],
                        //"titre"  => $fields['titre']

                        
                    ]);

                    return ["result"=>$result];
                }

                else
                {*/
                       
            
                  /*  $tags = Tag::create([
                        "tag1"  => $req->tag1,
                        "tag2"  => $req->tag2,
                        "tag3"  => $req->tag3,
                        "user_id" =>Auth::user_tag()->id  
                    ]);*/

                    $result=$req->file('video')->store('videosDocs');
                    $null = 0;      
                    $posts = Post::create([
                        /*"tags"  => $fields['tags'],*/
                        "tag1"  => $req->tag1,
                        "tag2"  => $req->tag2,
                        "tag3"  => $req->tag3,
                        "video" => $result,
                        "validated_by_admin" => false,
                        "statut" => "Attente",
                        //note - vu
                        "nb_views" => $null,
                        "nb_note" => $null,
                        "note" => $null,
                        "user_categorie" => Auth::user()->user_categorie,
                        "user_id" =>Auth::user()->id  

                        
                    ]);
                    $posts = $posts->refresh();
                   // $tags = $tags->refresh();
                    return ["user_id"=>Auth::user()->id];
                    //return ["result"=>$result];
                //}
       // }
    }

    public function delete_my_Video(Request $request)
    {
       // DB::DB('users')->where('_id', '=', $request->video_id)->delete();
        $base=Post::where('_id', '=',  $request->video_id)->delete();

        //Get_my_Videos();
    }

    public function GetVideos_all(Request $request)
    { 
       
        //$base=Post::where('user_id', '!=', Auth::user()->id)->get();
       // $base= Post::where('categorie_id', '=', $request->categorie_id)->first();

          $base=Post::where('user_id', '!=', Auth::user()->id)
          ->where('user_categorie', '=', $request->user_categorie)
          ->where('validated_by_admin', '=', true)
          ->get();
        //$base=Mitalent::table('posts')->where('user_id', '!=', $request->user_id)->get();
       // $base = Post::where('categorie_id', '=', $request->categorie_id )->get();
       // $base=Post::where('categorie', '=', 'designer')->where('user_id', '!=', Auth::user()->id)->get();

    /*   $base = Post::where([
           // ['user_id', '!=', Auth::user()->id],

            ['categorie_id', '=', $request->categorie_id],
            ])->get(); 
*/
       
        return ["videos" => $base]; 
       //return Post::all();
    
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

        $base=Post::where('user_id', '=', Auth::user()->id)
        ->first();
        
       
        return ["total_views" => $views, "note" => $base->note ]; 
    
    }
    

    public function Get_plus_vues()
    {     
    
         /*$allUsers = Post::with('posts')->get();
        $topFive = $allUsers->sortByDesc(function($user){
            return $user->posts->count();
        })->take(2); */

       // return Post::all()->orderBy('nb_views', 'desc')->take(2)->get();

        $base = DB::table('posts')
                ->orderBy('nb_views', 'desc')
                ->having('nb_views', '!=', 0)
                ->take(2)
                ->get();

        return ["videos" => $base]; 

        /*$user = DB::table('users')
                ->latest()
                ->first();*/
    
    }


    public function  tri(Request $request)    
    {     
    if ( $request->choix == "Get_mieux_notes" ){
        $base = DB::table('posts')
                ->orderBy('note', 'desc')
                ->having('note', '!=', 0)
                ->take(1)
                ->get();
        }
        
    elseif ( $request->choix == "Get_plus_recents"){
        $base = DB::table('posts')
        ->latest()
        ->take(2)
        ->get();
    }
    
    elseif ( $request->choix == "Get_plus_vues"){
        $base = DB::table('posts')
        ->orderBy('nb_views', 'desc')
        ->having('nb_views', '!=', 0)
        ->take(3)
        ->get();
    }

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

        else {
            return ["erreur  over 5"];
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

        /*$profils = Profil::create([
            "image" => $result,
            "used_id" =>Auth::user()->id,
           
            
        ]);*/

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
