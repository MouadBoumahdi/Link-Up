<!-- Search Results Component -->
@if(isset($search) && isset($friends))
<div class="bg-white rounded-xl shadow-md border overflow-hidden mb-6">
    <div class="bg-gray-900 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-search text-white mr-3"></i>
                <h2 class="text-xl font-bold text-white">
                    Search Results for "{{ $search }}"
                </h2>
            </div>
            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">
                Clear Search
            </a>
        </div>
    </div>
    
    <div class="p-6">
        @if($friends->count() > 0)
            <div class="mb-4">
                <p class="text-gray-600">
                    Found {{ $friends->count() }} {{ $friends->count() === 1 ? 'person' : 'people' }}
                </p>
            </div>
            
            <div class="space-y-3">
                @foreach ($friends as $friend)
                    <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                                {{ strtoupper(substr($friend->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-semibold">{{ $friend->name }}</h4>
                                <p class="text-gray-500 text-sm">{{ $friend->email }}</p>
                            </div>
                        </div>
                        
                        <!-- Friend Action Buttons -->
                        @php
                            $friendship = \App\Models\Friendship::where(function($query) use ($friend) {
                                    $query->where('sender_id', auth()->id())
                                          ->where('receiver_id', $friend->id);
                                })
                                ->orWhere(function($query) use ($friend) {
                                    $query->where('sender_id', $friend->id)
                                          ->where('receiver_id', auth()->id());
                                })
                                ->first();
                        @endphp
                        
                        <div>
                            @if($friendship)
                                @if($friendship->status == 'pending')
                                    @if($friendship->sender_id == auth()->id())
                                        <form action="{{ route('friends.cancel', $friendship->id) }}" method="POST" class="inline">
                                            @csrf @method('POST')
                                            <button type="submit" class="bg-yellow-500 text-white font-medium py-2 px-4 rounded-lg text-sm">
                                                Pending
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex space-x-2">
                                            <form action="{{ route('friends.accept', $friendship->id) }}" method="POST">
                                                @csrf @method('POST')
                                                <button type="submit" class="bg-green-500 text-white font-medium py-2 px-4 rounded-lg text-sm">
                                                    Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('friends.reject', $friendship->id) }}" method="POST">
                                                @csrf @method('POST')
                                                <button type="submit" class="bg-red-500 text-white font-medium py-2 px-4 rounded-lg text-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @elseif($friendship->status == 'accepted')
                                    <button class="bg-green-600 text-white font-medium py-2 px-4 rounded-lg text-sm" disabled>
                                        Friends
                                    </button>
                                @endif
                            @else
                                <form action="{{ route('friends.send', $friend->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-black hover:bg-gray-800 text-white font-medium py-2 px-4 rounded-lg text-sm">
                                        Add Friend
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                    <i class="fas fa-search text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3">No Users Found</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    No users found for "{{ $search }}"
                </p>
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-black font-medium">
                    Back to Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endif