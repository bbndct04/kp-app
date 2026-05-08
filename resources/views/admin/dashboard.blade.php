<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="header">Admin Dashboard</x-slot>

    @if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <p style="font-size:13.5px;color:#64748b;margin-top:2px;">{{ now()->format('l, F j, Y') }}</p>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('admin.complaints') }}" class="btn-primary" style="width:auto;padding:9px 20px;font-size:13.5px;border-radius:8px;text-decoration:none;">
                Manage Complaints
            </a>
            <a href="{{ route('admin.users') }}" class="btn-outline" style="padding:9px 20px;font-size:13.5px;border-radius:8px;text-decoration:none;">
                Manage Users
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
        @php
            $statCards = [
                ['label'=>'Total Complaints','val'=>$stats['total'],   'accent'=>'stat-card-blue',  'icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z','icolor'=>'#3554a0','ibg'=>'#e8eef8'],
                ['label'=>'Pending',         'val'=>$stats['pending'], 'accent'=>'stat-card-orange','icon'=>'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z',                                                                                       'icolor'=>'#d97706','ibg'=>'#fef3c7'],
                ['label'=>'For Review',      'val'=>$stats['review'],  'accent'=>'stat-card-sky',   'icon'=>'M21 21l-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z',                                                                                      'icolor'=>'#0284c7','ibg'=>'#e0f2fe'],
                ['label'=>'Resolved',        'val'=>$stats['resolved'],'accent'=>'stat-card-green', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z',                                                                                   'icolor'=>'#059669','ibg'=>'#d1fae5'],
            ];
        @endphp

        @foreach($statCards as $s)
        <div class="stat-card {{ $s['accent'] }}" style="transition:all .2s;cursor:default;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <div style="width:40px;height:40px;border-radius:10px;background:{{ $s['ibg'] }};display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="{{ $s['icolor'] }}" stroke-width="1.8" viewBox="0 0 24 24"><path d="{{ $s['icon'] }}"/></svg>
                </div>
            </div>
            <div style="font-size:32px;font-weight:700;color:#1e2d5e;letter-spacing:-1px;line-height:1;margin-bottom:4px;">
                {{ $s['val'] }}
            </div>
            <div style="font-size:13px;color:#64748b;font-weight:500;">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Main Grid --}}
    <div style="display:grid;grid-template-columns:1fr 290px;gap:20px;">

        {{-- Recent Complaints --}}
        <div class="card" style="overflow:hidden;">
            <div style="padding:16px 20px 13px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:15px;font-weight:600;color:#1e2d5e;">Recent Complaints</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:1px;">Latest submissions requiring action</div>
                </div>
                <a href="{{ route('admin.complaints') }}"
                    style="font-size:13px;color:#3554a0;font-weight:600;text-decoration:none;padding:5px 12px;border-radius:6px;border:1px solid #d1d9e6;background:#f5f7fa;"
                    onmouseover="this.style.borderColor='#3554a0';this.style.background='#e8eef8'"
                    onmouseout="this.style.borderColor='#d1d9e6';this.style.background='#f5f7fa'">
                    View All →
                </a>
            </div>
            <div style="overflow-x:auto;">
                <table class="bl-table">
                    <thead><tr>
                        <th>Ref. No.</th><th>Resident</th><th>Category</th><th>Filed</th><th>Status</th><th></th>
                    </tr></thead>
                    <tbody>
                        @forelse($recent as $c)
                        <tr>
                            <td style="font-weight:700;color:#3554a0;font-family:monospace;font-size:13px;">{{ $c->reference_number }}</td>
                            <td style="font-weight:500;color:#1e2d5e;">{{ $c->user->name ?? '—' }}</td>
                            <td style="color:#475569;">{{ $c->category }}</td>
                            <td style="color:#94a3b8;font-size:13px;">{{ \Carbon\Carbon::parse($c->created_at)->format('M d, Y') }}</td>
                            <td>
                                @php
                                    $badges = [
                                        'pending'    => ['bg'=>'#fef3c7','color'=>'#92400e','label'=>'Pending'],
                                        'for_review' => ['bg'=>'#e0f2fe','color'=>'#0369a1','label'=>'For Review'],
                                        'approved'   => ['bg'=>'#dbeafe','color'=>'#1e40af','label'=>'Approved'],
                                        'rejected'   => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Rejected'],
                                        'scheduled'  => ['bg'=>'#ede9fe','color'=>'#5b21b6','label'=>'Scheduled'],
                                        'ongoing'    => ['bg'=>'#fef9c3','color'=>'#713f12','label'=>'Ongoing'],
                                        'resolved'   => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'Resolved'],
                                        'escalated'  => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'Escalated'],
                                        'closed'     => ['bg'=>'#f1f5f9','color'=>'#475569','label'=>'Closed'],
                                    ];
                                    $b = $badges[$c->status] ?? $badges['pending'];
                                @endphp
                                <span style="background:{{ $b['bg'] }};color:{{ $b['color'] }};padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">
                                    {{ $b['label'] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.complaints') }}?search={{ $c->reference_number }}"
                                    style="font-size:12px;font-weight:600;color:#3554a0;text-decoration:none;padding:4px 10px;border-radius:6px;border:1px solid #d1d9e6;background:#f5f7fa;">
                                    Manage
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" style="text-align:center;padding:48px;color:#94a3b8;">
                            <div style="font-size:32px;margin-bottom:8px;">📋</div>
                            <div style="font-size:14px;">No complaints yet</div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- System Users --}}
            <div class="card" style="padding:18px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <svg width="16" height="16" fill="none" stroke="#3554a0" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    System Users
                </div>
                @foreach([
                    ['label'=>'Total Users','val'=>$stats['total_users'],'color'=>'#3554a0','bg'=>'#e8eef8'],
                    ['label'=>'Residents',  'val'=>$stats['residents'],  'color'=>'#059669','bg'=>'#d1fae5'],
                    ['label'=>'Staff',      'val'=>$stats['staff'],      'color'=>'#d97706','bg'=>'#fef3c7'],
                ] as $s)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 12px;border-radius:8px;background:{{ $s['bg'] }};margin-bottom:7px;">
                    <span style="font-size:13px;color:#475569;font-weight:500;">{{ $s['label'] }}</span>
                    <span style="font-size:18px;font-weight:700;color:{{ $s['color'] }};">{{ $s['val'] }}</span>
                </div>
                @endforeach
                <a href="{{ route('admin.users') }}"
                    style="display:block;text-align:center;margin-top:12px;background:#1e2d5e;color:#fff;border-radius:8px;padding:9px;font-size:13px;font-weight:600;text-decoration:none;">
                    Manage Users →
                </a>
            </div>

            {{-- Top Categories --}}
            <div class="card" style="padding:18px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <svg width="16" height="16" fill="none" stroke="#3554a0" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Top Categories
                </div>
                @forelse($categories->take(5) as $cat)
                @php $pct = $stats['total'] > 0 ? round($cat->total / $stats['total'] * 100) : 0; @endphp
                <div style="margin-bottom:12px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                        <span style="font-size:12.5px;color:#475569;">{{ $cat->category }}</span>
                        <span style="font-size:12px;font-weight:700;color:#3554a0;">{{ $cat->total }}</span>
                    </div>
                    <div style="height:5px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                        <div style="height:100%;width:{{ $pct }}%;background:#1e2d5e;border-radius:99px;"></div>
                    </div>
                </div>
                @empty
                <div style="font-size:13px;color:#94a3b8;text-align:center;padding:12px;">No data yet</div>
                @endforelse
                <a href="{{ route('admin.analytics') }}"
                    style="display:block;text-align:center;margin-top:8px;background:#f5f7fa;color:#3554a0;border:1px solid #d1d9e6;border-radius:8px;padding:8px;font-size:13px;font-weight:600;text-decoration:none;">
                    View Analytics →
                </a>
            </div>

        </div>
    </div>

</x-app-layout>