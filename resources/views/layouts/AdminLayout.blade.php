<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BlogSite</title>
    <link rel="icon" type="image/jpeg" href="/uploads/avatars/logo.jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Hind Siliguri', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 overflow-hidden">
    <div class="flex h-screen w-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col transition-all duration-300 relative z-20" id="sidebar">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <a href="/" class="text-xl font-bold text-gray-800">Admin Panel</a>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1 px-3">
                    <li>
                        <a href="#" onclick="switchTab('blogs')" id="nav-blogs" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-50 text-blue-700 font-medium">
                            <i class="fas fa-tachometer-alt w-5 text-center"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="pt-4 pb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Home Page Settings
                    </li>
                    <li>
                        <a href="#" onclick="switchTab('banners')" id="nav-banners" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium transition-colors">
                            <i class="fas fa-images w-5 text-center"></i>
                            Hero
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="switchTab('settings')" id="nav-settings" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium transition-colors">
                            <i class="fas fa-cog w-5 text-center"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 relative z-10">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-800" id="page-title">Dashboard</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <button class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                            Test User <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            // For simple toggle: just slide out of view
            if (sidebar.style.marginLeft === '-16rem') {
                sidebar.style.marginLeft = '0';
            } else {
                sidebar.style.marginLeft = '-16rem';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
