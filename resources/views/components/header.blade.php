<!-- Header Component with Search -->
<div class="flex items-center justify-between mb-6">
    <!-- Page Title -->
    <div class="flex-1 mr-4">
        @if(isset($title))
            <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
            @if(isset($subtitle))
                <p class="text-gray-600 mt-1">{{ $subtitle }}</p>
            @endif
        @else
            <div class="relative">
                <form action="{{ route('friends.search') }}">
                    <input type="text" 
                           placeholder="Search friends..." 
                           name="search" 
                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                </form>
            </div>
        @endif
    </div>
    
    <!-- Friend Requests and Profile -->
    <div class="flex items-center space-x-4">
        <!-- Friend Requests -->
        <div class="relative">
            @php
                $pendingCount = \App\Models\Friendship::where('receiver_id', auth()->id())
                    ->where('status', 'pending')
                    ->count();
            @endphp
            
            <button id="friendRequestsBtn" class="text-gray-600 hover:text-gray-900 relative">
                <i class="fas fa-user-friends text-xl"></i>
                @if($pendingCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $pendingCount }}
                    </span>
                @endif
            </button>
            
            <div id="friendRequestsMenu" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border z-50">
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-3">Friend Requests</h3>
                    
                    @php
                        $pendingRequests = \App\Models\Friendship::with('sender')
                            ->where('receiver_id', auth()->id())
                            ->where('status', 'pending')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($pendingRequests->count() > 0)
                        <div class="space-y-3">
                            @foreach($pendingRequests as $request)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                                            {{ strtoupper(substr($request->sender->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $request->sender->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $request->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('friends.accept', $request->id) }}" method="POST">
                                            @csrf @method('POST')
                                            <button type="submit" class="text-green-600 p-1">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('friends.reject', $request->id) }}" method="POST">
                                            @csrf @method('POST')
                                            <button type="submit" class="text-red-600 p-1">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500">No pending friend requests</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- User Profile -->
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="ml-2 font-medium hidden md:inline">{{ auth()->user()->name }}</span>
        </div>
    </div>
</div>