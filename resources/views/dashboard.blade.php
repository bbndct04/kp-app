<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">Dashboard</x-slot>

    @php
        $user = auth()->user();
        $firstName = explode(' ', $user->name)[0];
    @endphp

    {{-- Welcome Banner --}}
    <div class="glass-card" data-aos="fade-down"
        style="border-radius:16px;padding:24px 28px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;background:linear-gradient(135deg,rgba(26,95,212,.35),rgba(18,71,184,.25));">
        <div>
            <h2 style="font-size:20px;font-weight:700;color:#fff;margin-bottom:4px;">
                Welcome back, {{ $firstName }}! 👋
            </h2>
            <p style="color:rgba(255,255,255,.55);font-size:14px;">
                {{ now()->format('l, F j, Y') }} — Here's your BlotterLink overview.
            </p>
        </div>
        <a href="{{ route('complaints.create') }}"
            class="btn-primary"
            style="width:auto;padding:11px 24px;text-decoration:none;border-radius:10px;font-size:14px;">
            + New Report
        </a>
    </div>

    {{-- Main Grid --}}
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

        {{-- Recent Reports Table --}}
        <div class="glass-card" style="border-radius:16px;overflow:hidden;"
            data-aos="fade-up" data-aos-delay="100">
            <div style="padding:18px 22px 14px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:2px;">
                        Recent Reports
                    </div>
                    <div style="font-size:12px;color:rgba(255,255,255,.35);">
                        Your latest submissions
                    </div>
                </div>
                <a href="#"
                    style="font-size:13px;color:var(--blue-400);font-weight:600;text-decoration:none;padding:5px 12px;border-radius:6px;border:1px solid rgba(91,160,245,.25);background:rgba(43,126,237,.1);">
                    View All →
                </a>
            </div>
            <div style="overflow-x:auto;">
                <table class="bl-table">
                    <thead>
                        <tr>
                            <th>Reference No.</th>
                            <th>Category</th>
                            <th>Date Filed</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="text-align:center;padding:48px 24px;color:rgba(255,255,255,.25);">
                                <div style="font-size:36px;margin-bottom:10px;">📋</div>
                                <div style="font-size:14px;color:rgba(255,255,255,.4);margin-bottom:4px;">
                                    No reports yet
                                </div>
                                <div style="font-size:12px;color:rgba(255,255,255,.25);margin-bottom:16px;">
                                    Submit your first complaint to get started
                                </div>
                                <a href="{{ route('complaints.create') }}"
                                    style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#1a5fd4,#1247b8);color:#fff;border-radius:8px;padding:10px 20px;font-size:14px;font-weight:600;text-decoration:none;box-shadow:0 4px 12px rgba(26,95,212,.35);">
                                    Submit Complaint
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- File Complaint Card --}}
            <div data-aos="fade-left" data-aos-delay="150"
                style="background:linear-gradient(135deg,#1247b8,#071442);border-radius:16px;padding:24px;border:1px solid rgba(91,160,245,.25);box-shadow:0 8px 24px rgba(0,0,0,.3);">
                <div style="font-size:32px;margin-bottom:12px;">📝</div>
                <div style="color:#fff;font-size:15px;font-weight:700;margin-bottom:6px;">
                    File a Complaint
                </div>
                <div style="color:rgba(255,255,255,.5);font-size:13px;margin-bottom:18px;line-height:1.55;">
                    Submit a new complaint or incident report to the barangay.
                </div>
                <a href="{{ route('complaints.create') }}"
                    style="display:block;text-align:center;background:linear-gradient(135deg,var(--blue-600),var(--blue-700));color:#fff;border-radius:8px;padding:11px;font-size:14px;font-weight:600;text-decoration:none;box-shadow:0 4px 12px rgba(26,95,212,.4);">
                    + New Report
                </a>
            </div>

            {{-- Quick Track --}}
            <div class="glass-card" style="border-radius:16px;padding:20px;"
                data-aos="fade-left" data-aos-delay="200">
                <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:4px;">
                    🔍 Quick Track
                </div>
                <div style="font-size:12px;color:rgba(255,255,255,.4);margin-bottom:10px;">
                    Enter your reference number
                </div>
                <div style="display:flex;gap:8px;">
                    <input type="text" placeholder="BL-2025-XXX"
                        style="flex:1;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:6px;padding:9px 10px;font-size:13px;color:#fff;outline:none;font-family:Inter,sans-serif;transition:all .2s;"
                        onfocus="this.style.borderColor='var(--blue-400)';this.style.background='rgba(43,126,237,.12)'"
                        onblur="this.style.borderColor='rgba(255,255,255,.12)';this.style.background='rgba(255,255,255,.07)'">
                    <button class="btn-primary"
                        style="width:auto;padding:9px 16px;font-size:13px;white-space:nowrap;border-radius:6px;">
                        Go
                    </button>
                </div>
            </div>

            {{-- Stats Summary --}}
            <div class="glass-card" style="border-radius:16px;padding:20px;"
                data-aos="fade-left" data-aos-delay="240">
                <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:14px;">
                    📂 My Reports
                </div>
                @php
                    $counts = [
                        ['label'=>'Total',        'val'=>$stats['total'],    'color'=>'var(--blue-400)', 'bg'=>'rgba(43,126,237,.2)'],
                        ['label'=>'Pending',      'val'=>$stats['pending'],  'color'=>'#f4a94a',         'bg'=>'rgba(194,91,0,.2)'],
                        ['label'=>'Under Review', 'val'=>$stats['review'],   'color'=>'#93c3fa',         'bg'=>'rgba(91,160,245,.2)'],
                        ['label'=>'Resolved',     'val'=>$stats['resolved'], 'color'=>'#4ade80',         'bg'=>'rgba(13,122,78,.2)'],
                    ];
                @endphp
                @foreach($counts as $c)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:9px 12px;border-radius:8px;background:{{ $c['bg'] }};margin-bottom:7px;border:1px solid rgba(255,255,255,.06);">
                    <span style="font-size:13px;color:rgba(255,255,255,.7);font-weight:500;">{{ $c['label'] }}</span>
                    <span style="font-size:18px;font-weight:700;color:{{ $c['color'] }};">{{ $c['val'] }}</span>
                </div>
                @endforeach
            </div>

            {{-- Help Card --}}
            <div data-aos="fade-left" data-aos-delay="280"
                style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);border-radius:16px;padding:18px;">
                <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:8px;">
                    ℹ️ Need Help?
                </div>
                <div style="font-size:12.5px;color:rgba(255,255,255,.45);line-height:1.6;">
                    Visit the barangay office at <strong style="color:rgba(255,255,255,.65);">8AM–5PM</strong> Mon–Fri, or call your barangay hotline.
                </div>
            </div>

        </div>
    </div>

</x-app-layout>