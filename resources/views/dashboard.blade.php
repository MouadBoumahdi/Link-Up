<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .post-card:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Top Navbar - Black -->
    <nav class="bg-black shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left side: Logo and Nav Items -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-white">{{ config('app.name', 'LinkUp') }}</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="#" class="border-b-2 border-white text-white inline-flex items-center px-1 pt-1 text-sm font-medium">
                            <i class="fas fa-home mr-2"></i>
                            Home
                        </a>
                        =
                        <a href="#" class="border-transparent text-gray-300 hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 text-sm font-medium">
                            <i class="fas fa-bell mr-2"></i>
                            Notifications
                        </a>
                    </div>
                </div>

                <!-- Right side: Search and Profile -->
                <div class="flex items-center">
                    <!-- Search -->
                    <div class="hidden sm:block mr-4">
                        <div class="relative">
                            <input type="text" placeholder="Search posts..." class="pl-10 pr-4 py-2 bg-gray-800 border border-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent w-64">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="sm:hidden mr-4">
                        <button type="button" class="text-gray-300 hover:text-white">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content - Posts Feed -->
            <main class="lg:w-2/3">
                <!-- Create Post Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-4 border border-gray-300">
                            J
                        </div>
                        <input type="text" placeholder="What's on your mind, John?" class="flex-1 border border-gray-300 rounded-full px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent">
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-4">
                       
                        
                        <button class="flex-1 bg-black hover:bg-gray-800 text-white font-medium py-2 px-4 rounded-lg ml-4">
                            Post
                        </button>
                    </div>
                </div>

                <!-- Posts Feed -->
                <div class="space-y-6">
                    <!-- Post 1 -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 post-card">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-4 border border-gray-300">
                                        J
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">John</h3>
                                        <p class="text-sm text-gray-500">2 hours ago</p>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-800 mb-4">
                                Just finished an amazing hike in the mountains! The view was absolutely breathtaking. Nature always has a way of putting things into perspective. 🌄
                            </p>
                            
                            <div class="mb-4">
                                <div class="w-full h-64 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-mountain text-white text-4xl opacity-50"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between border-t border-b border-gray-200 py-3">
                                <button class="flex items-center text-gray-700 hover:text-black">
                                    <i class="far fa-heart mr-2"></i>
                                    <span>Like</span>
                                    <span class="ml-1 text-gray-600">42</span>
                                </button>
                                <button class="flex items-center text-gray-700 hover:text-black">
                                    <i class="far fa-comment mr-2"></i>
                                    <span>Comment</span>
                                    <span class="ml-1 text-gray-600">8</span>
                                </button>
                                <button class="flex items-center text-gray-700 hover:text-black">
                                    <i class="far fa-share-square mr-2"></i>
                                    <span>Share</span>
                                </button>
                            </div>
                            
                           
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Sidebar - Profile and Settings -->
           <aside class="lg:w-1/3">
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold text-3xl mb-4 border border-gray-300">
                J
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-1">John</h2>
            <p class="text-gray-600 mb-4">Software Developer</p>
            
            <div class="w-full space-y-3">
                <!-- Friends -->
                <a href="#" class="flex items-center p-3 hover:bg-gray-100 rounded-lg cursor-pointer border border-transparent hover:border-gray-300">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-800 mr-3">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">Friends</h4>
                        <p class="text-sm text-gray-500">342 connections</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
                
                <!-- My Posts -->
                <a href="#" class="flex items-center p-3 hover:bg-gray-100 rounded-lg cursor-pointer border border-transparent hover:border-gray-300">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-800 mr-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">My Posts</h4>
                        <p class="text-sm text-gray-500">48 posts</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
                
                <!-- Settings - FIXED VERSION -->
                <a href="{{ route('profile.edit') }}" class="flex items-center p-3 hover:bg-gray-100 rounded-lg cursor-pointer border border-transparent hover:border-gray-300">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-800 mr-3">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">Settings</h4>
                        <p class="text-sm text-gray-500">Account preferences</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
                
                <!-- Logout -->
                <a href="{{ route('logout') }}" class="flex items-center p-3 hover:bg-gray-100 rounded-lg cursor-pointer border border-transparent hover:border-gray-300">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-800 mr-3">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">Logout</h4>
                        <p class="text-sm text-gray-500">Sign out of your account</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
            </div>
        </div>
    </div>
</aside>
        </div>
    </div>
</body>
</html>