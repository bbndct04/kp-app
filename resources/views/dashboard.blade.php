<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">Dashboard</x-slot>

    @php $firstName = explode(' ', auth()->user()->name)[0]; @endphp

    {{-- Welcome Banner --}}
    <div style="background:#1e2d5e;border-radius:12px;padding:22px 26px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h2 style="font-size:18px;font-weight:700;color:#fff;margin-bottom:3px;">
                Welcome back, {{ $firstName }}! 👋
            </h2>
            <p style="color:rgba(255,255,255,.6);font-size:13px;">
                {{ now()->format('l, F j, Y') }}
            </p>
        </div>
        <a href="{{ route('complaints.create') }}" class="btn-primary"
            style="width:auto;padding:10px 22px;text-decoration:none;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);font-size:14px;border-radius:8px;">
            + New Report
        </a>
    </div>

    {{-- Stats Row --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
        @foreach([
            ['label'=>'Total Reports',  'val'=>$stats['total'],    'color'=>'#3554a0','bg'=>'#e8eef8','accent'=>'stat-card-blue'],
            ['label'=>'Pending',        'val'=>$stats['pending'],  'color'=>'#d97706','bg'=>'#fef3c7','accent'=>'stat-card-orange'],
            ['label'=>'In Progress',    'val'=>$stats['inprogress'],'color'=>'#0284c7','bg'=>'#e0f2fe','accent'=>'stat-card-sky'],
            ['label'=>'Resolved',       'val'=>$stats['resolved'], 'color'=>'#059669','bg'=>'#d1fae5','accent'=>'stat-card-green'],
        ] as $s)
        <div class="stat-card {{ $s['accent'] }}">
            <div style="font-size:30px;font-weight:700;color:{{ $s['color'] }};letter-spacing:-1px;margin-bottom:4px;">{{ $s['val'] }}</div>
            <div style="font-size:13px;color:#64748b;">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Main Grid --}}
    <div style="display:grid;grid-template-columns:1fr 290px;gap:18px;align-items:start;">

        {{-- Recent Reports --}}
        <div class="card" style="overflow:hidden;">
            <div style="padding:16px 20px 13px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:15px;font-weight:600;color:#1e2d5e;">Recent Reports</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:1px;">Your latest complaint submissions</div>
                </div>
                <a href="{{ route('my-reports') }}"
                    style="font-size:13px;color:#3554a0;font-weight:600;text-decoration:none;padding:5px 12px;border-radius:6px;border:1px solid #d1d9e6;background:#f5f7fa;">
                    View All →
                </a>
            </div>
            <div style="overflow-x:auto;">
                <table class="bl-table">
                    <thead><tr>
                        <th>Reference No.</th>
                        <th>Category</th>
                        <th>Date Filed</th>
                        <th>Status</th>
                        <th></th>
                    </tr></thead>
                    <tbody>
                        @forelse($recent as $c)
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
                        <tr>
                            <td style="font-weight:700;color:#3554a0;font-family:monospace;font-size:13px;">{{ $c->reference_number }}</td>
                            <td style="color:#475569;">{{ $c->category }}</td>
                            <td style="color:#94a3b8;font-size:13px;">{{ \Carbon\Carbon::parse($c->created_at)->format('M d, Y') }}</td>
                            <td>
                                <span style="background:{{ $b['bg'] }};color:{{ $b['color'] }};padding:3px 8px;border-radius:99px;font-size:12px;font-weight:600;">
                                    {{ $b['label'] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('track') }}?ref={{ $c->reference_number }}"
                                    style="font-size:12px;color:#3554a0;font-weight:600;text-decoration:none;">
                                    Track →
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:48px;color:#94a3b8;">
                                <div style="width:48px;height:48px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <div style="font-size:14px;font-weight:500;color:#475569;margin-bottom:4px;">No reports yet</div>
                                <div style="font-size:13px;margin-bottom:16px;">Submit your first complaint to get started</div>
                                <a href="{{ route('complaints.create') }}"
                                    style="display:inline-flex;align-items:center;gap:6px;background:#1e2d5e;color:#fff;border-radius:8px;padding:10px 20px;font-size:13px;font-weight:600;text-decoration:none;">
                                    + Submit Complaint
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column --}}
        <div style="display:flex;flex-direction:column;gap:14px;">

            {{-- File Complaint --}}
            <div style="background:#1e2d5e;border-radius:12px;padding:20px;border:1px solid #2d4080;">
                <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:6px;">📝 File a Complaint</div>
                <div style="font-size:13px;color:rgba(255,255,255,.55);margin-bottom:14px;line-height:1.5;">
                    Submit a new complaint or incident report online.
                </div>
                <a href="{{ route('complaints.create') }}"
                    style="display:block;text-align:center;background:rgba(255,255,255,.12);color:#fff;border:1.5px solid rgba(255,255,255,.2);border-radius:8px;padding:10px;font-size:14px;font-weight:600;text-decoration:none;">
                    + New Report
                </a>
            </div>

            {{-- Quick Track --}}
            <div class="card" style="padding:18px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:4px;">🔍 Quick Track</div>
                <div style="font-size:12px;color:#94a3b8;margin-bottom:10px;">Enter your reference number</div>
                <form method="GET" action="{{ route('track') }}" style="display:flex;gap:8px;">
                    <input type="text" name="ref" placeholder="BL-2026-XXX"
                        style="flex:1;background:#f5f7fa;border:1.5px solid #e5e9f0;border-radius:6px;padding:9px 10px;font-size:13px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;"
                        onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#e5e9f0'">
                    <button type="submit"
                        style="background:#1e2d5e;color:#fff;border:none;border-radius:6px;padding:9px 16px;font-size:13px;font-weight:600;cursor:pointer;font-family:Inter,sans-serif;">
                        Go
                    </button>
                </form>
            </div>

            {{-- Help --}}
            <div class="card" style="padding:18px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:8px;">ℹ️ Need Help?</div>
                <div style="font-size:12.5px;color:#64748b;line-height:1.6;">
                    Visit the barangay office at <strong style="color:#1e2d5e;">8AM–5PM</strong> Mon–Fri, or call your barangay hotline for urgent concerns.
                </div>
            </div>

        </div>
    </div>

</x-app-layout>