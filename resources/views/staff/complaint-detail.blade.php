<x-app-layout>
    <x-slot name="title">Complaint Detail</x-slot>
    <x-slot name="header">Complaint Detail</x-slot>

    @if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Back + Case Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <a href="{{ route('admin.complaints') }}"
            style="display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:14px;font-weight:500;text-decoration:none;"
            onmouseover="this.style.color='#1e2d5e'" onmouseout="this.style.color='#64748b'">
            ← Back to All Complaints
        </a>
        <div style="display:flex;gap:8px;">
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
            <span style="background:{{ $b['bg'] }};color:{{ $b['color'] }};padding:6px 14px;border-radius:99px;font-size:13px;font-weight:600;">
                {{ $b['label'] }}
            </span>
        </div>
    </div>

    {{-- Case Info Banner --}}
    <div style="background:#1e2d5e;border-radius:12px;padding:20px 24px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Reference Number</div>
            <div style="font-size:20px;font-weight:700;color:#fff;font-family:monospace;">{{ $complaint->reference_number }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Case Number</div>
            <div style="font-size:16px;font-weight:600;color:#fff;font-family:monospace;">{{ $complaint->case_number ?? 'Not assigned' }}</div>
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

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        {{-- LEFT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Complainant Info --}}
            <div class="card" style="padding:20px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" fill="none" stroke="#3554a0" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Complainant Information
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f1f5f9;">
                        <span style="font-size:13px;color:#64748b;">Name</span>
                        <span style="font-size:13px;font-weight:600;color:#1e2d5e;">{{ $complaint->user->name ?? '—' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f1f5f9;">
                        <span style="font-size:13px;color:#64748b;">Email</span>
                        <span style="font-size:13px;color:#334155;">{{ $complaint->user->email ?? '—' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f1f5f9;">
                        <span style="font-size:13px;color:#64748b;">Incident Date</span>
                        <span style="font-size:13px;color:#334155;">{{ \Carbon\Carbon::parse($complaint->incident_date)->format('F d, Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f1f5f9;">
                        <span style="font-size:13px;color:#64748b;">Incident Time</span>
                        <span style="font-size:13px;color:#334155;">{{ $complaint->incident_time ? \Carbon\Carbon::parse($complaint->incident_time)->format('h:i A') : '—' }}</span>
                    </div>
                    <div style="padding:8px 0;">
                        <span style="font-size:13px;color:#64748b;display:block;margin-bottom:4px;">Location</span>
                        <span style="font-size:13px;color:#334155;">{{ $complaint->location }}</span>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="card" style="padding:20px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:12px;">Complaint Description</div>
                <div style="font-size:13.5px;color:#334155;line-height:1.7;background:#f8fafc;padding:14px;border-radius:8px;border:1px solid #e5e9f0;">
                    {{ $complaint->description }}
                </div>
                @if($complaint->persons_involved)
                <div style="margin-top:12px;">
                    <div style="font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Persons Involved</div>
                    <div style="font-size:13.5px;color:#334155;">{{ $complaint->persons_involved }}</div>
                </div>
                @endif
            </div>

            {{-- KP Forms --}}
            <div class="card" style="padding:20px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" fill="none" stroke="#3554a0" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Generate KP Forms
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    @foreach([
                        ['num'=>'7', 'label'=>'KP Form #7','sub'=>"Complainant's Form",'color'=>'#3554a0','bg'=>'#e8eef8'],
                        ['num'=>'8', 'label'=>'KP Form #8','sub'=>'Notice of Hearing','color'=>'#0284c7','bg'=>'#e0f2fe'],
                        ['num'=>'9', 'label'=>'KP Form #9','sub'=>'Summons for Respondent','color'=>'#d97706','bg'=>'#fef3c7'],
                        ['num'=>'16','label'=>'KP Form #16','sub'=>'Amicable Settlement','color'=>'#059669','bg'=>'#d1fae5'],
                    ] as $form)
                    <a href="{{ route('staff.complaints.form', [$complaint, $form['num']]) }}"
                        target="_blank"
                        style="display:flex;flex-direction:column;padding:12px;border-radius:8px;background:{{ $form['bg'] }};border:1px solid {{ $form['color'] }}22;text-decoration:none;transition:all .2s;"
                        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <span style="font-size:13px;font-weight:700;color:{{ $form['color'] }};">{{ $form['label'] }}</span>
                        <span style="font-size:11.5px;color:#64748b;margin-top:2px;">{{ $form['sub'] }}</span>
                        <span style="font-size:11px;color:{{ $form['color'] }};margin-top:6px;font-weight:600;">📄 Generate PDF →</span>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- STEP 1: Encode Respondent (only if pending) --}}
            @if(in_array($complaint->status, ['pending', 'for_review']))
            <div class="card" style="overflow:hidden;">
                <div style="padding:14px 18px;background:#fef3c7;border-bottom:1px solid #fcd34d;display:flex;align-items:center;gap:8px;">
                    <span style="font-size:14px;">📝</span>
                    <div style="font-size:14px;font-weight:600;color:#92400e;">Step 1 — Encode Complaint Details</div>
                </div>
                <div style="padding:18px;">
                    <form method="POST" action="{{ route('staff.complaints.validate', $complaint) }}">
                        @csrf
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Complainant Formal Name *</label>
                            <input type="text" name="complainant_formal_name"
                                value="{{ $complaint->complainant_formal_name ?? $complaint->user->name }}"
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Respondent Name *</label>
                            <input type="text" name="respondent_name" required
                                value="{{ $complaint->respondent_name }}"
                                placeholder="Full name of the respondent"
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Respondent Address *</label>
                            <input type="text" name="respondent_address" required
                                value="{{ $complaint->respondent_address }}"
                                placeholder="Address of the respondent"
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>
                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Relief Requested</label>
                            <textarea name="relief_requested" rows="3"
                                placeholder="What relief/remedy is the complainant requesting?"
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">{{ $complaint->relief_requested }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%;border-radius:8px;">
                            Submit for Admin Review →
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- STEP 2: Hearing Info (if approved/scheduled) --}}
            @if(in_array($complaint->status, ['approved','scheduled','ongoing']))
            <div class="card" style="overflow:hidden;">
                <div style="padding:14px 18px;background:#e0f2fe;border-bottom:1px solid #bae6fd;display:flex;align-items:center;gap:8px;">
                    <span style="font-size:14px;">📅</span>
                    <div style="font-size:14px;font-weight:600;color:#0369a1;">Hearing Information</div>
                </div>
                <div style="padding:18px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:8px;">
                        <div style="background:#f8fafc;border-radius:8px;padding:12px;border:1px solid #e5e9f0;">
                            <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;">Hearing Date</div>
                            <div style="font-size:14px;font-weight:600;color:#1e2d5e;">
                                {{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F d, Y') : 'Not set' }}
                            </div>
                        </div>
                        <div style="background:#f8fafc;border-radius:8px;padding:12px;border:1px solid #e5e9f0;">
                            <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;">Hearing Time</div>
                            <div style="font-size:14px;font-weight:600;color:#1e2d5e;">
                                {{ $complaint->hearing_time ? \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i A') : 'Not set' }}
                            </div>
                        </div>
                    </div>
                    @if($complaint->punong_barangay)
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;border:1px solid #e5e9f0;">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;">Punong Barangay</div>
                        <div style="font-size:14px;font-weight:600;color:#1e2d5e;">{{ $complaint->punong_barangay }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- STEP 3: Record Mediation --}}
            @if(in_array($complaint->status, ['scheduled','ongoing']))
            <div class="card" style="overflow:hidden;">
                <div style="padding:14px 18px;background:#ede9fe;border-bottom:1px solid #c4b5fd;display:flex;align-items:center;gap:8px;">
                    <span style="font-size:14px;">🤝</span>
                    <div style="font-size:14px;font-weight:600;color:#5b21b6;">Step 2 — Record Mediation</div>
                </div>
                <div style="padding:18px;">
                    <form method="POST" action="{{ route('staff.complaints.mediation', $complaint) }}">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Punong Barangay</label>
                                <input type="text" name="punong_barangay"
                                    value="{{ $complaint->punong_barangay }}"
                                    placeholder="Full name"
                                    style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                            <div>
                                <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Pangkat Chairman</label>
                                <input type="text" name="pangkat_chairman"
                                    value="{{ $complaint->pangkat_chairman }}"
                                    placeholder="Full name"
                                    style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                        </div>
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Mediation Notes *</label>
                            <textarea name="mediation_notes" rows="3" required
                                placeholder="Record what happened during mediation..."
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">{{ $complaint->mediation_notes }}</textarea>
                        </div>
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Outcome *</label>
                            <select name="mediation_outcome" required
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;cursor:pointer;">
                                <option value="">Select outcome</option>
                                <option value="settled"     {{ $complaint->mediation_outcome==='settled'?'selected':'' }}>✅ Settled — Amicable Settlement</option>
                                <option value="not_settled" {{ $complaint->mediation_outcome==='not_settled'?'selected':'' }}>🔁 Not Settled — Continue</option>
                                <option value="escalated"   {{ $complaint->mediation_outcome==='escalated'?'selected':'' }}>⚠️ Escalated — Refer to higher authority</option>
                            </select>
                        </div>
                        <div style="margin-bottom:14px;" id="settlement-box">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Settlement Details</label>
                            <textarea name="settlement_details" rows="3"
                                placeholder="Terms of the amicable settlement agreement..."
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">{{ $complaint->settlement_details }}</textarea>
                        </div>
                        <div style="margin-bottom:16px;" id="escalation-box">
                            <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Escalation Reason</label>
                            <textarea name="escalation_reason" rows="2"
                                placeholder="Reason for escalation..."
                                style="width:100%;padding:9px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">{{ $complaint->escalation_reason }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%;border-radius:8px;">
                            Save Mediation Record
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Resolved / Escalated / Closed Result --}}
            @if(in_array($complaint->status, ['resolved','escalated','closed']))
            <div class="card" style="padding:18px;">
                <div style="font-size:14px;font-weight:600;color:#1e2d5e;margin-bottom:14px;">📋 Case Result</div>
                @if($complaint->mediation_outcome === 'settled')
                <div style="background:#d1fae5;border-radius:8px;padding:12px 14px;border:1px solid #a7f3d0;margin-bottom:12px;">
                    <div style="font-size:13px;font-weight:600;color:#065f46;margin-bottom:4px;">✅ Amicably Settled</div>
                    <div style="font-size:13px;color:#334155;">{{ $complaint->settlement_details ?? '—' }}</div>
                </div>
                @elseif($complaint->mediation_outcome === 'escalated')
                <div style="background:#fee2e2;border-radius:8px;padding:12px 14px;border:1px solid #fca5a5;margin-bottom:12px;">
                    <div style="font-size:13px;font-weight:600;color:#991b1b;margin-bottom:4px;">⚠️ Escalated</div>
                    <div style="font-size:13px;color:#334155;">{{ $complaint->escalation_reason ?? '—' }}</div>
                </div>
                @endif
                @if($complaint->mediation_notes)
                <div style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px;">Mediation Notes</div>
                <div style="font-size:13.5px;color:#334155;background:#f8fafc;padding:12px;border-radius:8px;border:1px solid #e5e9f0;margin-bottom:12px;">{{ $complaint->mediation_notes }}</div>
                @endif
                @if($complaint->status !== 'closed')
                <form method="POST" action="{{ route('staff.complaints.close', $complaint) }}">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Close and archive this case?')"
                        style="width:100%;padding:10px;border-radius:8px;background:#1e2d5e;color:#fff;border:none;font-size:14px;font-weight:600;cursor:pointer;font-family:Inter,sans-serif;">
                        📁 Close & Archive Case
                    </button>
                </form>
                @else
                <div style="background:#f1f5f9;border-radius:8px;padding:12px;text-align:center;font-size:14px;color:#64748b;font-weight:500;">
                    📁 Case Closed & Archived
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>

</x-app-layout>
