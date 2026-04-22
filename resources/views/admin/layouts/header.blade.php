<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Sistem Informasi Pelayanan Terapi - SLB Negeri Bagian B Garut">
<meta name="author" content="Premium Dashboard Developer">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Dashboard Admin' }} | Pelayanan Terapi</title>

<link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"},
                    // Tambahan warna dark mode yang lebih deep/premium
                    darkBg: "#0f172a",
                    darkSurface: "#1e293b"
                },
                animation: {
                    'fade-in': 'fadeIn 0.5s ease-out forwards',
                    'slide-up': 'slideUp 0.4s ease-out forwards',
                },
                keyframes: {
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' },
                    },
                    slideUp: {
                        '0%': { transform: 'translateY(10px)', opacity: '0' },
                        '100%': { transform: 'translateY(0)', opacity: '1' },
                    }
                }
            },
            fontFamily: {
                'body': ['Inter', 'ui-sans-serif', 'system-ui'],
                'sans': ['Inter', 'ui-sans-serif', 'system-ui']
            }
        }
    }
</script>

<style>
    /* Premium Smoothness */
    * {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    /* Modern Scrollbar */
    ::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .dark ::-webkit-scrollbar-thumb {
        background: #334155;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Glassmorphism Classes */
    .glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .dark .glass {
        background: rgba(15, 23, 42, 0.7);
    }
</style>