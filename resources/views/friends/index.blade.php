<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends - LinkUp</title>
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
            
            <!-- HEADER COMPONENT WITH TITLE -->
            @component('components.header')
                @slot('title', 'Friends')
                @slot('subtitle', 'Manage your friends and friend requests')
            @endcomponent
            
            <!-- SEARCH RESULTS COMPONENT -->
            @include('components.search-results')
            
            <!-- FRIEND REQUESTS SECTION (REPLACES POSTS) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pending Requests -->
                <div class="bg-white rounded-xl shadow-md border overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-lg font-bold text-gray-800">
                            Pending Requests
                            @if($pendingRequests->count() > 0)
                                <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $pendingRequests->count() }}
                                </span>
                            @endif
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        @if($pendingRequests->count() > 0)
                            <div class="space-y-4">
                                @foreach($pendingRequests as $request)
                                    <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                                                {{ strtoupper(substr($request->sender->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold">{{ $request->sender->name }}</h4>
                                                <p class="text-gray-500 text-sm">{{ $request->sender->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('friends.accept', $request->id) }}" method="POST">
                                                @csrf @method('POST')
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 rounded-lg text-sm">
                                                    Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('friends.reject', $request->id) }}" method="POST">
                                                @csrf @method('POST')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 rounded-lg text-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No pending friend requests</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Sent Requests -->
                <div class="bg-white rounded-xl shadow-md border overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-lg font-bold text-gray-800">
                            Sent Requests
                            @if($sentRequests->count() > 0)
                                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $sentRequests->count() }}
                                </span>
                            @endif
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        @if($sentRequests->count() > 0)
                            <div class="space-y-4">
                                @foreach($sentRequests as $request)
                                    <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                                                {{ strtoupper(substr($request->receiver->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-semibold">{{ $request->receiver->name }}</h4>
                                                <p class="text-gray-500 text-sm">{{ $request->receiver->email }}</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('friends.cancel', $request->id) }}" method="POST">
                                            @csrf @method('POST')
                                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded-lg text-sm">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No sent friend requests</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- FRIENDS LIST -->
            <div class="bg-white rounded-xl shadow-md border overflow-hidden mt-6">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-bold text-gray-800">
                        Your Friends ({{ $friends->count() }})
                    </h2>
                </div>
                
                <div class="p-6">
                    @if($friends->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($friends as $friend)
                                <div class="border rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                                            {{ strtoupper(substr($friend->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold">{{ $friend->name }}</h4>
                                            <p class="text-gray-500 text-sm">{{ $friend->email }}</p>
                                        </div>
                                    </div>
                                    <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg text-sm">
                                        Message
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-500">You don't have any friends yet</p>
                            <a href="{{ route('friends.search') }}" class="inline-block mt-4 bg-black hover:bg-gray-800 text-white font-medium py-2 px-6 rounded-lg">
                                Find Friends
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>