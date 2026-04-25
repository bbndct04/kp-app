<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BlotterLink — {{ $title ?? 'Welcome' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ─── Bouncing logo animation ─── */
        @keyframes bounce {
            0%, 100% { transform: translateY(0px); }
            30%       { transform: translateY(-18px); }
            50%       { transform: translateY(-8px); }
            70%       { transform: translateY(-14px); }
        }

        @keyframes bounceIn {
            0%   { transform: scale(0) translateY(40px); opacity: 0; }
            60%  { transform: scale(1.15) translateY(-6px); opacity: 1; }
            80%  { transform: scale(0.95) translateY(2px); }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }

        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(91,160,245,.0); }
            50%       { box-shadow: 0 0 24px 8px rgba(91,160,245,.35); }
        }

        .logo-bl {
            animation: bounceIn .8s cubic-bezier(.36,.07,.19,.97) both,
                       bounce 2.8s ease-in-out 1.2s infinite;
        }

        .logo-brgy {
            animation: bounceIn .8s cubic-bezier(.36,.07,.19,.97) .2s both,
                       bounce 2.8s ease-in-out 1.5s infinite;
        }

        .logo-bl:hover, .logo-brgy:hover {
            animation: none;
            transform: scale(1.1);
            transition: transform .25s cubic-bezier(.34,1.56,.64,1);
        }

        .brand-name {
            animation: fadeSlideDown .7s ease .6s both;
        }

        .brand-tagline {
            animation: fadeSlideDown .7s ease .8s both;
        }

        .brand-divider {
            animation: fadeSlideDown .5s ease 1s both;
        }

        .auth-features {
            animation: fadeSlideUp .6s ease 1.1s both;
        }

        .auth-form-side > div {
            animation: fadeSlideUp .7s ease .3s both;
        }

        /* Panel entrance */
        .auth-panel-inner {
            animation: fadeSlideDown .6s ease .1s both;
        }

        /* Smooth page transition */
        body {
            animation: fadeSlideDown .4s ease both;
        }

        /* Glowing ring on logos */
        .logo-bl {
            filter: drop-shadow(0 4px 12px rgba(91,160,245,.4));
        }

        .logo-brgy {
            filter: drop-shadow(0 4px 12px rgba(255,255,255,.2));
        }
    </style>
</head>
<body class="font-sans antialiased" style="background:#f0f4fc;">

<div class="auth-split">

    {{-- ═══════════════════════════════
         LEFT PANEL
    ═══════════════════════════════ --}}
    <div class="auth-panel">
        <div class="auth-panel-inner" style="position:relative;z-index:1;text-align:center;width:100%;">

            {{-- Logos Row --}}
            <div style="display:flex;align-items:center;justify-content:center;gap:20px;margin-bottom:28px;">

                {{-- BlotterLink Logo --}}
                <div class="logo-bl"
                    style="width:88px;height:88px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,.35);cursor:pointer;flex-shrink:0;">
                    <img src="{{ asset('images/blotterlink-logo.png') }}"
                        alt="BlotterLink Logo"
                        style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>

                {{-- Divider line between logos --}}
                <div style="width:1.5px;height:60px;background:rgba(255,255,255,.2);border-radius:99px;flex-shrink:0;"></div>

                {{-- Barangay Logo --}}
                <div class="logo-brgy"
                    style="width:88px;height:88px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,.35);cursor:pointer;flex-shrink:0;background:#fff;">
                    <img src="{{ asset('images/barangay-logo.jpg') }}"
                        alt="Barangay New Kababae Logo"
                        style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>

            </div>

            {{-- Brand Text --}}
            <h1 class="brand-name"
                style="font-size:28px;font-weight:700;color:#fff;letter-spacing:-.5px;margin-bottom:8px;">
                BlotterLink
            </h1>

            <div class="brand-divider"
                style="width:40px;height:2.5px;background:rgba(91,160,245,.8);margin:0 auto 12px;border-radius:99px;"></div>

            <p class="brand-tagline"
                style="font-size:14px;color:rgba(255,255,255,.65);line-height:1.65;max-width:260px;margin:0 auto;">
                Barangay Complaints &amp;<br>Incident Reporting System
            </p>

        </div>
    </div>

    {{-- ═══════════════════════════════
         RIGHT PANEL — Form Slot
    ═══════════════════════════════ --}}
    <div class="auth-form-side">
        <div style="width:100%;max-width:440px;">
            {{ $slot }}
        </div>
    </div>

</div>

{{-- GSAP --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
    // Smooth hover lift on form elements
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', () => {
            gsap.to(input, { scale: 1.01, duration: .15, ease: 'power1.out' });
        });
        input.addEventListener('blur', () => {
            gsap.to(input, { scale: 1, duration: .15, ease: 'power1.out' });
        });
    });

    // Stagger entrance for form elements
    gsap.from('.form-group, .btn-primary, .role-pill, .auth-footer', {
        duration: .5,
        y: 16,
        opacity: 0,
        stagger: .06,
        ease: 'power2.out',
        delay: .5,
    });
</script>

</body>
</html>