<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LinkUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

{{-- @include('components.flash-messages') --}}

<script>
// JavaScript for dropdowns and post functions
document.addEventListener('DOMContentLoaded', function() {
    const friendRequestsBtn = document.getElementById('friendRequestsBtn');
    const friendRequestsMenu = document.getElementById('friendRequestsMenu');
    
    if (friendRequestsBtn) {
        friendRequestsBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            friendRequestsMenu.classList.toggle('hidden');
        });
        
        document.addEventListener('click', function(e) {
            if (!friendRequestsBtn.contains(e.target) && !friendRequestsMenu.contains(e.target)) {
                friendRequestsMenu.classList.add('hidden');
            }
        });
    }
});
</script>

<!-- MAIN CONTENT -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- SIDEBAR COMPONENT -->
        @include('components.sidebar')
        
        <!-- MAIN CONTENT AREA -->
        <main class="lg:w-3/4">
            
            <!-- HEADER COMPONENT -->
            @include('components.header')
            
            <!-- SEARCH RESULTS COMPONENT -->
            @include('components.search-results')
            
            <!-- CREATE POST COMPONENT -->
            @include('components.create-post')
            
            <!-- POSTS FEED -->
            <div id="posts-feed">
                @php
                    $posts = \App\Models\Post::with(['user', 'comments.user'])
                        ->latest()
                        ->paginate(10);
                @endphp
                
                @if($posts->count() > 0)
                    @include('components.post', ['posts' => $posts])
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @else
                    <!-- No Posts Yet -->
                    <div class="bg-white rounded-xl shadow-md border overflow-hidden text-center py-10">
                        <i class="fas fa-newspaper text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">No posts yet</h3>
                        <p class="text-gray-600">Be the first to share something!</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

</body>
</html>