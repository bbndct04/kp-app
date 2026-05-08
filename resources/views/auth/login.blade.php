<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    {{-- Title --}}
    <div style="margin-bottom:28px;">
        <h2 style="font-size:26px;font-weight:700;color:#0e1e5b;letter-spacing:-.4px;margin-bottom:6px;">
            Welcome back
        </h2>
        <p style="font-size:14.5px;color:#5e6882;">
            Sign in to your BlotterLink account
        </p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div style="background:#dcf5eb;color:#0d7a4e;padding:12px 14px;border-radius:8px;font-size:13.5px;margin-bottom:16px;display:flex;gap:8px;align-items:center;">
            <span>✓</span> {{ session('status') }}
        </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
        <div style="background:#fee2e2;color:#b91c1c;padding:12px 14px;border-radius:8px;font-size:13.5px;margin-bottom:16px;display:flex;gap:8px;align-items:center;">
            <span>✕</span> {{ $errors->first() }}
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div style="margin-bottom:18px;">
            <label class="form-label" for="email">Email Address</label>
            <input class="form-input" type="email" id="email" name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required autofocus autocomplete="username">
        </div>

        {{-- Password --}}
        <div style="margin-bottom:8px;">
            <label class="form-label" for="password">Password</label>
            <input class="form-input" type="password" id="password" name="password"
                placeholder="Enter your password"
                required autocomplete="current-password">
        </div>

        {{-- Forgot Password --}}
        <div style="text-align:right;margin-bottom:20px;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    style="font-size:13px;color:var(--blue-600);font-weight:600;text-decoration:none;">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Remember Me --}}
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
            <input type="checkbox" id="remember_me" name="remember"
                style="width:16px;height:16px;cursor:pointer;accent-color:var(--blue-600)">
            <label for="remember_me"
                style="font-size:13.5px;color:#5e6882;cursor:pointer;">
                Remember me
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary">
            Sign In
        </button>

    </form>

    {{-- Register Link --}}
    <div style="text-align:center;margin-top:20px;font-size:14px;color:#5e6882;">
        Don't have an account?
        <a href="{{ route('register') }}"
            style="color:var(--blue-600);font-weight:600;text-decoration:none;margin-left:4px;">
            Register here
        </a>
    </div>

    {{-- Divider --}}
    <div style="display:flex;align-items:center;gap:12px;margin:24px 0 14px;">
        <div style="flex:1;height:1px;background:#e0e4ee;"></div>
        <span style="font-size:12px;color:#a0aab8;font-weight:500;">Quick Login</span>
        <div style="flex:1;height:1px;background:#e0e4ee;"></div>
    </div>

    {{-- Login as label --}}
    <div style="font-size:14px;font-weight:700;color:#1e2130;margin-bottom:10px;">
        Login as:
    </div>

    {{-- Role Pills --}}
    <div style="display:flex;gap:8px;">
        <button type="button"
            id="pill-resident"
            onclick="selectRole('resident','resident@test.com')"
            style="padding:9px 22px;border-radius:99px;font-size:14px;font-weight:600;cursor:pointer;border:1.5px solid #1a5fd4;background:linear-gradient(135deg,#1a5fd4,#1247b8);color:#fff;font-family:Inter,sans-serif;box-shadow:0 4px 14px rgba(26,95,212,.3);transition:all .2s;">
            Resident
        </button>
       
        <button type="button"
            id="pill-admin"
            onclick="selectRole('admin','admin@test.com')"
            style="padding:9px 22px;border-radius:99px;font-size:14px;font-weight:600;cursor:pointer;border:1.5px solid #d4daea;background:#f5f6fa;color:#a0aab8;font-family:Inter,sans-serif;transition:all .2s;">
            Admin
        </button>
    </div>

    <script>
    function selectRole(role, email) {
        // Reset all pills
        ['resident','admin'].forEach(r => {
            const btn = document.getElementById('pill-' + r);
            btn.style.background = '#f5f6fa';
            btn.style.color = '#a0aab8';
            btn.style.borderColor = '#d4daea';
            btn.style.boxShadow = 'none';
        });
        // Activate selected pill
        const active = document.getElementById('pill-' + role);
        active.style.background = 'linear-gradient(135deg, #1a5fd4, #1247b8)';
        active.style.color = '#fff';
        active.style.borderColor = '#1a5fd4';
        active.style.boxShadow = '0 4px 14px rgba(26,95,212,.3)';
        // Fill email
        document.getElementById('email').value = email;
        document.getElementById('password').value = '123456';
    }
    </script>

</x-guest-layout>