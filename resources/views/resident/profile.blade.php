<x-app-layout>
    <x-slot name="title">My Profile</x-slot>
    <x-slot name="header">My Profile</x-slot>

    @php
        $user     = auth()->user();
        $total    = \App\Models\Complaint::where('user_id', $user->id)->count();
        $resolved = \App\Models\Complaint::where('user_id', $user->id)->where('status','resolved')->count();
        $pending  = \App\Models\Complaint::where('user_id', $user->id)->where('status','pending')->count();
        $initials = strtoupper(substr($user->name, 0, 2));
    @endphp

    {{-- Success --}}
    @if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div style="display:grid;grid-template-columns:280px 1fr;gap:20px;align-items:start;">

        {{-- Left — Avatar + Stats --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Profile Card --}}
            <div class="card" style="padding:24px;text-align:center;">
                {{-- Avatar --}}
                <div style="width:80px;height:80px;border-radius:50%;background:#1e2d5e;display:flex;align-items:center;justify-content:center;color:#fff;font-size:26px;font-weight:700;margin:0 auto 14px;border:3px solid #e8eef8;">
                    {{ $initials }}
                </div>
                <div style="font-size:17px;font-weight:700;color:#1e2d5e;margin-bottom:4px;">{{ $user->name }}</div>
                <div style="font-size:13px;color:#64748b;text-transform:capitalize;margin-bottom:14px;">
                    {{ $user->getRoleNames()->first() ?? 'resident' }}
                </div>

                {{-- Verified Badge --}}
                @if($user->email_verified_at)
                <span style="display:inline-flex;align-items:center;gap:5px;background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;border-radius:99px;padding:4px 12px;font-size:12px;font-weight:600;">
                    ✓ Verified Account
                </span>
                @else
                <span style="display:inline-flex;align-items:center;gap:5px;background:#fef3c7;color:#92400e;border:1px solid #fcd34d;border-radius:99px;padding:4px 12px;font-size:12px;font-weight:600;">
                    ⚠ Unverified
                </span>
                @endif

                {{-- Stats --}}
                <div style="border-top:1px solid #f1f5f9;margin-top:16px;padding-top:16px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:12px;">My Report Summary</div>
                    @foreach([
                        ['label'=>'Total Reports','val'=>$total,   'color'=>'#3554a0','bg'=>'#e8eef8'],
                        ['label'=>'Resolved',     'val'=>$resolved,'color'=>'#059669','bg'=>'#d1fae5'],
                        ['label'=>'Pending',      'val'=>$pending, 'color'=>'#d97706','bg'=>'#fef3c7'],
                    ] as $s)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 10px;border-radius:8px;background:{{ $s['bg'] }};margin-bottom:6px;">
                        <span style="font-size:13px;color:#475569;font-weight:500;">{{ $s['label'] }}</span>
                        <span style="font-size:17px;font-weight:700;color:{{ $s['color'] }};">{{ $s['val'] }}</span>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top:14px;font-size:12px;color:#94a3b8;">
                    Member since {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}
                </div>
            </div>

        </div>

        {{-- Right — Edit Forms --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Personal Information --}}
            <div class="card" style="overflow:hidden;">
                <div style="padding:16px 22px 13px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <svg width="16" height="16" fill="none" stroke="#3554a0" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div style="font-size:15px;font-weight:600;color:#1e2d5e;">Personal Information</div>
                </div>
                <div style="padding:22px;">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Full Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" required
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Email Address</label>
                                <input type="email" name="email" value="{{ $user->email }}" required
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Contact Number</label>
                                <input type="tel" name="contact" placeholder="09XX-XXX-XXXX"
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Role</label>
                                <input type="text" value="{{ ucfirst($user->getRoleNames()->first() ?? 'resident') }}" disabled
                                    style="width:100%;padding:10px 12px;border:1.5px solid #f1f5f9;border-radius:8px;font-size:14px;color:#94a3b8;background:#f8fafc;cursor:not-allowed;font-family:Inter,sans-serif;box-sizing:border-box;">
                            </div>
                        </div>

                        <div style="margin-bottom:20px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Home Address</label>
                            <input type="text" name="address" placeholder="Purok, Street, Barangay New Kababae"
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>

                        <button type="submit" class="btn-primary" style="width:auto;padding:10px 28px;">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="card" style="overflow:hidden;">
                <div style="padding:16px 22px 13px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <svg width="16" height="16" fill="none" stroke="#3554a0" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <div style="font-size:15px;font-weight:600;color:#1e2d5e;">Change Password</div>
                </div>
                <div style="padding:22px;">
                    <form method="POST" action="#">
                        @csrf
                        @method('PUT')
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px;">
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Current Password</label>
                                <input type="password" name="current_password" placeholder="Current password"
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">New Password</label>
                                <input type="password" name="password" placeholder="New password"
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Confirm Password</label>
                                <input type="password" name="password_confirmation" placeholder="Repeat new password"
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary" style="width:auto;padding:10px 28px;">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>