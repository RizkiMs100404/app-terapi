<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @include('admin.layouts.header') 
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Custom Scrollbar Premium */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #374151; }
        ::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
        
        /* Smooth Transition untuk Dark Mode */
        * { transition: background-color 0.3s ease, border-color 0.3s ease; }
    </style>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    
    @include('admin.layouts.navbar')

    <div class="flex pt-20 overflow-hidden bg-gray-50 dark:bg-gray-950">

        @include('admin.layouts.sidebar')

        <div id="sidebarBackdrop" class="fixed inset-0 z-20 hidden bg-gray-900/50 backdrop-blur-sm dark:bg-gray-900/80"></div>

        <div id="main-content" class="relative flex flex-col w-full min-h-screen overflow-y-auto transition-all duration-300 bg-gray-50 lg:ml-72 dark:bg-gray-950">
            
            <main class="flex-grow text-fade-in">
                <div class="p-4 md:p-8 pt-4 md:pt-6">
                    <div class="animate-slide-up">
                        @yield('content')
                    </div>
                </div>
            </main>
            
            @include('admin.layouts.footer')
        </div>

    </div>

    <script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const mainContent = document.getElementById('main-content');

        const toggleSidebar = () => {
            // Logic buka tutup yang lebih smooth
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex', 'animate-fade-in');
                sidebarBackdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex', 'animate-fade-in');
                sidebarBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        };

        // Event Listeners
        document.getElementById('toggleSidebarMobile')?.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebarBackdrop?.addEventListener('click', toggleSidebar);

        // Responsive Adjustment
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex');
                sidebarBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>