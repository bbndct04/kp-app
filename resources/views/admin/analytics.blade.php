<x-app-layout>
    <x-slot name="title">Analytics</x-slot>
    <x-slot name="header">Reports & Analytics</x-slot>

    @php
        $total    = $stats['total'] ?: 1;
        $months   = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $maxMonth = $monthly->max('total') ?: 1;
        $resRate  = $stats['total'] > 0 ? round($stats['resolved'] / $stats['total'] * 100) : 0;
    @endphp

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <p style="font-size:13.5px;color:#64748b;">System statistics and complaint insights</p>
        <button onclick="window.print()"
            style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#1e2d5e;border:1.5px solid #d1d9e6;border-radius:8px;padding:9px 20px;font-size:14px;font-weight:600;cursor:pointer;font-family:Inter,sans-serif;"
            onmouseover="this.style.borderColor='#3554a0'" onmouseout="this.style.borderColor='#d1d9e6'">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Export Report
        </button>
    </div>

    {{-- Summary Cards --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
        @foreach([
            ['label'=>'Total Complaints','val'=>$stats['total'],   'color'=>'#3554a0','accent'=>'stat-card-blue'],
            ['label'=>'Resolved',        'val'=>$stats['resolved'],'color'=>'#059669','accent'=>'stat-card-green'],
            ['label'=>'Pending',         'val'=>$stats['pending'], 'color'=>'#d97706','accent'=>'stat-card-orange'],
            ['label'=>'Resolution Rate', 'val'=>$resRate.'%',      'color'=>'#5b21b6','accent'=>'stat-card-purple'],
        ] as $s)
        <div class="stat-card {{ $s['accent'] }}">
            <div style="font-size:32px;font-weight:700;color:{{ $s['color'] }};letter-spacing:-1px;margin-bottom:4px;">{{ $s['val'] }}</div>
            <div style="font-size:13px;color:#64748b;">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Charts Row --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

        {{-- Status Distribution --}}
        <div class="card" style="padding:22px;">
            <div style="font-size:15px;font-weight:600;color:#1e2d5e;margin-bottom:18px;">Status Distribution</div>
            @foreach([
                ['label'=>'Pending',    'val'=>$stats['pending'],  'color'=>'#d97706','pct'=>round($stats['pending']/$total*100)],
                ['label'=>'For Review', 'val'=>$stats['review'],   'color'=>'#0284c7','pct'=>round($stats['review']/$total*100)],
                ['label'=>'Resolved',   'val'=>$stats['resolved'], 'color'=>'#059669','pct'=>round($stats['resolved']/$total*100)],
                ['label'=>'Rejected',   'val'=>$stats['rejected'], 'color'=>'#dc2626','pct'=>round($stats['rejected']/$total*100)],
            ] as $s)
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;align-items:center;">
                    <span style="font-size:13px;color:#475569;font-weight:500;">{{ $s['label'] }}</span>
                    <span style="font-size:13px;font-weight:700;color:{{ $s['color'] }};">{{ $s['val'] }} ({{ $s['pct'] }}%)</span>
                </div>
                <div style="height:7px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ $s['pct'] }}%;background:{{ $s['color'] }};border-radius:99px;"></div>
                </div>
            </div>
            @endforeach

            <div style="border-top:1px solid #f1f5f9;padding-top:14px;margin-top:4px;display:flex;gap:16px;">
                <div style="text-align:center;flex:1;">
                    <div style="font-size:26px;font-weight:700;color:#059669;">{{ $resRate }}%</div>
                    <div style="font-size:12px;color:#94a3b8;">Resolution Rate</div>
                </div>
                <div style="text-align:center;flex:1;">
                    <div style="font-size:26px;font-weight:700;color:#d97706;">{{ $stats['pending'] + $stats['review'] }}</div>
                    <div style="font-size:12px;color:#94a3b8;">Active Cases</div>
                </div>
            </div>
        </div>

        {{-- Top Categories --}}
        <div class="card" style="padding:22px;">
            <div style="font-size:15px;font-weight:600;color:#1e2d5e;margin-bottom:18px;">Top Complaint Categories</div>
            @php $colors = ['#3554a0','#059669','#d97706','#dc2626','#5b21b6','#0284c7','#0f766e']; @endphp
            @forelse($categories as $i => $cat)
            @php $pct = round($cat->total / $total * 100); @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                    <span style="font-size:13px;color:#475569;font-weight:500;">{{ $cat->category }}</span>
                    <span style="font-size:13px;font-weight:700;color:{{ $colors[$i % count($colors)] }};">{{ $cat->total }}</span>
                </div>
                <div style="height:7px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $colors[$i % count($colors)] }};border-radius:99px;"></div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:24px;color:#94a3b8;font-size:13px;">No data available yet</div>
            @endforelse
        </div>
    </div>

    {{-- Monthly Chart --}}
    <div class="card" style="padding:22px;margin-bottom:20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div style="font-size:15px;font-weight:600;color:#1e2d5e;">Monthly Submissions — {{ date('Y') }}</div>
            <div style="font-size:13px;color:#64748b;">Total: {{ $stats['total'] }} complaints</div>
        </div>

        <div style="display:flex;align-items:flex-end;gap:8px;height:140px;padding-bottom:4px;">
            @foreach($months as $i => $month)
            @php
                $count  = $monthly->get($i + 1)?->total ?? 0;
                $height = $maxMonth > 0 ? max(4, round($count / $maxMonth * 120)) : 4;
            @endphp
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                <div style="font-size:11px;color:{{ $count > 0 ? '#64748b' : 'transparent' }};font-weight:600;">{{ $count }}</div>
                <div style="width:100%;height:{{ $height }}px;background:{{ $count > 0 ? '#1e2d5e' : '#f1f5f9' }};border-radius:4px 4px 0 0;cursor:pointer;"
                    onmouseover="this.style.background='{{ $count > 0 ? '#3554a0' : '#e5e9f0' }}'"
                    onmouseout="this.style.background='{{ $count > 0 ? '#1e2d5e' : '#f1f5f9' }}'">
                </div>
            </div>
            @endforeach
        </div>
        <div style="display:flex;gap:8px;margin-top:8px;">
            @foreach($months as $month)
            <div style="flex:1;text-align:center;font-size:11px;color:#94a3b8;">{{ $month }}</div>
            @endforeach
        </div>
    </div>

    {{-- Summary Table --}}
    <div class="card" style="overflow:hidden;">
        <div style="padding:16px 20px 13px;border-bottom:1px solid #f1f5f9;">
            <div style="font-size:15px;font-weight:600;color:#1e2d5e;">Summary by Category</div>
        </div>
        <div style="overflow-x:auto;">
            <table class="bl-table">
                <thead><tr>
                    <th>Category</th><th>Total</th><th>Pending</th><th>For Review</th><th>Resolved</th><th>Rejected</th><th>% Share</th>
                </tr></thead>
                <tbody>
                    @forelse($categories as $cat)
                    @php
                        $cc  = \App\Models\Complaint::where('category', $cat->category);
                        $pct = round($cat->total / $total * 100);
                    @endphp
                    <tr>
                        <td style="font-weight:600;color:#1e2d5e;">{{ $cat->category }}</td>
                        <td style="font-weight:700;color:#3554a0;">{{ $cat->total }}</td>
                        <td style="color:#d97706;">{{ $cc->where('status','pending')->count() }}</td>
                        <td style="color:#0284c7;">{{ $cc->where('status','for_review')->count() }}</td>
                        <td style="color:#059669;">{{ $cc->where('status','resolved')->count() }}</td>
                        <td style="color:#dc2626;">{{ $cc->where('status','rejected')->count() }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="flex:1;height:5px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $pct }}%;background:#1e2d5e;border-radius:99px;"></div>
                                </div>
                                <span style="font-size:12px;font-weight:600;color:#64748b;width:32px;">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">No data yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>