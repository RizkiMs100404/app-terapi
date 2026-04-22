<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Portal Guru Terapis - SLB Negeri Bagian B Garut">
<meta name="author" content="Premium Dashboard Developer">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Dashboard Guru' }} | Portal Terapis SLBN B Garut</title>

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
                    // Kita ubah primary ke Emerald untuk identitas Guru/Medis yang tenang
                    primary: {"50":"#ecfdf5","100":"#d1fae5","200":"#a7f3d0","300":"#6ee7b7","400":"#34d399","500":"#10b981","600":"#059669","700":"#047857","800":"#065f46","900":"#064e3b","950":"#022c22"},
                    darkBg: "#020617",
                    darkSurface: "#0f172a"
                },
                animation: {
                    'fade-in': 'fadeIn 0.5s ease-out forwards',
                    'slide-up': 'slideUp 0.4s ease-out forwards',
                    'pulse-soft': 'pulseSoft 2s infinite',
                },
                keyframes: {
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' },
                    },
                    slideUp: {
                        '0%': { transform: 'translateY(15px)', opacity: '0' },
                        '100%': { transform: 'translateY(0)', opacity: '1' },
                    },
                    pulseSoft: {
                        '0%, 100%': { opacity: '1' },
                        '50%': { opacity: '0.8' },
                    }
                },
                borderRadius: {
                    '4xl': '2rem',
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
    /* Smooth Transition All Elements */
    * {
        transition-property: background-color, border-color, color, fill, stroke, transform, box-shadow;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Custom Premium Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .dark ::-webkit-scrollbar-thumb {
        background: #1e293b;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #10b981; /* Primary Color on Hover */
    }

    /* Glassmorphism Effect */
    .glass-emerald {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(16, 185, 129, 0.1);
    }
    .dark .glass-emerald {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(16, 185, 129, 0.05);
    }

    /* Premium Button Shadow */
    .btn-premium-shadow {
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }
</style>