<?php
// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Store new post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Post created successfully!');
    }

    // Like/Unlike post
    public function like(Post $post)
    {
        $user = Auth::user();
        
        if ($post->isLikedBy($user)) {
            // Unlike
            Like::where('user_id', $user->id)
                ->where('post_id', $post->id)
                ->delete();
            
            $post->decrement('likes_count');
            $liked = false;
        } else {
            // Like
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            
            $post->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'likes_count' => $post->fresh()->likes_count,
            'liked' => $liked
        ]);
    }

    // Add comment
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

        $post->increment('comments_count');

        return back()->with('success', 'Comment added!');
    }

    // Delete post
    public function destroy(Post $post)
    {
        // Check if user owns the post
        if ($post->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }


    // Add this method to your PostController
    public function update(Request $request, Post $post)
    {
        // Check if user owns the post
        if ($post->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Post updated successfully!');
    }
}