<x-app-layout>
    <x-slot name="title">Manage Users</x-slot>
    <x-slot name="header">Manage Users</x-slot>

    @if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #fca5a5;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <p style="font-size:13.5px;color:#64748b;">Manage roles, verification, and access control</p>
    </div>

    {{-- Search + Filter --}}
    <div class="card" style="padding:16px 20px;margin-bottom:20px;">
        <form method="GET" action="{{ route('admin.users') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by name or email..."
                style="flex:1;min-width:220px;background:#f5f7fa;border:1.5px solid #e5e9f0;border-radius:8px;padding:9px 14px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;"
                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#e5e9f0'">
            <select name="role"
                style="background:#f5f7fa;border:1.5px solid #e5e9f0;border-radius:8px;padding:9px 14px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;cursor:pointer;">
                <option value="all">All Roles</option>
                <option value="resident" {{ request('role')==='resident'?'selected':'' }}>Residents</option>
                <option value="staff"    {{ request('role')==='staff'?'selected':'' }}>Staff</option>
                <option value="admin"    {{ request('role')==='admin'?'selected':'' }}>Admins</option>
            </select>
            <button type="submit" class="btn-primary" style="width:auto;padding:9px 22px;border-radius:8px;">Search</button>
            @if(request('search') || request('role'))
            <a href="{{ route('admin.users') }}" class="btn-outline" style="padding:9px 16px;text-decoration:none;">Clear</a>
            @endif
        </form>
    </div>

    {{-- Users Table --}}
    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table class="bl-table">
                <thead><tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Verified</th>
                    <th>Complaints</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;border-radius:50%;background:#1e2d5e;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($u->name,0,2)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;color:#1e2d5e;font-size:14px;">{{ $u->name }}</div>
                                    @if($u->id === auth()->id())
                                    <div style="font-size:11px;color:#94a3b8;">(You)</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="color:#64748b;font-size:13.5px;">{{ $u->email }}</td>
                        <td>
                            @if($u->hasRole('admin'))
                                <span style="background:#ede9fe;color:#5b21b6;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">Admin</span>
                            @elseif($u->hasRole('staff'))
                                <span style="background:#dbeafe;color:#1e40af;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">Staff</span>
                            @else
                                <span style="background:#d1fae5;color:#065f46;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">Resident</span>
                            @endif
                        </td>
                        <td>
                            @if($u->email_verified_at)
                                <span style="background:#d1fae5;color:#065f46;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">✓ Verified</span>
                            @else
                                <span style="background:#fef3c7;color:#92400e;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">Unverified</span>
                            @endif
                        </td>
                        <td style="font-weight:600;color:#3554a0;font-size:14px;">
                            {{ \App\Models\Complaint::where('user_id',$u->id)->count() }}
                        </td>
                        <td style="color:#94a3b8;font-size:13px;">
                            {{ \Carbon\Carbon::parse($u->created_at)->format('M d, Y') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                @if($u->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.role', $u) }}" style="display:inline;">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()"
                                        style="background:#f5f7fa;border:1px solid #d1d9e6;border-radius:6px;padding:5px 8px;font-size:12px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;cursor:pointer;">
                                        <option value="resident" {{ $u->hasRole('resident')?'selected':'' }}>Resident</option>
                                        <option value="staff"    {{ $u->hasRole('staff')   ?'selected':'' }}>Staff</option>
                                        <option value="admin"    {{ $u->hasRole('admin')   ?'selected':'' }}>Admin</option>
                                    </select>
                                </form>
                                @endif

                                <form method="POST" action="{{ route('admin.users.verify', $u) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        style="background:{{ $u->email_verified_at ? '#fef3c7' : '#d1fae5' }};color:{{ $u->email_verified_at ? '#92400e' : '#065f46' }};border:1px solid {{ $u->email_verified_at ? '#fcd34d' : '#6ee7b7' }};border-radius:6px;padding:5px 10px;font-size:12px;font-weight:600;cursor:pointer;font-family:Inter,sans-serif;">
                                        {{ $u->email_verified_at ? 'Unverify' : 'Verify' }}
                                    </button>
                                </form>

                                @if($u->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.delete', $u) }}" style="display:inline;"
                                    onsubmit="return confirm('Remove {{ addslashes($u->name) }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;border-radius:6px;padding:5px 10px;font-size:12px;font-weight:600;cursor:pointer;font-family:Inter,sans-serif;">
                                        Remove
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:52px;color:#94a3b8;">
                        <div style="font-size:14px;font-weight:500;color:#475569;">No users found</div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
            <div style="font-size:13px;color:#64748b;">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
            </div>
            <div style="display:flex;gap:6px;">
                @if($users->onFirstPage())
                    <span class="page-btn disabled">← Prev</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="page-btn">← Prev</a>
                @endif
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="page-btn">Next →</a>
                @else
                    <span class="page-btn disabled">Next →</span>
                @endif
            </div>
        </div>
        @endif
    </div>

</x-app-layout>