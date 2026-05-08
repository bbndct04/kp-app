<x-app-layout>
    <x-slot name="title">My Reports</x-slot>
    <x-slot name="header">My Reports</x-slot>

    @if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <p style="font-size:13.5px;color:#64748b;">All your submitted complaints and their current status</p>
        <a href="{{ route('complaints.create') }}" class="btn-primary" style="width:auto;padding:9px 20px;text-decoration:none;font-size:14px;border-radius:8px;">
            + New Report
        </a>
    </div>

    {{-- Filter Tabs --}}
    @php
        $filters = [
            'all'        => ['label'=>'All',          'count'=>$complaints->count()],
            'pending'    => ['label'=>'Pending',      'count'=>$complaints->where('status','pending')->count()],
            'for_review' => ['label'=>'For Review',   'count'=>$complaints->where('status','for_review')->count()],
            'scheduled'  => ['label'=>'Scheduled',    'count'=>$complaints->whereIn('status',['approved','scheduled','ongoing'])->count()],
            'resolved'   => ['label'=>'Resolved',     'count'=>$complaints->where('status','resolved')->count()],
            'escalated'  => ['label'=>'Escalated',    'count'=>$complaints->whereIn('status',['escalated','rejected'])->count()],
            'closed'     => ['label'=>'Closed',       'count'=>$complaints->where('status','closed')->count()],
        ];
        $activeFilter = request('filter','all');
    @endphp

    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:18px;">
        @foreach($filters as $key => $f)
        <a href="{{ route('my-reports') }}?filter={{ $key }}"
            style="padding:6px 14px;border-radius:99px;font-size:13px;font-weight:500;text-decoration:none;border:1.5px solid {{ $activeFilter===$key ? '#1e2d5e' : '#d1d9e6' }};background:{{ $activeFilter===$key ? '#1e2d5e' : '#fff' }};color:{{ $activeFilter===$key ? '#fff' : '#64748b' }};">
            {{ $f['label'] }}
            @if($f['count'] > 0)
            <span style="font-size:11px;font-weight:700;opacity:.8;">({{ $f['count'] }})</span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table class="bl-table">
                <thead><tr>
                    <th>Reference No.</th>
                    <th>Category</th>
                    <th>Incident Date</th>
                    <th>Filed</th>
                    <th>Status</th>
                    <th>Hearing Date</th>
                    <th>Actions</th>
                </tr></thead>
                <tbody>
                    @php
                        $filtered = $activeFilter === 'all' ? $complaints :
                            ($activeFilter === 'scheduled' ? $complaints->whereIn('status',['approved','scheduled','ongoing']) :
                            ($activeFilter === 'escalated' ? $complaints->whereIn('status',['escalated','rejected']) :
                            $complaints->where('status', $activeFilter)));
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
                    @endphp
                    @forelse($filtered as $c)
                    @php $b = $badges[$c->status] ?? $badges['pending']; @endphp
                    <tr>
                        <td style="font-weight:700;color:#3554a0;font-family:monospace;font-size:13px;">{{ $c->reference_number }}</td>
                        <td style="color:#475569;">{{ $c->category }}</td>
                        <td style="color:#64748b;font-size:13px;">{{ \Carbon\Carbon::parse($c->incident_date)->format('M d, Y') }}</td>
                        <td style="color:#94a3b8;font-size:13px;">{{ \Carbon\Carbon::parse($c->created_at)->format('M d, Y') }}</td>
                        <td>
                            <span style="background:{{ $b['bg'] }};color:{{ $b['color'] }};padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">
                                {{ $b['label'] }}
                            </span>
                        </td>
                        <td style="font-size:13px;color:#1e2d5e;font-weight:{{ $c->hearing_date ? '600' : '400' }};">
                            {{ $c->hearing_date ? \Carbon\Carbon::parse($c->hearing_date)->format('M d, Y') : '—' }}
                        </td>
                        <td>
                            <a href="{{ route('track') }}?ref={{ $c->reference_number }}"
                                style="font-size:12px;font-weight:600;color:#3554a0;text-decoration:none;padding:4px 10px;border-radius:6px;border:1px solid #d1d9e6;background:#f5f7fa;">
                                Track
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:52px;color:#94a3b8;">
                            <div style="width:48px;height:48px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="font-size:14px;font-weight:500;color:#475569;margin-bottom:4px;">No reports found</div>
                            <div style="font-size:13px;">
                                @if($activeFilter !== 'all') No complaints with this status yet.
                                @else You haven't submitted any complaints yet.
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>