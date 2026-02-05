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
// JavaScript for dropdowns
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
            
            <!-- CREATE POST SECTION -->
            <div class="bg-white rounded-xl shadow-md border overflow-hidden mb-6">
                <div class="p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <form method="POST">
                                @csrf
                                <textarea 
                                    name="content" 
                                    rows="3" 
                                    placeholder="What's on your mind?"
                                    class="w-full px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none focus:border-blue-500 resize-none"
                                ></textarea>
                                <div class="flex justify-end mt-3">
                                    <button type="submit" class="bg-black hover:bg-gray-800 text-white font-medium py-2 px-6 rounded-lg">
                                        Post
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- POSTS FEED -->
            <div class="space-y-6">
                <!-- Your posts will go here -->
                <div class="bg-white rounded-xl shadow-md border overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold mr-3">
                                    J
                                </div>
                                <div>
                                    <h4 class="font-bold">John Doe</h4>
                                    <p class="text-gray-500 text-sm">2 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4">
                        <p class="text-gray-800">
                            This is a sample post. Your posts will appear here.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>