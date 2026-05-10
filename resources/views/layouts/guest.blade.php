<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- ✅ Updated title --}}
    <title>KP App — {{ $title ?? 'Welcome' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes bounceA {
            0%,100% { transform: translateY(0); }
            40%      { transform: translateY(-16px); }
            70%      { transform: translateY(-8px); }
        }
        @keyframes bounceB {
            0%,100% { transform: translateY(0); }
            40%      { transform: translateY(-16px); }
            70%      { transform: translateY(-8px); }
        }
        .logo-a { animation: bounceA 2.8s ease-in-out infinite; }
        .logo-b { animation: bounceB 2.8s ease-in-out .35s infinite; }
        .logo-a:hover, .logo-b:hover { animation: none; transform: scale(1.08); transition: transform .2s; }
        .panel-text { animation: fadeDown .7s ease .3s both; }
        @keyframes fadeDown { from { opacity:0; transform: translateY(-14px); } to { opacity:1; transform:translateY(0); } }
        .form-side-inner { animation: fadeUp .6s ease .2s both; }
        @keyframes fadeUp { from { opacity:0; transform: translateY(14px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body style="background:#f5f7fa;font-family:Inter,sans-serif;">

<div class="auth-split">

    {{-- LEFT PANEL --}}
    <div class="auth-panel">
        <div class="panel-text" style="position:relative;z-index:1;text-align:center;width:100%;">

            {{-- Dual Logos --}}
            <div style="display:flex;align-items:center;justify-content:center;gap:22px;margin-bottom:28px;">
                <div class="logo-a"
                    style="width:86px;height:86px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,.3);flex-shrink:0;">
                    <img src="{{ asset('images/blotterlink-logo.png') }}" alt="KP App"
                        style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>
                <div style="width:1px;height:56px;background:rgba(255,255,255,.2);flex-shrink:0;"></div>
                <div class="logo-b"
                    style="width:86px;height:86px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,.3);flex-shrink:0;background:#fff;">
                    <img src="{{ asset('images/barangay-logo.jpg') }}" alt="Barangay New Kababae"
                        style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>
            </div>

            {{-- ✅ Updated system name --}}
            <h1 style="font-size:22px;font-weight:700;color:#fff;letter-spacing:-.5px;margin-bottom:6px;">
                Katarungang Pambarangay App
            </h1>
            <div style="width:36px;height:2px;background:rgba(255,255,255,.4);margin:0 auto 12px;border-radius:99px;"></div>
            <p style="font-size:14px;color:rgba(255,255,255,.6);line-height:1.65;max-width:260px;margin:0 auto 32px;">
                Barangay New Kababae<br>Olongapo City, Zambales
            </p>

            {{-- Feature list --}}
            <div style="text-align:left;max-width:260px;margin:0 auto;">
                @foreach([
                    'Submit complaints online',
                    'Track your report in real time',
                    'Transparent case management',
                    'Secure & verified accounts',
                ] as $feat)
                <div style="display:flex;align-items:center;gap:10px;padding:7px 0;color:rgba(255,255,255,.65);font-size:13.5px;border-bottom:1px solid rgba(255,255,255,.07);">
                    <div style="width:5px;height:5px;border-radius:50%;background:rgba(255,255,255,.5);flex-shrink:0;"></div>
                    {{ $feat }}
                </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="auth-form-side">
        <div class="form-side-inner" style="width:100%;max-width:440px;">
            {{ $slot }}
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</body>
</html>