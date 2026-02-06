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
            
            <!-- 3-DOT MENU - SIMPLER VERSION -->
            @if($post->user_id == auth()->id())
            <div class="relative" x-data="{ open: false }">
                <!-- Menu Button -->
                <button @click="open = !open" 
                        class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border z-50"
                     style="display: none;">
                    
                    <!-- Edit Option -->
                    <button onclick="editPost({{ $post->id }})"
                            class="w-full text-left px-4 py-3 text-gray-700 hover:bg-gray-100 flex items-center">
                        <i class="fas fa-edit mr-3 text-blue-500"></i>
                        <span>Modifier</span>
                    </button>
                    
                    <!-- Delete Option -->
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="w-full">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Supprimer ce post?')"
                                class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 flex items-center">
                            <i class="fas fa-trash mr-3"></i>
                            <span>Supprimer</span>
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Post Content -->
    <div class="px-6 py-4">
        <!-- Display mode -->
        <div id="post-content-{{ $post->id }}">
            <p class="text-gray-800 whitespace-pre-line">{{ $post->content }}</p>
        </div>
        
        <!-- Edit mode (hidden by default) -->
        <div id="edit-post-{{ $post->id }}" class="hidden">
            <form id="edit-form-{{ $post->id }}" method="POST" action="{{ route('posts.update', $post) }}">
                @csrf @method('PUT')
                <textarea name="content" 
                          rows="3" 
                          class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-blue-500 resize-none">{{ $post->content }}</textarea>
                <div class="flex justify-end space-x-2 mt-3">
                    <button type="button" 
                            onclick="cancelEdit({{ $post->id }})"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="bg-black hover:bg-gray-800 text-white font-medium py-2 px-4 rounded-lg">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
        
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
            </div>
        @endif
    </div>
</div>
@endforeach

<!-- Add Alpine.js for dropdown functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
// Simple JavaScript for edit functionality (no Alpine.js dependency)
function editPost(postId) {
    console.log('Editing post:', postId);
    
    // Hide the display content
    document.getElementById(`post-content-${postId}`).classList.add('hidden');
    
    // Show the edit form
    document.getElementById(`edit-post-${postId}`).classList.remove('hidden');
}

// Cancel edit function
function cancelEdit(postId) {
    console.log('Canceling edit:', postId);
    
    // Show the display content
    document.getElementById(`post-content-${postId}`).classList.remove('hidden');
    
    // Hide the edit form
    document.getElementById(`edit-post-${postId}`).classList.add('hidden');
}

// Like post function
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
        document.getElementById(`likes-count-${postId}`).textContent = data.likes_count + ' likes';
        
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