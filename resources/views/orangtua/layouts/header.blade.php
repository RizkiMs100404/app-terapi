<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Portal Orang Tua - Sistem Informasi Pelayanan Terapi SLBN Bagian B Garut">
<meta name="author" content="Premium Dashboard Developer">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Dashboard Orang Tua' }} | Portal Pelayanan Terapi</title>

<link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        "50":"#f5f3ff", "100":"#ede9fe", "200":"#ddd6fe", "300":"#c4b5fd",
                        "400":"#a78bfa", "500":"#8b5cf6", "600":"#7c3aed", "700":"#6d28d9",
                        "800":"#5b21b6", "900":"#4c1d95", "950":"#2e1065"
                    },
                    accent: { "500": "#6366f1", "600": "#4f46e5" },
                    darkBg: "#020617",
                    darkSurface: "#0f172a"
                },
                animation: {
                    'fade-in': 'fadeIn 0.6s ease-out forwards',
                    'slide-up': 'slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                },
                keyframes: {
                    fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                    slideUp: { '0%': { transform: 'translateY(20px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                }
            },
            fontFamily: {
                'sans': ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui'],
                'body': ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui']
            }
        }
    }
</script>

<style>
    /* HAPUS TRANSISI GLOBAL (*) SUPAYA DROPDOWN SNAPPY */
    
    /* Custom Scrollbar Premium */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { 
        background: #e0e7ff; 
        border-radius: 20px; 
    }
    .dark ::-webkit-scrollbar-thumb { background: #1e1b4b; }
    ::-webkit-scrollbar-thumb:hover { background: #818cf8; }

    /* Glassmorphism Ultra */
    .glass-premium {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dark .glass-premium {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Soft Glow Effect */
    .glow-indigo {
        box-shadow: 0 0 20px -5px rgba(99, 102, 241, 0.2);
    }
    
    /* Transisi ditaruh spesifik di hover aja, jangan di semua elemen (*) */
    .hover-glow {
        transition: all 0.3s ease;
    }
    .hover-glow:hover {
        box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
</style>