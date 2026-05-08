<x-app-layout>
    <x-slot name="title">Track Status</x-slot>
    <x-slot name="header">Track Status</x-slot>

    {{-- Search Bar --}}
    <div class="card" style="padding:20px;margin-bottom:20px;max-width:600px;">
        <div style="font-size:15px;font-weight:600;color:#1e2d5e;margin-bottom:4px;">Track Your Complaint</div>
        <div style="font-size:13px;color:#94a3b8;margin-bottom:14px;">Enter your reference number to see the current status</div>
        <form method="GET" action="{{ route('track') }}" style="display:flex;gap:8px;">
            <input type="text" name="ref" value="{{ request('ref') }}"
                placeholder="e.g. BL-2026-001"
                style="flex:1;padding:10px 14px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;"
                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
            <button type="submit" class="btn-primary" style="width:auto;padding:10px 24px;border-radius:8px;">
                Search
            </button>
        </form>
    </div>

    @if(request('ref'))
        @php
            $complaint = \App\Models\Complaint::where('reference_number', request('ref'))
                ->where('user_id', auth()->id())
                ->first();
        @endphp

        @if($complaint)
        {{-- Case Info --}}
        <div style="background:#1e2d5e;border-radius:12px;padding:20px 24px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <div style="font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Reference Number</div>
                <div style="font-size:20px;font-weight:700;color:#fff;font-family:monospace;">{{ $complaint->reference_number }}</div>
            </div>
            <div>
                <div style="font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Case Number</div>
                <div style="font-size:15px;font-weight:600;color:#fff;font-family:monospace;">{{ $complaint->case_number ?? '—' }}</div>
            </div>
            <div>
                <div style="font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Category</div>
                <div style="font-size:15px;font-weight:600;color:#fff;">{{ $complaint->category }}</div>
            </div>
            <div>
                <div style="font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Date Filed</div>
                <div style="font-size:15px;font-weight:600;color:#fff;">{{ \Carbon\Carbon::parse($complaint->created_at)->format('M d, Y') }}</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

            {{-- KP Process Timeline --}}
            <div class="card" style="padding:22px;">
                <div style="font-size:15px;font-weight:600;color:#1e2d5e;margin-bottom:20px;">Case Progress Timeline</div>

                @php
                    $statusOrder = ['pending','for_review','approved','scheduled','ongoing','resolved','closed'];
                    $currentIdx  = array_search($complaint->status, $statusOrder);
                    if($complaint->status === 'rejected')  $currentIdx = 1;
                    if($complaint->status === 'escalated') $currentIdx = 5;

                    $steps = [
                        [
                            'status'  => 'pending',
                            'label'   => 'Complaint Submitted',
                            'desc'    => 'Your complaint has been received and is waiting for staff validation.',
                            'icon'    => '📥',
                            'date'    => \Carbon\Carbon::parse($complaint->created_at)->format('M d, Y'),
                        ],
                        [
                            'status'  => 'for_review',
                            'label'   => 'Staff Validation',
                            'desc'    => 'Staff is reviewing and encoding the complaint details.',
                            'icon'    => '👨‍💼',
                            'date'    => $complaint->status === 'for_review' ? 'In Progress' : '',
                        ],
                        [
                            'status'  => 'approved',
                            'label'   => 'Admin Review',
                            'desc'    => $complaint->status === 'rejected'
                                ? 'Complaint was rejected. Reason: '.($complaint->remarks ?? 'See remarks.')
                                : 'Admin reviewed and approved your complaint.',
                            'icon'    => $complaint->status === 'rejected' ? '❌' : '✅',
                            'date'    => '',
                        ],
                        [
                            'status'  => 'scheduled',
                            'label'   => 'Hearing Scheduled',
                            'desc'    => $complaint->hearing_date
                                ? 'Mediation hearing scheduled on '.(\Carbon\Carbon::parse($complaint->hearing_date)->format('F d, Y'))
                                  .($complaint->hearing_time ? ' at '.\Carbon\Carbon::parse($complaint->hearing_time)->format('h:i A') : '').'.'
                                : 'Hearing date will be set by admin.',
                            'icon'    => '📅',
                            'date'    => $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('M d, Y') : '',
                        ],
                        [
                            'status'  => 'ongoing',
                            'label'   => 'Mediation Proceedings',
                            'desc'    => 'Mediation proceedings are currently ongoing. Both parties are required to attend.',
                            'icon'    => '🤝',
                            'date'    => '',
                        ],
                        [
                            'status'  => 'resolved',
                            'label'   => $complaint->status === 'escalated' ? 'Escalated' : 'Case Resolved',
                            'desc'    => $complaint->status === 'escalated'
                                ? 'Case has been escalated. Reason: '.($complaint->escalation_reason ?? 'Refer to barangay office.')
                                : ($complaint->settlement_details
                                    ? 'Amicably settled. '.$complaint->settlement_details
                                    : 'Your complaint has been resolved through amicable settlement.'),
                            'icon'    => $complaint->status === 'escalated' ? '⚠️' : '🎉',
                            'date'    => '',
                        ],
                        [
                            'status'  => 'closed',
                            'label'   => 'Case Closed',
                            'desc'    => 'Case has been officially closed and archived.',
                            'icon'    => '📁',
                            'date'    => '',
                        ],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                @php
                    $isDone    = $i < $currentIdx;
                    $isActive  = $i === $currentIdx;
                    $isPending = $i > $currentIdx;

                    // Special rejected case
                    if($complaint->status === 'rejected' && $i === 2) {
                        $isActive = true; $isDone = false;
                    }
                    if($complaint->status === 'rejected' && $i > 2) {
                        $isPending = true; $isActive = false;
                    }
                    // Special escalated case
                    if($complaint->status === 'escalated' && $i === 5) {
                        $isActive = true; $isDone = false;
                    }
                @endphp
                <div style="display:flex;gap:14px;{{ $i < count($steps)-1 ? 'padding-bottom:20px;' : '' }}position:relative;">

                    {{-- Connector Line --}}
                    @if($i < count($steps)-1)
                    <div style="position:absolute;left:15px;top:34px;bottom:0;width:2px;background:{{ $isDone ? '#1e2d5e' : '#e5e9f0' }};"></div>
                    @endif

                    {{-- Dot --}}
                    <div style="width:32px;height:32px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:14px;z-index:1;
                        background:{{ $isDone ? '#1e2d5e' : ($isActive ? '#3554a0' : '#f1f5f9') }};
                        border:2px solid {{ $isDone ? '#1e2d5e' : ($isActive ? '#3554a0' : '#e5e9f0') }};">
                        @if($isDone)
                            <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        @elseif($isActive)
                            <div style="width:8px;height:8px;border-radius:50%;background:#fff;"></div>
                        @else
                            <div style="width:8px;height:8px;border-radius:50%;background:#cbd5e1;"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div style="flex:1;padding-top:4px;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                            <span style="font-size:14px;font-weight:600;color:{{ $isDone ? '#1e2d5e' : ($isActive ? '#3554a0' : '#94a3b8') }};">
                                {{ $step['label'] }}
                            </span>
                            @if($isActive)
                            <span style="background:#dbeafe;color:#1e40af;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:600;">Current</span>
                            @endif
                            @if($step['date'])
                            <span style="font-size:11px;color:#94a3b8;">{{ $step['date'] }}</span>
                            @endif
                        </div>
                        <div style="font-size:12.5px;color:{{ $isPending ? '#cbd5e1' : '#64748b' }};line-height:1.5;">
                            {{ $step['desc'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Right Info --}}
            <div style="display:flex;flex-direction:column;gap:14px;">

                {{-- Current Status --}}
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
                    $b = $badges[$complaint->status] ?? $badges['pending'];
                @endphp
                <div class="card" style="padding:18px;text-align:center;">
                    <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Current Status</div>
                    <span style="background:{{ $b['bg'] }};color:{{ $b['color'] }};padding:8px 20px;border-radius:99px;font-size:15px;font-weight:700;">
                        {{ $b['label'] }}
                    </span>
                </div>

                {{-- Hearing Info --}}
                @if($complaint->hearing_date)
                <div class="card" style="padding:18px;">
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:12px;">📅 Hearing Schedule</div>
                    <div style="background:#e8eef8;border-radius:8px;padding:12px 14px;border:1px solid #c5d5f0;">
                        <div style="font-size:15px;font-weight:700;color:#1e2d5e;">
                            {{ \Carbon\Carbon::parse($complaint->hearing_date)->format('F d, Y') }}
                        </div>
                        @if($complaint->hearing_time)
                        <div style="font-size:13px;color:#3554a0;margin-top:4px;font-weight:600;">
                            {{ \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i A') }}
                        </div>
                        @endif
                        <div style="font-size:12px;color:#64748b;margin-top:6px;">
                            📍 Barangay Hall, New Kababae, Olongapo City
                        </div>
                    </div>
                    <div style="font-size:12px;color:#d97706;margin-top:10px;background:#fef3c7;padding:8px 10px;border-radius:6px;">
                        ⚠️ Please appear in person. Failure to appear may affect your case.
                    </div>
                </div>
                @endif

                {{-- Respondent Info --}}
                @if($complaint->respondent_name)
                <div class="card" style="padding:18px;">
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:10px;">👤 Respondent</div>
                    <div style="font-size:13.5px;font-weight:600;color:#1e2d5e;">{{ $complaint->respondent_name }}</div>
                    @if($complaint->respondent_address)
                    <div style="font-size:13px;color:#64748b;margin-top:3px;">{{ $complaint->respondent_address }}</div>
                    @endif
                </div>
                @endif

                {{-- Remarks --}}
                @if($complaint->remarks)
                <div class="card" style="padding:18px;">
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:8px;">📝 Remarks</div>
                    <div style="font-size:13px;color:#475569;line-height:1.6;background:#f8fafc;padding:10px 12px;border-radius:6px;border:1px solid #e5e9f0;">
                        {{ $complaint->remarks }}
                    </div>
                </div>
                @endif

            </div>
        </div>

        @else
        {{-- Not Found --}}
        <div class="card" style="padding:52px;text-align:center;max-width:500px;">
            <div style="font-size:36px;margin-bottom:12px;">🔍</div>
            <div style="font-size:16px;font-weight:600;color:#1e2d5e;margin-bottom:6px;">Complaint Not Found</div>
            <div style="font-size:13.5px;color:#64748b;margin-bottom:16px;">
                No complaint found with reference number <strong>{{ request('ref') }}</strong>. Make sure you entered the correct reference number.
            </div>
            <a href="{{ route('my-reports') }}"
                style="display:inline-flex;align-items:center;gap:8px;background:#1e2d5e;color:#fff;border-radius:8px;padding:10px 20px;font-size:14px;font-weight:600;text-decoration:none;">
                View My Reports
            </a>
        </div>
        @endif

    @else
    {{-- No Search Yet --}}
    <div class="card" style="padding:52px;text-align:center;max-width:500px;">
        <div style="font-size:36px;margin-bottom:12px;">📋</div>
        <div style="font-size:15px;font-weight:600;color:#1e2d5e;margin-bottom:6px;">Enter a Reference Number</div>
        <div style="font-size:13.5px;color:#64748b;margin-bottom:16px;">
            Your reference number was given after submitting a complaint. It looks like <strong>BL-2026-001</strong>.
        </div>
        <a href="{{ route('my-reports') }}"
            style="display:inline-flex;align-items:center;gap:8px;background:#f5f7fa;color:#1e2d5e;border:1.5px solid #d1d9e6;border-radius:8px;padding:10px 20px;font-size:14px;font-weight:600;text-decoration:none;">
            View All My Reports
        </a>
    </div>
    @endif

</x-app-layout>