<x-app-layout>
    <x-slot name="title">Complaint Detail</x-slot>
    <x-slot name="header">Complaint Detail</x-slot>

    @if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Back Button --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.complaints') }}"
            style="display:inline-flex;align-items:center;gap:8px;font-size:13.5px;font-weight:600;color:#3554a0;text-decoration:none;padding:8px 16px;border-radius:8px;border:1.5px solid #d1d9e6;background:#f5f7fa;">
            ← Back to All Complaints
        </a>
    </div>

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
        $knownCategories = [
            'Physical Injury',
            'Oral Defamation / Slander',
            'Threat / Intimidation',
            'Unjust Vexation',
            'Property Dispute / Boundary Conflict',
            'Estafa / Fraud',
            'Unpaid Debt / Collection',
            'Theft / Robbery',
            'Trespassing',
            'Vandalism / Malicious Mischief',
            'Domestic Dispute / Family Conflict',
            'Noise Disturbance / Public Nuisance',
            'Light Offenses',
            'Other',
        ];
    @endphp

    <div style="max-width:860px;margin:0 auto;">

        {{-- Header Card --}}
        <div class="card" style="overflow:hidden;margin-bottom:20px;">
            <div style="padding:18px 22px;background:#1e2d5e;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <div>
                    <div style="font-size:22px;font-weight:700;color:#fff;font-family:monospace;">{{ $complaint->reference_number }}</div>
                    <div style="font-size:12px;color:rgba(255,255,255,.5);margin-top:2px;">Case No: {{ $complaint->case_number ?? '—' }}</div>
                </div>
                <span style="background:{{ $b['bg'] }};color:{{ $b['color'] }};padding:6px 16px;border-radius:99px;font-size:13px;font-weight:700;">
                    {{ $b['label'] }}
                </span>
            </div>
            <div style="padding:20px 22px;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;" class="form-grid-2">
                    <div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Category</div>
                        <div style="font-size:15px;font-weight:600;color:#1e2d5e;">{{ $complaint->category }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Date Filed</div>
                        <div style="font-size:15px;font-weight:600;color:#1e2d5e;">{{ \Carbon\Carbon::parse($complaint->created_at)->format('F d, Y h:i A') }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Incident Date & Time</div>
                        <div style="font-size:15px;font-weight:600;color:#1e2d5e;">
                            {{ \Carbon\Carbon::parse($complaint->incident_date)->format('F d, Y') }}
                            @if($complaint->incident_time)
                                at {{ \Carbon\Carbon::parse($complaint->incident_time)->format('h:i A') }}
                            @endif
                        </div>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;">Incident Location</div>
                        <div style="font-size:15px;font-weight:600;color:#1e2d5e;">{{ $complaint->location }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Complainant + Respondent --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;" class="form-grid-2">
            <div class="card" style="padding:20px;">
                <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#3554a0;background:#e8eef8;padding:8px 12px;border-radius:6px;margin-bottom:16px;">
                    👤 Complainant
                </div>
                <div style="margin-bottom:10px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Full Name</div>
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;">{{ $complaint->complainant_formal_name ?? $complaint->user->name ?? '—' }}</div>
                </div>
                <div style="margin-bottom:10px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Contact Number</div>
                    <div style="font-size:14px;color:#334155;">{{ $complaint->complainant_contact ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Address</div>
                    <div style="font-size:14px;color:#334155;">{{ $complaint->complainant_address ?? '—' }}</div>
                </div>
            </div>

            <div class="card" style="padding:20px;">
                <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#991b1b;background:#fee2e2;padding:8px 12px;border-radius:6px;margin-bottom:16px;">
                    ⚠️ Respondent
                </div>
                <div style="margin-bottom:10px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Full Name</div>
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;">{{ $complaint->respondent_name ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Address</div>
                    <div style="font-size:14px;color:#334155;">{{ $complaint->respondent_address ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Incident Details --}}
        <div class="card" style="padding:20px;margin-bottom:20px;">
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#065f46;background:#d1fae5;padding:8px 12px;border-radius:6px;margin-bottom:16px;">
                📋 Incident Details
            </div>
            <div style="margin-bottom:16px;">
                <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:6px;">Description</div>
                <div style="font-size:14px;color:#334155;line-height:1.8;background:#f8fafc;padding:14px;border-radius:8px;border:1px solid #e5e9f0;">
                    {{ $complaint->description }}
                </div>
            </div>
            <div>
                <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:6px;">Relief Requested</div>
                <div style="font-size:14px;color:#334155;line-height:1.8;background:#f8fafc;padding:14px;border-radius:8px;border:1px solid #e5e9f0;">
                    {{ $complaint->relief_requested ?? '—' }}
                </div>
            </div>
            @if($complaint->attachment)
            <div style="margin-top:16px;">
                <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:6px;">Attached Evidence</div>
                <a href="{{ Storage::url($complaint->attachment) }}" target="_blank"
                    style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;background:#e8eef8;color:#3554a0;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #c5d5f0;">
                    📎 View Attachment
                </a>
            </div>
            @endif
        </div>

        {{-- Hearing Info --}}
        @if($complaint->hearing_date)
        <div class="card" style="padding:20px;margin-bottom:20px;border-left:4px solid #5b21b6;">
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#5b21b6;margin-bottom:12px;">📅 Hearing Schedule</div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Date</div>
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;">{{ \Carbon\Carbon::parse($complaint->hearing_date)->format('F d, Y') }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Time</div>
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;">
                        {{ $complaint->hearing_time ? \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i A') : '—' }}
                    </div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:3px;">Punong Barangay</div>
                    <div style="font-size:14px;font-weight:600;color:#1e2d5e;">{{ $complaint->punong_barangay ?? '—' }}</div>
                </div>
            </div>
        </div>
        @endif

        {{-- Remarks --}}
        @if($complaint->remarks)
        <div class="card" style="padding:20px;margin-bottom:20px;border-left:4px solid #d97706;">
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#d97706;margin-bottom:8px;">💬 Remarks</div>
            <div style="font-size:14px;color:#334155;line-height:1.8;">{{ $complaint->remarks }}</div>
        </div>
        @endif

        {{-- PDF Documents --}}
<div class="card" style="padding:20px;margin-bottom:20px;">
    <div style="font-size:13px;font-weight:700;color:#1e2d5e;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
        <svg width="16" height="16" fill="none" stroke="#1e2d5e" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Generate KP Documents
    </div>

    {{-- Batch 1: Filing & Hearing --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:8px;">Filing & Hearing</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;margin-bottom:16px;">
        <a href="{{ route('admin.complaints.form7', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#e8eef8;border:1.5px solid #c5d5f0;border-radius:8px;text-decoration:none;color:#1e2d5e;font-size:12.5px;font-weight:600;">
            📋 Form 7 — Complainant's Form
        </a>
        <a href="{{ route('admin.complaints.form8', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#e8eef8;border:1.5px solid #c5d5f0;border-radius:8px;text-decoration:none;color:#1e2d5e;font-size:12.5px;font-weight:600;">
            📋 Form 8 — Notice of Hearing
        </a>
        <a href="{{ route('admin.complaints.form9', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#e8eef8;border:1.5px solid #c5d5f0;border-radius:8px;text-decoration:none;color:#1e2d5e;font-size:12.5px;font-weight:600;">
            📋 Form 9 — Summons
        </a>
        <a href="{{ route('admin.complaints.form13', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#e8eef8;border:1.5px solid #c5d5f0;border-radius:8px;text-decoration:none;color:#1e2d5e;font-size:12.5px;font-weight:600;">
            📋 Form 13 — Subpoena
        </a>
    </div>

    {{-- Batch 2: Pangkat --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:8px;">Pangkat Constitution</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;margin-bottom:16px;">
        <a href="{{ route('admin.complaints.form10', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#ede9fe;border:1.5px solid #c4b5fd;border-radius:8px;text-decoration:none;color:#5b21b6;font-size:12.5px;font-weight:600;">
            📋 Form 10 — Constitution of Pangkat
        </a>
        <a href="{{ route('admin.complaints.form11', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#ede9fe;border:1.5px solid #c4b5fd;border-radius:8px;text-decoration:none;color:#5b21b6;font-size:12.5px;font-weight:600;">
            📋 Form 11 — Notice to Pangkat Member
        </a>
    </div>

    {{-- Batch 3: Failure to Appear --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:8px;">Failure to Appear</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;margin-bottom:16px;">
        <a href="{{ route('admin.complaints.form18', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#fef3c7;border:1.5px solid #fcd34d;border-radius:8px;text-decoration:none;color:#92400e;font-size:12.5px;font-weight:600;">
            📋 Form 18 — Notice for Complainant
        </a>
        <a href="{{ route('admin.complaints.form19', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#fef3c7;border:1.5px solid #fcd34d;border-radius:8px;text-decoration:none;color:#92400e;font-size:12.5px;font-weight:600;">
            📋 Form 19 — Notice for Respondent
        </a>
    </div>

    {{-- Batch 4: Arbitration --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:8px;">Arbitration</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;margin-bottom:16px;">
        <a href="{{ route('admin.complaints.form14', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#dbeafe;border:1.5px solid #93c5fd;border-radius:8px;text-decoration:none;color:#1e40af;font-size:12.5px;font-weight:600;">
            📋 Form 14 — Agreement for Arbitration
        </a>
        <a href="{{ route('admin.complaints.form15', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#dbeafe;border:1.5px solid #93c5fd;border-radius:8px;text-decoration:none;color:#1e40af;font-size:12.5px;font-weight:600;">
            📋 Form 15 — Arbitration Award
        </a>
    </div>

    {{-- Batch 5: Settlement & Escalation --}}
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:8px;">Settlement & Escalation</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;">
        <a href="{{ route('admin.complaints.form16', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#d1fae5;border:1.5px solid #6ee7b7;border-radius:8px;text-decoration:none;color:#065f46;font-size:12.5px;font-weight:600;">
            📋 Form 16 — Amicable Settlement
        </a>
        <a href="{{ route('admin.complaints.form20', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#fee2e2;border:1.5px solid #fca5a5;border-radius:8px;text-decoration:none;color:#991b1b;font-size:12.5px;font-weight:600;">
            📋 Form 20 — CFA (Lupon Secretary)
        </a>
        <a href="{{ route('admin.complaints.form22', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#fee2e2;border:1.5px solid #fca5a5;border-radius:8px;text-decoration:none;color:#991b1b;font-size:12.5px;font-weight:600;">
            📋 Form 22 — CFA (Pangkat)
        </a>
        <a href="{{ route('admin.complaints.form25', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#fee2e2;border:1.5px solid #fca5a5;border-radius:8px;text-decoration:none;color:#991b1b;font-size:12.5px;font-weight:600;">
            📋 Form 25 — Motion for Execution
        </a>
        <a href="{{ route('admin.complaints.form27', $complaint) }}" target="_blank"
            style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#fee2e2;border:1.5px solid #fca5a5;border-radius:8px;text-decoration:none;color:#991b1b;font-size:12.5px;font-weight:600;">
            📋 Form 27 — Notice of Execution
        </a>
    </div>
</div>
        {{-- Update Complaint Form --}}
        <div class="card" style="overflow:hidden;">
            <div style="padding:16px 22px 14px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                <div style="font-size:15px;font-weight:700;color:#1e2d5e;">⚙️ Update Complaint</div>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Admin can correct the category and update the status</div>
            </div>

            <form method="POST" action="{{ route('admin.complaints.status', $complaint) }}" style="padding:22px;">
                @csrf

                {{-- Editable Category --}}
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px;">
                        Complaint Category <span style="color:#dc2626;">*</span>
                        <span style="font-size:10px;color:#d97706;font-weight:600;text-transform:none;margin-left:6px;">✏️ Editable by Admin</span>
                    </label>
                    <select name="category" id="admin-category-select"
                        onchange="toggleAdminOther(this.value)"
                        style="width:100%;border:1.5px solid #f4a94a;border-radius:8px;padding:10px 12px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;cursor:pointer;background:#fff9ee;">
                        @foreach($knownCategories as $cat)
                        <option value="{{ $cat }}" {{ $complaint->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                        {{-- ✅ unknown fallback removed --}}
                    </select>
                    <div id="admin-other-box" style="display:{{ $complaint->category === 'Other' ? 'block' : 'none' }};margin-top:8px;">
                        <input type="text" name="custom_category" id="admin-other-input"
                            value="{{ $complaint->other_category }}"
                            placeholder="Specify the complaint category..."
                            style="width:100%;background:#fff9ee;border:1.5px solid #f4a94a;border-radius:8px;padding:10px 12px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;">
                    </div>
                </div>

                {{-- Status + Punong Barangay --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;" class="form-grid-2">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px;">Status</label>
                        <select name="status"
                            style="width:100%;background:#fff;border:1.5px solid #d1d9e6;border-radius:8px;padding:10px 12px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;cursor:pointer;">
                            @foreach([
                                'pending'    => 'Pending',
                                'for_review' => 'For Review',
                                'approved'   => 'Approved',
                                'rejected'   => 'Rejected',
                                'scheduled'  => 'Scheduled',
                                'ongoing'    => 'Ongoing',
                                'resolved'   => 'Resolved',
                                'escalated'  => 'Escalated',
                                'closed'     => 'Closed',
                            ] as $val => $label)
                            <option value="{{ $val }}" {{ $complaint->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px;">Punong Barangay</label>
                        <input type="text" name="punong_barangay" value="{{ $complaint->punong_barangay }}"
                            placeholder="Full name..."
                            style="width:100%;background:#fff;border:1.5px solid #d1d9e6;border-radius:8px;padding:10px 12px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;">
                    </div>
                </div>

                {{-- Hearing Date + Time --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;" class="form-grid-2">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px;">Hearing Date</label>
                        <input type="date" name="hearing_date" value="{{ $complaint->hearing_date }}"
                            style="width:100%;background:#fff;border:1.5px solid #d1d9e6;border-radius:8px;padding:10px 12px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px;">Hearing Time</label>
                        <input type="time" name="hearing_time" value="{{ $complaint->hearing_time }}"
                            style="width:100%;background:#fff;border:1.5px solid #d1d9e6;border-radius:8px;padding:10px 12px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;">
                    </div>
                </div>

                {{-- Remarks --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:12px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px;">Remarks</label>
                    <textarea name="remarks" rows="3"
                        placeholder="Add remarks or notes..."
                        style="width:100%;background:#fff;border:1.5px solid #d1d9e6;border-radius:8px;padding:10px 12px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;box-sizing:border-box;">{{ $complaint->remarks }}</textarea>
                </div>

                <div style="display:flex;gap:10px;">
                    <a href="{{ route('admin.complaints') }}" class="btn-outline"
                        style="flex:1;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;border-radius:8px;">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" style="flex:3;border-radius:8px;">
                        💾 Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
    function toggleAdminOther(val) {
        const box   = document.getElementById('admin-other-box');
        const input = document.getElementById('admin-other-input');
        if (val === 'Other') {
            box.style.display = 'block';
            input.required = true;
        } else {
            box.style.display = 'none';
            input.required = false;
            input.value = '';
        }
    }
    window.addEventListener('DOMContentLoaded', () => {
        const sel = document.getElementById('admin-category-select');
        if (sel && sel.value === 'Other') toggleAdminOther('Other');
    });
    </script>

</x-app-layout>