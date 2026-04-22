<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @include('guru.layouts.header') 
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom Scrollbar Premium - Emerald Touch */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: #10b981; 
            border-radius: 10px; 
            opacity: 0.5;
        }
        .dark ::-webkit-scrollbar-thumb { background: #065f46; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
        
        /* Smooth Transition untuk Dark Mode */
        * { transition: background-color 0.3s ease, border-color 0.3s ease; }

        /* Animation Utility */
        .text-fade-in { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="antialiased bg-[#fcfdfd] dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    
    @include('guru.layouts.navbar')

    <div class="flex pt-20 overflow-hidden bg-[#fcfdfd] dark:bg-gray-950">

        @include('guru.layouts.sidebar')

        <div id="sidebarBackdrop" class="fixed inset-0 z-20 hidden bg-emerald-950/20 backdrop-blur-sm dark:bg-gray-900/80 transition-opacity duration-300"></div>

        <div id="main-content" class="relative flex flex-col w-full min-h-screen overflow-y-auto transition-all duration-300 bg-[#fcfdfd] lg:ml-72 dark:bg-gray-950">
            
            <main class="flex-grow text-fade-in">
                <div class="p-4 md:p-10 pt-4 md:pt-8">
                    <div class="animate-slide-up">
                        @yield('content')
                    </div>
                </div>
            </main>
            
            @include('guru.layouts.footer')
        </div>

    </div>

    <script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const mainContent = document.getElementById('main-content');

        const toggleSidebar = () => {
            // Logic buka tutup yang konsisten dengan desain premium
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

        // Auto close/open on resize
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