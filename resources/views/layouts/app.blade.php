<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BlotterLink — {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- AOS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
</head>
<body class="bg-blotter font-sans antialiased" x-data="{ sidebarOpen: true }">

<div class="flex min-h-screen">

    {{-- ═══════════════════════════════
         SIDEBAR
    ═══════════════════════════════ --}}
    <aside class="sidebar glass-sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        style="transition: transform .3s ease;">

        {{-- Logo --}}
        <div style="padding:20px 16px 16px;border-bottom:1px solid rgba(255,255,255,.07);display:flex;align-items:center;gap:12px;">
            <svg width="38" height="42" viewBox="0 0 200 220" fill="none">
                <path d="M100 8 L182 42 L182 110 C182 158 144 196 100 212 C56 196 18 158 18 110 L18 42 Z"
                    fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                <path d="M100 26 L166 54 L166 110 C166 149 136 181 100 195 C64 181 34 149 34 110 L34 54 Z"
                    fill="rgba(255,255,255,0.10)"/>
                <g transform="translate(100,108) rotate(-35)">
                    <rect x="-8" y="-38" width="16" height="32" rx="3" fill="rgba(255,255,255,0.9)"/>
                    <rect x="-8" y="-46" width="16" height="12" rx="3" fill="rgba(255,255,255,0.55)"/>
                    <line x1="0" y1="-6" x2="0" y2="12" stroke="rgba(14,30,91,0.4)" stroke-width="1.5"/>
                    <circle cx="0" cy="14" r="2.5" fill="rgba(14,30,91,0.5)"/>
                </g>
            </svg>
            <div>
                <div style="color:#fff;font-size:15px;font-weight:700;line-height:1.2;">BlotterLink</div>
                <div style="color:rgba(255,255,255,.4);font-size:10.5px;letter-spacing:.5px;text-transform:uppercase;">Brgy. System</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav style="flex:1;padding:14px 10px;overflow-y:auto;">

            <div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.25);padding:12px 8px 6px;">
                Menu
            </div>

            @php $role = auth()->user()->getRoleNames()->first() ?? 'resident'; @endphp

            @if($role === 'resident')
                <a href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('complaints.create') }}" class="nav-item {{ request()->routeIs('complaints.create') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Submit Complaint
                </a>
                <a href="#" class="nav-item {{ request()->routeIs('my-reports') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    My Reports
                </a>
                <a href="#" class="nav-item {{ request()->routeIs('track') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Track Status
                </a>

            @elseif($role === 'staff')
                <a href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    All Complaints
                </a>

            @elseif($role === 'admin')
                <a href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    All Complaints
                </a>
                <a href="#" class="nav-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Manage Users
                </a>
                <a href="#" class="nav-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Analytics
                </a>
            @endif

            {{-- Profile (all roles) --}}
            <div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.25);padding:16px 8px 6px;">
                Account
            </div>
            <a href="#" class="nav-item">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                My Profile
            </a>

        </nav>

        {{-- User + Logout --}}
        <div style="padding:12px 10px;border-top:1px solid rgba(255,255,255,.07);">
            <div style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;margin-bottom:4px;">
                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue-500),var(--blue-700));display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="color:#fff;font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ auth()->user()->name }}
                    </div>
                    <div style="color:rgba(255,255,255,.4);font-size:11px;text-transform:capitalize;">
                        {{ auth()->user()->getRoleNames()->first() ?? 'resident' }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="display:flex;align-items:center;gap:10px;width:100%;padding:9px 12px;border-radius:8px;background:none;border:none;cursor:pointer;color:rgba(255,120,120,.75);font-size:13.5px;font-weight:500;font-family:Inter,sans-serif;transition:all .2s;"
                    onmouseover="this.style.background='rgba(185,28,28,.15)';this.style.color='#ff9090'"
                    onmouseout="this.style.background='none';this.style.color='rgba(255,120,120,.75)'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ═══════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════ --}}
    <div class="main-content flex flex-col" style="flex:1;">

        {{-- TOPBAR --}}
        <header class="topbar glass-dark"
            style="position:sticky;top:0;z-index:50;border-bottom:1px solid rgba(255,255,255,.07);">

            {{-- Toggle Sidebar --}}
            <button @click="sidebarOpen = !sidebarOpen"
                style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,.6);padding:6px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            {{-- Page Title --}}
            <div>
                <div style="font-size:17px;font-weight:700;color:#fff;letter-spacing:-.3px;">
                    {{ $header ?? 'Dashboard' }}
                </div>
            </div>

            <div style="flex:1;"></div>

            {{-- Search --}}
            <div style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);border-radius:8px;padding:7px 12px;width:220px;">
                <svg width="14" height="14" fill="none" stroke="rgba(255,255,255,.45)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" placeholder="Search..."
                    style="border:none;background:none;font-size:13px;color:#fff;outline:none;width:100%;"
                    placeholder="Search...">
            </div>

            {{-- Notification Bell --}}
            <div style="position:relative;cursor:pointer;">
                <div style="width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <div style="position:absolute;top:6px;right:6px;width:7px;height:7px;background:var(--blue-500);border-radius:50%;border:1.5px solid transparent;"></div>
            </div>

            {{-- User Avatar --}}
            <div style="display:flex;align-items:center;gap:8px;padding:5px 10px 5px 5px;border-radius:10px;cursor:pointer;border:1px solid transparent;"
                onmouseover="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(255,255,255,.1)'"
                onmouseout="this.style.background='none';this.style.borderColor='transparent'">
                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue-500),var(--blue-700));display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:13.5px;font-weight:600;color:#fff;">{{ auth()->user()->name }}</div>
                    <div style="font-size:11px;color:rgba(255,255,255,.45);text-transform:capitalize;">{{ auth()->user()->getRoleNames()->first() ?? 'resident' }}</div>
                </div>
            </div>

        </header>

        {{-- Page Content --}}
        <main style="padding:28px;flex:1;">
            {{ $slot }}
        </main>

    </div>
</div>

{{-- GSAP + AOS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 500, once: true, offset: 50 });
    gsap.from('.sidebar', { duration: .6, x: -20, opacity: 0, ease: 'power2.out' });
    gsap.from('.topbar', { duration: .5, y: -10, opacity: 0, ease: 'power2.out', delay: .2 });
    gsap.from('main > *', { duration: .5, y: 20, opacity: 0, stagger: .08, ease: 'power2.out', delay: .3 });
</script>

</body>
</html>