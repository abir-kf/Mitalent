<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class categorie extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $connection = 'mongodb';
    protected $collection = 'categories';


    protected $fillable = [
       "categorie",
     ];


     public function user_categorie()
     {
         return $this->belongsTo(User::class);
     }
}
