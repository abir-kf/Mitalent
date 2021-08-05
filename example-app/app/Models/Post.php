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
        //"tags",
        "tag1",
        "tag2",
        "tag3",
        "video",
        //"categorie",
       // "titre",
       "note",
       "nb_note",
       "nb_views",
       "user_categorie",
       "validated_by_admin",
        "user_id"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->has_many(Tag::class);
    }
}
