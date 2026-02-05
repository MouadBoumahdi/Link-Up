<!-- Sidebar Component -->
<aside class="lg:w-1/4">
    <div class="bg-white rounded-xl shadow-md border overflow-hidden sticky top-8">
        
        <!-- Profile -->
        <div class="p-6 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <h2 class="text-lg font-bold">{{ auth()->user()->name }}</h2>
            <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
            
            <!-- Stats -->
            <div class="mt-6 grid grid-cols-3 gap-4 border-t pt-4">
                <div class="text-center">
                    <p class="text-xl font-bold">{{ auth()->user()->friends()->count() }}</p>
                    <p class="text-xs text-gray-500">Friends</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold">0</p>
                    <p class="text-xs text-gray-500">Posts</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold">0</p>
                    <p class="text-xs text-gray-500">Sent</p>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="border-t px-4 py-4">
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-home mr-3"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('friends.index') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 rounded-lg {{ request()->routeIs('friends.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-user-friends mr-3"></i>
                    <span>My Friends</span>
                </a>
                <a  href="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Logout</span>
                    </button>
                </a>
            </div>
        </div>
    </div>
</aside>