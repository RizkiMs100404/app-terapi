<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    {{-- Kita arahkan ke header khusus orangtua jika ada, atau pakai yang lama --}}
    @include('orangtua.layouts.header')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Premium Scrollbar - Tema orangtua (Indigo) */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: #e0e7ff;
            border-radius: 20px;
        }
        .dark ::-webkit-scrollbar-thumb { background: #312e81; }
        ::-webkit-scrollbar-thumb:hover { background: #6366f1; }

        /* Animasi Lembut untuk orangtua */
        .page-enter {
            animation: slideUpFade 0.5s ease-out forwards;
        }

        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Glassmorphism Effect untuk Main Content */
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="antialiased bg-[#fcfcfd] dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    {{-- Navbar khusus orangtua --}}
    @include('orangtua.layouts.navbar')

    <div class="flex pt-20 overflow-hidden">

        {{-- Sidebar khusus orangtua --}}
        @include('orangtua.layouts.sidebar')

        {{-- Backdrop dengan blur lebih tinggi --}}
        <div id="sidebarBackdrop" class="fixed inset-0 z-20 hidden bg-indigo-900/40 backdrop-blur-md transition-opacity duration-300"></div>

        <div id="main-content" class="relative flex flex-col w-full min-h-screen overflow-y-auto transition-all duration-300 lg:ml-72">

            <main class="flex-grow">
                {{-- Padding lebih lega agar tidak terasa sesak buat orang tua --}}
                <div class="p-5 md:p-10 pt-4 md:pt-8">
                    <div class="page-enter">
                        {{-- Slot untuk Banner Greeting (Bisa ditaruh di blade content) --}}
                        @yield('content')
                    </div>
                </div>
            </main>

            @include('orangtua.layouts.footer')
        </div>

    </div>

    {{-- Script Flowbite & Custom Logic --}}
    <script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const mainContent = document.getElementById('main-content');

        const toggleSidebar = () => {
            const isHidden = sidebar.classList.contains('hidden');

            if (isHidden) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex', 'animate-none');
                // Kita pakai transform untuk mobile menu yang lebih smooth
                sidebar.style.transform = "translateX(0)";
                sidebarBackdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex');
                sidebarBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        };

        document.getElementById('toggleSidebarMobile')?.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebarBackdrop?.addEventListener('click', toggleSidebar);

        // Auto Close Sidebar on Resize
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
