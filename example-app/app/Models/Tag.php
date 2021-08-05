<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Tag extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $connection = 'mongodb';

    protected $fillable = [
         "tag1",
         "tag2",
         "tag3",
         "user_id"

     ];
     public function user_tag()
     {
         return $this->belongsTo(User::class);
     }

     public function post()
     {
         return $this->belongsTo(Post::class);
     }
}
