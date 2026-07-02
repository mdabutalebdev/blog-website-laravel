<!-- Top Announcement Bar -->
@if(\App\Models\Setting::get('announcement_active', '1') == '1')
<div class="relative overflow-hidden bg-gray-900 text-white text-xs sm:text-sm py-2 shadow-inner">
    <!-- Static gradient background -->
    <div class="absolute inset-0 opacity-80 bg-gradient-to-r from-blue-600 via-purple-600 to-orange-500"></div>
        
    <div class="container mx-auto px-4 lg:px-16 relative z-10 flex justify-center sm:justify-between items-center">
        <!-- Left: Animated announcement -->
        <div class="flex items-center gap-3">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            <span class="font-medium tracking-wide">
                <span class="text-gray-200">{{ \App\Models\Setting::get('announcement_title', 'New Feature:') }}</span> 
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-blue-200 animate-pulse ml-1">{{ \App\Models\Setting::get('announcement_text', 'Write your blogs with the brand new markdown editor! 🎉') }}</span>
            </span>
        </div>
        
        <!-- Right: Socials/Links -->
        <div class="hidden sm:flex items-center gap-5 font-semibold text-white">
            <a href="https://wa.me/01710845363" target="_blank" class="hover:text-gray-200 transition flex items-center gap-2 group">
                <i class="fab fa-whatsapp text-lg group-hover:scale-110 transition-transform"></i>
                <span class="tracking-wide text-sm">01710845363</span>
            </a>
        </div>
    </div>
</div>
@endif



<nav class="bg-white shadow-sm sticky top-0 z-50 glass">
    <div class="container mx-auto px-4 lg:px-16 h-16 flex items-center justify-between">
        <!-- Logo (Left) -->
        <div class="flex items-center md:w-48">
            <a href="/" class="flex items-center">
                <img src="/uploads/avatars/logo.jpeg" alt="Logo" class="h-10 w-auto object-contain rounded shadow-sm border border-gray-100">
            </a>
        </div>
        
        <!-- Menus (Center) -->
        <div class="hidden md:flex flex-1 justify-center gap-8">
            <a href="/" class="text-gray-600 hover:text-blue-600 font-medium transition">Home</a>
            <a href="/books" class="text-gray-600 hover:text-blue-600 font-medium transition">Books</a>
            <a href="/category/banking" class="text-gray-600 hover:text-blue-600 font-medium transition">Banking</a>
            <a href="/category/law" class="text-gray-600 hover:text-blue-600 font-medium transition">Law</a>
            <a href="/category/education" class="text-gray-600 hover:text-blue-600 font-medium transition">Education</a>
            <a href="/category/health" class="text-gray-600 hover:text-blue-600 font-medium transition">Health</a>
        </div>

        <!-- Actions (Right) -->
        <div class="flex items-center justify-end gap-4 md:w-48">
            @if (isset($_SESSION['user_id']))
                <a href="/post/create" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-semibold transition shadow-sm hover:shadow text-sm">Write Blog</a>
                
                <!-- Profile Dropdown -->
                <div class="relative ml-2">
                    <button type="button" id="profile-menu-btn" class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 border-2 border-white shadow-sm flex items-center justify-center font-bold text-blue-700 overflow-hidden ring-2 ring-transparent hover:ring-blue-100 transition focus:outline-none">
                        @if(!empty($_SESSION['user_avatar']))
                            <img src="{{ $_SESSION['user_avatar'] }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            {{ substr($_SESSION['user_name'] ?? 'U', 0, 1) }}
                        @endif
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] py-2 hidden border border-gray-100/50 transform transition duration-200 origin-top-right z-50">
                        <div class="px-4 py-3 border-b border-gray-50 mb-1">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $_SESSION['user_name'] ?? 'User' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $_SESSION['user_email'] ?? '' }}</p>
                        </div>
                        <a href="/profile" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50/50 hover:text-blue-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile Settings
                        </a>
                        <a href="/my-blogs" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50/50 hover:text-blue-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            My Blogs
                        </a>
                        @php
                            $isAdmin = false;
                            if (!empty($_SESSION['user_id'])) {
                                $userModel = \App\Models\User::findById($_SESSION['user_id']);
                                if ($userModel && !empty($userModel['is_admin'])) {
                                    $isAdmin = true;
                                }
                            }
                        @endphp
                        @if ($isAdmin)
                        <a href="/admin" class="flex items-center gap-3 px-4 py-2.5 text-sm text-indigo-700 font-medium hover:bg-indigo-50/50 hover:text-indigo-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Admin Panel
                        </a>
                        @endif
                        <div class="h-px bg-gray-50 my-1"></div>
                        <a href="/logout" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50/50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Sign Out
                        </a>
                    </div>
                </div>
            @else
                <a href="/login" class="text-gray-600 hover:text-blue-600 font-medium transition text-sm">Log In</a>
                <a href="/register" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-full font-semibold transition shadow-sm hover:shadow text-sm">Sign Up</a>
            @endif
        </div>
    </div>
</nav>
