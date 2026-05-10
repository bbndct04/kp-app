<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KP App — Barangay New Kababae</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; color: #1e2d5e; }
        .hero { background: linear-gradient(135deg, #0f1b3d 0%, #1e2d5e 60%, #2d4080 100%); min-height: 100vh; display: flex; flex-direction: column; }
        .nav { display: flex; align-items: center; justify-content: space-between; padding: 20px 60px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .nav-logo { display: flex; align-items: center; gap: 12px; }
        .nav-logo img { width: 40px; height: 40px; border-radius: 50%; border: 2px solid rgba(255,255,255,.3); }
        .nav-title { color: #fff; font-size: 18px; font-weight: 700; }
        .nav-sub { color: rgba(255,255,255,.4); font-size: 11px; text-transform: uppercase; letter-spacing: .5px; }
        .nav-actions { display: flex; gap: 10px; }
        .btn-nav-outline { padding: 9px 22px; border-radius: 8px; border: 1.5px solid rgba(255,255,255,.3); color: #fff; background: transparent; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; font-family: Inter, sans-serif; transition: all .2s; }
        .btn-nav-outline:hover { background: rgba(255,255,255,.1); }
        .btn-nav-primary { padding: 9px 22px; border-radius: 8px; border: none; color: #1e2d5e; background: #fff; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; font-family: Inter, sans-serif; transition: all .2s; }
        .btn-nav-primary:hover { background: #e8eef8; }
        .hero-body { flex: 1; display: flex; align-items: center; justify-content: center; padding: 60px; gap: 80px; }
        .hero-left { max-width: 540px; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); border-radius: 99px; padding: 6px 14px; font-size: 12px; color: rgba(255,255,255,.8); font-weight: 600; margin-bottom: 24px; }
        .hero-title { font-size: 48px; font-weight: 800; color: #fff; line-height: 1.15; letter-spacing: -1.5px; margin-bottom: 20px; }
        .hero-title span { color: #93c3fa; }
        .hero-desc { font-size: 16px; color: rgba(255,255,255,.6); line-height: 1.7; margin-bottom: 32px; }
        .hero-cta { display: flex; gap: 12px; margin-bottom: 48px; flex-wrap: wrap; }
        .btn-hero-primary { display: inline-flex; align-items: center; gap: 8px; background: #fff; color: #1e2d5e; border-radius: 10px; padding: 14px 28px; font-size: 15px; font-weight: 700; text-decoration: none; transition: all .2s; box-shadow: 0 4px 20px rgba(0,0,0,.2); }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.3); }
        .btn-hero-outline { display: inline-flex; align-items: center; gap: 8px; background: transparent; color: #fff; border: 2px solid rgba(255,255,255,.3); border-radius: 10px; padding: 14px 28px; font-size: 15px; font-weight: 600; text-decoration: none; transition: all .2s; }
        .btn-hero-outline:hover { background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.5); }
        .hero-features { display: flex; flex-direction: column; gap: 12px; }
        .feature-item { display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,.7); font-size: 14px; }
        .feature-dot { width: 20px; height: 20px; border-radius: 50%; background: rgba(147,195,250,.2); border: 1.5px solid rgba(147,195,250,.4); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .hero-right { display: flex; flex-direction: column; align-items: center; gap: 20px; }
        .qr-card { background: #fff; border-radius: 20px; padding: 28px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,.3); }
        .qr-title { font-size: 13px; font-weight: 700; color: #1e2d5e; margin-bottom: 4px; text-transform: uppercase; letter-spacing: .5px; }
        .qr-sub { font-size: 12px; color: #94a3b8; margin-bottom: 16px; }
        .qr-instruction { font-size: 12px; color: #64748b; margin-top: 14px; line-height: 1.5; }
        .stats-row { display: flex; gap: 24px; }
        .stat-item { text-align: center; }
        .stat-val { font-size: 28px; font-weight: 800; color: #fff; letter-spacing: -1px; }
        .stat-label { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 2px; }
        .features-section { background: #fff; padding: 80px 60px; }
        .section-tag { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #3554a0; margin-bottom: 10px; }
        .section-title { font-size: 32px; font-weight: 800; color: #1e2d5e; letter-spacing: -1px; margin-bottom: 14px; }
        .section-desc { font-size: 15px; color: #64748b; line-height: 1.7; max-width: 500px; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 48px; }
        .feature-card { background: #f8fafc; border: 1px solid #e5e9f0; border-radius: 14px; padding: 24px; transition: all .2s; }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(30,45,94,.1); border-color: #c5d5f0; }
        .feature-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px; }
        .feature-title { font-size: 15px; font-weight: 700; color: #1e2d5e; margin-bottom: 6px; }
        .feature-desc { font-size: 13px; color: #64748b; line-height: 1.6; }
        .process-section { background: #f5f7fa; padding: 80px 60px; }
        .process-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 48px; position: relative; }
        .process-step { text-align: center; position: relative; }
        .step-num { width: 48px; height: 48px; border-radius: 50%; background: #1e2d5e; color: #fff; font-size: 18px; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
        .step-title { font-size: 14px; font-weight: 700; color: #1e2d5e; margin-bottom: 6px; }
        .step-desc { font-size: 13px; color: #64748b; line-height: 1.5; }
        .step-connector { position: absolute; top: 24px; left: calc(50% + 28px); right: calc(-50% + 28px); height: 2px; background: #d1d9e6; }
        .footer { background: #0f1b3d; padding: 40px 60px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
        .footer-left { color: rgba(255,255,255,.5); font-size: 13px; }
        .footer-right { display: flex; gap: 20px; }
        .footer-link { color: rgba(255,255,255,.4); font-size: 13px; text-decoration: none; }
        .footer-link:hover { color: rgba(255,255,255,.8); }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<div class="hero">
    <nav class="nav">
        <div class="nav-logo">
            <img src="{{ asset('images/blotterlink-logo.png') }}" alt="KP App">
            <div>
                {{-- ✅ Full name in navbar --}}
                <div class="nav-title">Katarungang Pambarangay App</div>
                <div class="nav-sub">Brgy. New Kababae, Olongapo City</div>
            </div>
        </div>
        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-nav-primary">Go to Dashboard →</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-outline">Sign In</a>
                <a href="{{ route('register') }}" class="btn-nav-primary">Register</a>
            @endauth
        </div>
    </nav>

    {{-- HERO --}}
    <div class="hero-body">
        <div class="hero-left">
            <div class="hero-badge">
                🏛️ Official Barangay System — New Kababae, Olongapo City
            </div>
            <h1 class="hero-title">
                File Complaints<br>
                <span>Online & Track</span><br>
                in Real Time
            </h1>
            <p class="hero-desc">
                The <strong style="color:#fff;">Katarungang Pambarangay App</strong> is the official online
                complaint and incident reporting system of Barangay New Kababae. File your complaint
                anytime, anywhere — and track its status through the full Katarungang Pambarangay process.
            </p>
            <div class="hero-cta">
                <a href="{{ route('register') }}" class="btn-hero-primary">
                    📝 File a Complaint
                </a>
                <a href="{{ route('login') }}" class="btn-hero-outline">
                    Sign In →
                </a>
            </div>
            <div class="hero-features">
                @foreach([
                    '✓ Submit complaints online — no need to visit the barangay office',
                    '✓ Track your case status in real time',
                    '✓ Get notified when your hearing is scheduled',
                    '✓ Official KP forms generated automatically',
                    '✓ Secure and verified resident accounts',
                ] as $f)
                <div class="feature-item">
                    <div class="feature-dot">
                        <svg width="10" height="10" fill="none" stroke="#93c3fa" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    {{ $f }}
                </div>
                @endforeach
            </div>
        </div>

        {{-- QR CODE --}}
        <div class="hero-right">
            <div class="qr-card">
                <div class="qr-title">Scan to Access</div>
                {{-- ✅ Updated QR subtitle --}}
                <div class="qr-sub">Katarungang Pambarangay App</div>
                <div id="qrcode" style="display:flex;justify-content:center;"></div>
                <div class="qr-instruction">
                    📱 Scan this QR code with your<br>phone camera to access the system
                </div>
            </div>
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-val">24/7</div>
                    <div class="stat-label">Online Access</div>
                </div>
                <div class="stat-item">
                    <div class="stat-val">KP</div>
                    <div class="stat-label">Process Ready</div>
                </div>
                <div class="stat-item">
                    <div class="stat-val">100%</div>
                    <div class="stat-label">Secure</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FEATURES --}}
<div class="features-section">
    <div style="max-width:1100px;margin:0 auto;">
        <div class="section-tag">Features</div>
        <h2 class="section-title">Everything you need in one place</h2>
        {{-- ✅ Updated description --}}
        <p class="section-desc">The Katarungang Pambarangay App brings the entire barangay complaint process online — from filing to resolution.</p>

        <div class="features-grid">
            @foreach([
                ['icon'=>'📥','bg'=>'#e8eef8','title'=>'Online Filing','desc'=>'Submit complaints anytime without visiting the barangay office. Just fill the form online.'],
                ['icon'=>'🔍','bg'=>'#e0f2fe','title'=>'Real-time Tracking','desc'=>'Track your complaint status using your reference number. Know exactly where your case is.'],
                ['icon'=>'📅','bg'=>'#ede9fe','title'=>'Hearing Scheduler','desc'=>'Get notified automatically when your mediation hearing is scheduled by the admin.'],
                ['icon'=>'📄','bg'=>'#d1fae5','title'=>'KP Forms Generated','desc'=>'Official KP Forms are automatically generated and printable for each stage of the process.'],
                ['icon'=>'🤝','bg'=>'#fef3c7','title'=>'Mediation Recording','desc'=>'Admin records mediation proceedings, outcomes, and settlement details digitally.'],
                ['icon'=>'🔒','bg'=>'#fee2e2','title'=>'Secure & Verified','desc'=>'Accounts are verified to ensure authentic complaint submissions from barangay residents.'],
            ] as $f)
            <div class="feature-card">
                <div class="feature-icon" style="background:{{ $f['bg'] }};">{{ $f['icon'] }}</div>
                <div class="feature-title">{{ $f['title'] }}</div>
                <div class="feature-desc">{{ $f['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- PROCESS --}}
<div class="process-section">
    <div style="max-width:1100px;margin:0 auto;">
        <div class="section-tag">How It Works</div>
        <h2 class="section-title">Simple 4-Step Process</h2>
        <p class="section-desc">Follow the Katarungang Pambarangay process digitally.</p>

        <div class="process-steps">
            @php
                $steps = [
                    ['n'=>'1','title'=>'File Complaint','desc'=>'Register and submit your complaint online with all necessary details.'],
                    ['n'=>'2','title'=>'Admin Review','desc'=>'Barangay admin validates and processes the complaint for mediation.'],
                    ['n'=>'3','title'=>'Mediation','desc'=>'Admin schedules a hearing. Both parties attend mediation proceedings.'],
                    ['n'=>'4','title'=>'Resolution','desc'=>'Case is settled with an official amicable settlement or escalated if needed.'],
                ];
            @endphp
            @foreach($steps as $i => $s)
            <div class="process-step">
                @if(!$loop->last)
                <div class="step-connector"></div>
                @endif
                <div class="step-num">{{ $s['n'] }}</div>
                <div class="step-title">{{ $s['title'] }}</div>
                <div class="step-desc">{{ $s['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- FOOTER --}}
<footer class="footer">
    {{-- ✅ Updated footer --}}
    <div class="footer-left">
        © {{ date('Y') }} Katarungang Pambarangay App — Barangay New Kababae, Olongapo City, Zambales. All rights reserved.
    </div>
    <div class="footer-right">
        <a href="{{ route('login') }}" class="footer-link">Sign In</a>
        <a href="{{ route('register') }}" class="footer-link">Register</a>
    </div>
</footer>

<script>
    var qr = new QRCode(document.getElementById("qrcode"), {
        text: "{{ url('/login') }}",
        width: 180,
        height: 180,
        colorDark: "#1e2d5e",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
</script>

</body>
</html>