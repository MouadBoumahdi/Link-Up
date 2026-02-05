<?php
// app/Models/Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'image',
        'likes_count',
        'comments_count'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relationship with Likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Check if user liked the post
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}