<!-- Single Post Component -->
@foreach($posts as $post)
<div class="bg-white rounded-xl shadow-md border overflow-hidden mb-6" id="post-{{ $post->id }}">
    <!-- Post Header -->
    <div class="px-6 py-4 border-b">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <div>
                    <h4 class="font-bold">{{ $post->user->name }}</h4>
                    <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>
            
            @if($post->user_id == auth()->id())
            <!-- Delete Button for post owner -->
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-gray-400 hover:text-red-600" onclick="return confirm('Delete this post?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            @endif
        </div>
    </div>
    
    <!-- Post Content -->
    <div class="px-6 py-4">
        <p class="text-gray-800 whitespace-pre-line">{{ $post->content }}</p>
        
        <!-- Post Image -->
        @if($post->image)
            <div class="mt-4 rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $post->image) }}" 
                     alt="Post image" 
                     class="w-full max-h-96 object-cover rounded-lg">
            </div>
        @endif
    </div>
    
    <!-- Post Stats -->
    <div class="px-6 py-3 border-t border-b text-gray-500 text-sm flex items-center">
        <span id="likes-count-{{ $post->id }}">{{ $post->likes_count }} likes</span>
        <span class="mx-2">•</span>
        <span>{{ $post->comments_count }} comments</span>
    </div>
    
    <!-- Post Actions -->
    <div class="px-6 py-3 border-b">
        <div class="flex items-center">
            <!-- Like Button -->
            <button onclick="likePost({{ $post->id }})" 
                    class="flex items-center justify-center flex-1 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                <i id="like-icon-{{ $post->id }}" class="fas fa-thumbs-up mr-2 {{ $post->isLikedBy(auth()->user()) ? 'text-blue-600' : '' }}"></i>
                <span id="like-text-{{ $post->id }}">{{ $post->isLikedBy(auth()->user()) ? 'Liked' : 'Like' }}</span>
            </button>
            
            <!-- Comment Button -->
            <button onclick="focusComment({{ $post->id }})" 
                    class="flex items-center justify-center flex-1 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                <i class="fas fa-comment mr-2"></i>
                <span>Comment</span>
            </button>
        </div>
    </div>
    
    <!-- Comments Section -->
    <div class="px-6 py-4 bg-gray-50">
        <!-- Add Comment -->
        <div class="flex items-center mb-4">
            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold text-sm mr-3">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <form method="POST" action="{{ route('posts.comment', $post) }}" class="flex">
                    @csrf
                    <input type="text" 
                           id="comment-input-{{ $post->id }}"
                           name="content" 
                           placeholder="Write a comment..." 
                           class="flex-1 px-4 py-2 bg-white border rounded-l-lg focus:outline-none focus:border-blue-500">
                    <button type="submit" class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-r-lg">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Comments List -->
        @if($post->comments->count() > 0)
            <div class="space-y-3">
                @foreach($post->comments()->latest()->take(3)->get() as $comment)
                    <div class="flex">
                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-white font-bold text-sm mr-3">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="bg-white rounded-xl p-3">
                                <div class="flex items-center mb-1">
                                    <span class="font-bold text-sm">{{ $comment->user->name }}</span>
                                    <span class="text-gray-500 text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-800 text-sm">{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($post->comments_count > 3)
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View all {{ $post->comments_count }} comments
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endforeach

<script>
function likePost(postId) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update likes count
        document.getElementById(`likes-count-${postId}`).textContent = data.likes_count + ' likes';
        
        // Update like button
        const likeIcon = document.getElementById(`like-icon-${postId}`);
        const likeText = document.getElementById(`like-text-${postId}`);
        
        if (data.liked) {
            likeIcon.classList.add('text-blue-600');
            likeText.textContent = 'Liked';
        } else {
            likeIcon.classList.remove('text-blue-600');
            likeText.textContent = 'Like';
        }
    })
    .catch(error => console.error('Error:', error));
}

function focusComment(postId) {
    document.getElementById(`comment-input-${postId}`).focus();
}
</script>