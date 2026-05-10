<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#1e2d5e">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    {{-- ✅ Updated PWA meta --}}
    <meta name="apple-mobile-web-app-title" content="KP App">
    <meta name="application-name" content="KP App">
    <meta name="msapplication-TileColor" content="#1e2d5e">
    <meta name="description" content="Katarungang Pambarangay App — Barangay New Kababae Official Complaint & Incident Reporting System">

    {{-- PWA Manifest --}}
    <link rel="manifest" href="/manifest.json">

    {{-- Apple Touch Icons --}}
    <link rel="apple-touch-icon" href="{{ asset('images/blotterlink-logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/blotterlink-logo.png') }}">

    {{-- ✅ Updated title --}}
    <title>KP App — {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:#f5f7fa;font-family:Inter,sans-serif;">

@php
    $role = auth()->user()->getRoleNames()->first() ?? 'resident';
    $unreadCount = $role === 'resident'
        ? \App\Models\ComplaintNotification::where('user_id', auth()->id())->where('is_read', false)->count()
        : 0;
@endphp

{{-- Sidebar Overlay (mobile) --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

<div style="display:flex;min-height:100vh;">

    {{-- ═══════ SIDEBAR ═══════ --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo --}}
        <div style="padding:16px 18px 14px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:12px;">
            <div style="width:36px;height:36px;border-radius:50%;overflow:hidden;border:2px solid rgba(255,255,255,.25);flex-shrink:0;">
                <img src="{{ asset('images/blotterlink-logo.png') }}" alt="KP App"
                    style="width:100%;height:100%;object-fit:cover;display:block;">
            </div>
            <div style="flex:1;">
                {{-- ✅ Sidebar shows KP App only --}}
                <div style="color:#fff;font-size:14px;font-weight:700;">KP App</div>
                <div style="color:rgba(255,255,255,.4);font-size:10px;letter-spacing:.5px;text-transform:uppercase;">Brgy. New Kababae</div>
            </div>
            {{-- Close button (mobile only) --}}
            <button onclick="closeSidebar()"
                style="background:none;border:none;color:rgba(255,255,255,.5);cursor:pointer;padding:4px;border-radius:6px;font-size:18px;line-height:1;"
                id="sidebar-close">✕</button>
        </div>

        {{-- Nav --}}
        <nav style="flex:1;padding:14px 12px;overflow-y:auto;">
            <div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.3);padding:8px 6px 6px;">Menu</div>

            @if($role === 'resident')
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('complaints.create') }}" class="nav-item {{ request()->routeIs('complaints.create') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Submit Complaint
                </a>
                <a href="{{ route('my-reports') }}" class="nav-item {{ request()->routeIs('my-reports') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    My Reports
                </a>
                <a href="{{ route('track') }}" class="nav-item {{ request()->routeIs('track') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Track Status
                </a>

                {{-- Notifications (resident only) --}}
                <a href="{{ route('notifications') }}" class="nav-item {{ request()->routeIs('notifications') ? 'active' : '' }}" onclick="closeSidebar()"
                    style="display:flex;align-items:center;gap:10px;">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Notifications
                    @if($unreadCount > 0)
                    <span style="margin-left:auto;background:#dc2626;color:#fff;font-size:10px;font-weight:700;padding:2px 7px;border-radius:99px;min-width:18px;text-align:center;">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                    @endif
                </a>

            @elseif(in_array($role, ['admin']))
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.complaints') }}" class="nav-item {{ request()->routeIs('admin.complaints') || request()->routeIs('admin.complaints.*') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    All Complaints
                </a>
                <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Manage Users
                </a>
                <a href="{{ route('admin.analytics') }}" class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" onclick="closeSidebar()">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Analytics
                </a>
            @endif

            <div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.3);padding:14px 6px 6px;">Account</div>
            <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}" onclick="closeSidebar()">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                My Profile
            </a>
        </nav>

        {{-- User + Logout --}}
        <div style="padding:12px;border-top:1px solid rgba(255,255,255,.08);">
            <div style="display:flex;align-items:center;gap:10px;padding:8px 10px;margin-bottom:4px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#4169b8;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="color:#fff;font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ auth()->user()->name }}
                    </div>
                    <div style="color:rgba(255,255,255,.4);font-size:11px;text-transform:capitalize;">{{ $role }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="display:flex;align-items:center;gap:10px;width:100%;padding:9px 12px;border-radius:8px;background:none;border:none;cursor:pointer;color:rgba(255,160,160,.75);font-size:13px;font-weight:500;font-family:Inter,sans-serif;"
                    onmouseover="this.style.background='rgba(185,28,28,.2)';this.style.color='#fca5a5'"
                    onmouseout="this.style.background='none';this.style.color='rgba(255,160,160,.75)'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════ MAIN CONTENT ═══════ --}}
    <div class="main-content" id="main-content" style="margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh;">

        {{-- TOPBAR --}}
        <header class="topbar">

            {{-- Hamburger (mobile) --}}
            <button class="hamburger" id="hamburger" onclick="openSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div>
                <div style="font-size:18px;font-weight:700;color:#1e2d5e;letter-spacing:-.3px;">
                    {{ $header ?? 'Dashboard' }}
                </div>
            </div>
            <div style="flex:1;"></div>

            {{-- Search (hidden on mobile) --}}
            <div class="topbar-search" style="display:flex;align-items:center;gap:8px;background:#f5f7fa;border:1.5px solid #e5e9f0;border-radius:8px;padding:7px 14px;width:240px;">
                <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" placeholder="Search..."
                    style="border:none;background:none;font-size:13px;color:#1e2d5e;outline:none;width:100%;font-family:Inter,sans-serif;">
            </div>

            {{-- Bell --}}
            @if($role === 'resident')
            <a href="{{ route('notifications') }}"
                class="topbar-bell"
                style="width:38px;height:38px;border-radius:8px;background:#f5f7fa;border:1.5px solid #e5e9f0;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;text-decoration:none;flex-shrink:0;">
                <svg width="17" height="17" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                @if($unreadCount > 0)
                <div style="position:absolute;top:-5px;right:-5px;min-width:18px;height:18px;background:#dc2626;border-radius:99px;border:2px solid #fff;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;padding:0 3px;">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </div>
                @else
                <div style="position:absolute;top:7px;right:7px;width:7px;height:7px;background:#3554a0;border-radius:50%;border:1.5px solid #fff;"></div>
                @endif
            </a>
            @else
            <div class="topbar-bell" style="width:38px;height:38px;border-radius:8px;background:#f5f7fa;border:1.5px solid #e5e9f0;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;flex-shrink:0;">
                <svg width="17" height="17" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>
            @endif

            {{-- User --}}
            <div style="display:flex;align-items:center;gap:10px;padding:5px 10px 5px 5px;border-radius:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#1e2d5e;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-name">
                    <div style="font-size:13.5px;font-weight:600;color:#1e2d5e;">{{ auth()->user()->name }}</div>
                    <div style="font-size:11px;color:#94a3b8;text-transform:capitalize;">{{ $role }}</div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main style="padding:28px;flex:1;">
            {{ $slot }}
        </main>
    </div>
</div>

<script>
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('active');
    document.getElementById('sidebar-close').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('active');
    document.getElementById('sidebar-close').style.display = 'none';
    document.body.style.overflow = '';
}

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('SW registered:', reg.scope))
            .catch(err => console.log('SW error:', err));
    });
}

let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    showInstallBanner();
});

function showInstallBanner() {
    const banner = document.createElement('div');
    banner.id = 'pwa-banner';
    banner.innerHTML = `
        <div style="position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:#1e2d5e;color:#fff;border-radius:12px;padding:14px 20px;display:flex;align-items:center;gap:14px;z-index:9999;box-shadow:0 8px 30px rgba(0,0,0,.3);max-width:340px;width:calc(100% - 40px);">
            <img src="{{ asset('images/blotterlink-logo.png') }}" style="width:36px;height:36px;border-radius:50%;">
            <div style="flex:1;">
                {{-- ✅ Updated PWA banner text --}}
                <div style="font-size:13px;font-weight:700;">Install KP App</div>
                <div style="font-size:12px;color:rgba(255,255,255,.6);">Add to Home Screen for quick access</div>
            </div>
            <div style="display:flex;gap:8px;">
                <button onclick="installPWA()" style="background:#fff;color:#1e2d5e;border:none;border-radius:6px;padding:7px 14px;font-size:13px;font-weight:700;cursor:pointer;font-family:Inter,sans-serif;">Install</button>
                <button onclick="dismissBanner()" style="background:rgba(255,255,255,.1);color:#fff;border:none;border-radius:6px;padding:7px 10px;font-size:13px;cursor:pointer;font-family:Inter,sans-serif;">✕</button>
            </div>
        </div>
    `;
    document.body.appendChild(banner);
}

function installPWA() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then(() => {
            deferredPrompt = null;
            dismissBanner();
        });
    }
}

function dismissBanner() {
    const b = document.getElementById('pwa-banner');
    if (b) b.remove();
}
</script>

</body>
</html>