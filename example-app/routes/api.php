<?php

use App\Actions\JsonApiAuth\AuthKit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\api\v1\VideoController;
//use App\Http\Controllers\VideoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JsonApiAuth\RegisterController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Register
Route::post('/__client', [RegisterController::class, '__client']);
Route::post('/__admin', [RegisterController::class, '__admin']);

//Post
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'upload']);
Route::post('/profil', [PostController::class, 'upload_image']);
Route::post('/tri', [PostController::class, 'tri']);
Route::get('/plus_vues', [PostController::class, 'Get_plus_vues']);
Route::get('/mieux_notes', [PostController::class, 'Get_mieux_notes']);
Route::get('/plus_recents', [PostController::class, 'Get_plus_recents']);
Route::get('/Get_my_infos', [PostController::class, 'Get_my_infos']);
Route::post('/delete_my_Video', [PostController::class, 'delete_my_Video']);
Route::post('/get_offre', [PostController::class, 'Get_offre']);
Route::post('/increment-view', [PostController::class, 'incrementView']);
Route::post('/note', [PostController::class, 'notation']);
Route::post('/GetVideos_all', [PostController::class, 'GetVideos_all']);
Route::get('/Get_my_Videos', [PostController::class, 'Get_my_Videos']);

//Categorie
Route::get('/categories', [CategorieController::class, 'index']);
Route::post('/add_categorie', [CategorieController::class, 'add_categorie']);


//Admin
Route::get('/getUsers', [AdminController::class, 'getUsers']);
Route::post('/rejectPost', [AdminController::class, 'rejectPost']);
Route::post('/approvePost', [AdminController::class, 'approvePost']);

//Route::get('video', 'App\Http\Controllers\Api\VideoController@index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/json-api-auth.php';

// An example of how to use the verified email feature with api endpoints

Route::get('/verified-middleware-example', function () {
    return response()->json([
        'message' => 'the email account is already confirmed now you are able to see this message...',
    ]);
})->middleware(AuthKit::getMiddleware(), 'verified');


//upload
//Route::post("upload", [VideoController::class,'upload']);
//Route::get('post', ' VideoController@index');

/*Route::prefix('/video')->group(function(){
    Route::post('/video', 'api\v1\VidoesController@index');
});*/
