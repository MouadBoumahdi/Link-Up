<?php
// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->content = $request->content;
        $comment->parent_id = $request->parent_id;
        $comment->save();

        // Update post comments count
        $post->increment('comments_count');

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    // Delete a comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Check if user owns the comment
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Decrement post comments count
        $comment->post->decrement('comments_count');
        
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}