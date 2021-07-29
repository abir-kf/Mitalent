<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Post extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $fillable = [
       // "email",
        "tags",
        "video",
        //"categorie",
       // "titre",
       "note",
       "nb_note",
       "nb_views",
       "categorie_id",
        "user_id"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
