<x-app-layout>
    <x-slot name="title">All Complaints</x-slot>
    <x-slot name="header">All Complaints</x-slot>

    @if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <p style="font-size:13.5px;color:#64748b;">Manage and update complaint status</p>
    </div>

    {{-- Search + Filter --}}
    <div class="card" style="padding:16px 20px;margin-bottom:20px;">
        <form method="GET" action="{{ route('admin.complaints') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by ref, resident, or category..."
                style="flex:1;min-width:220px;background:#f5f7fa;border:1.5px solid #e5e9f0;border-radius:8px;padding:9px 14px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;"
                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#e5e9f0'">
            <select name="status"
                style="background:#f5f7fa;border:1.5px solid #e5e9f0;border-radius:8px;padding:9px 14px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;cursor:pointer;">
                <option value="all">All Status</option>
                <option value="pending"    {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                <option value="for_review" {{ request('status')==='for_review'?'selected':'' }}>For Review</option>
                <option value="approved"   {{ request('status')==='approved'?'selected':'' }}>Approved</option>
                <option value="rejected"   {{ request('status')==='rejected'?'selected':'' }}>Rejected</option>
                <option value="scheduled"  {{ request('status')==='scheduled'?'selected':'' }}>Scheduled</option>
                <option value="ongoing"    {{ request('status')==='ongoing'?'selected':'' }}>Ongoing</option>
                <option value="resolved"   {{ request('status')==='resolved'?'selected':'' }}>Resolved</option>
                <option value="escalated"  {{ request('status')==='escalated'?'selected':'' }}>Escalated</option>
                <option value="closed"     {{ request('status')==='closed'?'selected':'' }}>Closed</option>
            </select>
            <button type="submit" class="btn-primary" style="width:auto;padding:9px 22px;border-radius:8px;">Search</button>
            @if(request('search') || request('status'))
            <a href="{{ route('admin.complaints') }}" class="btn-outline" style="padding:9px 16px;text-decoration:none;">Clear</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table class="bl-table">
                <thead><tr>
                    <th>Ref. No.</th>
                    <th>Case No.</th>
                    <th>Resident</th>
                    <th>Category</th>
                    <th>Filed</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($complaints as $c)
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
                    <tr id="row-{{ $c->id }}">
                        <td style="font-weight:700;color:#3554a0;font-family:monospace;font-size:13px;">{{ $c->reference_number }}</td>
                        <td style="font-size:12px;color:#94a3b8;font-family:monospace;">{{ $c->case_number ?? '—' }}</td>
                        <td style="font-weight:500;color:#1e2d5e;">{{ $c->user->name ?? '—' }}</td>
                        <td style="color:#475569;">{{ $c->category }}</td>
                        <td style="color:#94a3b8;font-size:13px;">{{ \Carbon\Carbon::parse($c->created_at)->format('M d, Y') }}</td>
                        <td>
                            <span style="background:{{ $b['bg'] }};color:{{ $b['color'] }};padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">
                                {{ $b['label'] }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap;">

                                {{-- View Detail --}}
                                <a href="{{ route('staff.complaints.show', $c) }}"
                                    style="font-size:12px;font-weight:600;color:#3554a0;text-decoration:none;padding:5px 10px;border-radius:6px;border:1px solid #c5d5f0;background:#e8eef8;">
                                    View
                                </a>

                                {{-- Approve Button (only for_review) --}}
                                @if($c->status === 'for_review')
                                <button onclick="openApprove({{ $c->id }}, '{{ $c->reference_number }}')"
                                    style="font-size:12px;font-weight:600;color:#065f46;padding:5px 10px;border-radius:6px;border:1px solid #a7f3d0;background:#d1fae5;cursor:pointer;font-family:Inter,sans-serif;">
                                    ✓ Approve
                                </button>
                                <button onclick="openReject({{ $c->id }}, '{{ $c->reference_number }}')"
                                    style="font-size:12px;font-weight:600;color:#991b1b;padding:5px 10px;border-radius:6px;border:1px solid #fca5a5;background:#fee2e2;cursor:pointer;font-family:Inter,sans-serif;">
                                    ✗ Reject
                                </button>
                                @endif

                                {{-- Manage (expand) --}}
                                <button onclick="toggleExpand({{ $c->id }})"
                                    style="font-size:12px;font-weight:600;color:#64748b;padding:5px 10px;border-radius:6px;border:1px solid #d1d9e6;background:#f5f7fa;cursor:pointer;font-family:Inter,sans-serif;">
                                    ⋯
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Expand Row --}}
                    <tr id="expand-{{ $c->id }}" style="display:none;">
                        <td colspan="7" style="padding:0;">
                            <div style="background:#f8fafc;border-top:1px solid #e5e9f0;border-bottom:1px solid #e5e9f0;padding:18px 22px;">

                                {{-- Details --}}
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                                    <div>
                                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:5px;">Description</div>
                                        <div style="font-size:13px;color:#334155;line-height:1.6;background:#fff;padding:10px 12px;border-radius:6px;border:1px solid #e5e9f0;">{{ $c->description }}</div>
                                    </div>
                                    <div>
                                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:5px;">Location</div>
                                        <div style="font-size:13px;color:#334155;margin-bottom:10px;">{{ $c->location }}</div>
                                        @if($c->respondent_name)
                                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-bottom:5px;">Respondent</div>
                                        <div style="font-size:13px;color:#334155;">{{ $c->respondent_name }}</div>
                                        @endif
                                        @if($c->hearing_date)
                                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:#94a3b8;margin-top:8px;margin-bottom:5px;">Hearing</div>
                                        <div style="font-size:13px;color:#1e2d5e;font-weight:600;">
                                            {{ \Carbon\Carbon::parse($c->hearing_date)->format('F d, Y') }}
                                            @if($c->hearing_time) at {{ \Carbon\Carbon::parse($c->hearing_time)->format('h:i A') }} @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Quick Status Update --}}
                                <form method="POST" action="{{ route('admin.complaints.status', $c) }}"
                                    style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;border-top:1px solid #e5e9f0;padding-top:14px;">
                                    @csrf
                                    <div style="flex:1;min-width:140px;">
                                        <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:5px;">Status</label>
                                        <select name="status"
                                            style="width:100%;background:#fff;border:1.5px solid #d1d9e6;border-radius:8px;padding:8px 10px;font-size:13px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;cursor:pointer;">
                                            <option value="pending"    {{ $c->status==='pending'?'selected':'' }}>Pending</option>
                                            <option value="for_review" {{ $c->status==='for_review'?'selected':'' }}>For Review</option>
                                            <option value="approved"   {{ $c->status==='approved'?'selected':'' }}>Approved</option>
                                            <option value="rejected"   {{ $c->status==='rejected'?'selected':'' }}>Rejected</option>
                                            <option value="scheduled"  {{ $c->status==='scheduled'?'selected':'' }}>Scheduled</option>
                                            <option value="ongoing"    {{ $c->status==='ongoing'?'selected':'' }}>Ongoing</option>
                                            <option value="resolved"   {{ $c->status==='resolved'?'selected':'' }}>Resolved</option>
                                            <option value="escalated"  {{ $c->status==='escalated'?'selected':'' }}>Escalated</option>
                                            <option value="closed"     {{ $c->status==='closed'?'selected':'' }}>Closed</option>
                                        </select>
                                    </div>
                                    <div style="flex:2;min-width:180px;">
                                        <label style="display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:5px;">Remarks</label>
                                        <input type="text" name="remarks" value="{{ $c->remarks }}"
                                            placeholder="Add remarks..."
                                            style="width:100%;background:#fff;border:1.5px solid #d1d9e6;border-radius:8px;padding:8px 10px;font-size:13px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;"
                                            onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                                    </div>
                                    <button type="submit" class="btn-primary" style="width:auto;padding:9px 18px;border-radius:8px;white-space:nowrap;font-size:13px;">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:52px;color:#94a3b8;">
                            <div style="width:52px;height:52px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="font-size:14px;font-weight:500;color:#475569;margin-bottom:4px;">No complaints found</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($complaints->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
            <div style="font-size:13px;color:#64748b;">
                Showing {{ $complaints->firstItem() }}–{{ $complaints->lastItem() }} of {{ $complaints->total() }}
            </div>
            <div style="display:flex;gap:6px;">
                @if($complaints->onFirstPage())
                    <span class="page-btn disabled">← Prev</span>
                @else
                    <a href="{{ $complaints->previousPageUrl() }}" class="page-btn">← Prev</a>
                @endif
                @if($complaints->hasMorePages())
                    <a href="{{ $complaints->nextPageUrl() }}" class="page-btn">Next →</a>
                @else
                    <span class="page-btn disabled">Next →</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- ═══ APPROVE MODAL ═══ --}}
    <div id="approve-modal" style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(0,0,0,.5);align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:16px;padding:28px;width:100%;max-width:480px;margin:0 20px;box-shadow:0 20px 60px rgba(0,0,0,.2);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div>
                    <div style="font-size:16px;font-weight:700;color:#1e2d5e;">✓ Approve Complaint</div>
                    <div id="approve-ref" style="font-size:13px;color:#64748b;margin-top:2px;"></div>
                </div>
                <button onclick="closeApprove()"
                    style="width:32px;height:32px;border-radius:8px;border:1px solid #e5e9f0;background:#f5f7fa;cursor:pointer;font-size:16px;color:#64748b;">✕</button>
            </div>

            <form id="approve-form" method="POST" action="">
                @csrf
                <input type="hidden" name="status" value="approved">

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Hearing Date *</label>
                    <input type="date" name="hearing_date" required
                        style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Hearing Time *</label>
                    <input type="time" name="hearing_time" required
                        style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Punong Barangay Name *</label>
                    <input type="text" name="punong_barangay" required
                        placeholder="Full name of the Punong Barangay"
                        style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Remarks (Optional)</label>
                    <input type="text" name="remarks"
                        placeholder="Additional notes..."
                        style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeApprove()" class="btn-outline" style="flex:1;border-radius:8px;padding:11px;">
                        Cancel
                    </button>
                    <button type="submit"
                        style="flex:2;background:#059669;color:#fff;border:none;border-radius:8px;padding:11px;font-size:14px;font-weight:600;cursor:pointer;font-family:Inter,sans-serif;">
                        ✓ Confirm Approval
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══ REJECT MODAL ═══ --}}
    <div id="reject-modal" style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(0,0,0,.5);align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:16px;padding:28px;width:100%;max-width:440px;margin:0 20px;box-shadow:0 20px 60px rgba(0,0,0,.2);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div>
                    <div style="font-size:16px;font-weight:700;color:#991b1b;">✗ Reject Complaint</div>
                    <div id="reject-ref" style="font-size:13px;color:#64748b;margin-top:2px;"></div>
                </div>
                <button onclick="closeReject()"
                    style="width:32px;height:32px;border-radius:8px;border:1px solid #e5e9f0;background:#f5f7fa;cursor:pointer;font-size:16px;color:#64748b;">✕</button>
            </div>

            <div style="background:#fee2e2;border-radius:8px;padding:12px 14px;margin-bottom:18px;border:1px solid #fca5a5;">
                <div style="font-size:13px;color:#991b1b;font-weight:500;">
                    ⚠️ This will reject the complaint and notify the resident. Please provide a valid reason.
                </div>
            </div>

            <form id="reject-form" method="POST" action="">
                @csrf
                <input type="hidden" name="status" value="rejected">

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Reason for Rejection *</label>
                    <textarea name="remarks" rows="4" required
                        placeholder="Explain why this complaint is being rejected..."
                        style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#dc2626'" onblur="this.style.borderColor='#d1d9e6'"></textarea>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeReject()" class="btn-outline" style="flex:1;border-radius:8px;padding:11px;">
                        Cancel
                    </button>
                    <button type="submit"
                        style="flex:2;background:#dc2626;color:#fff;border:none;border-radius:8px;padding:11px;font-size:14px;font-weight:600;cursor:pointer;font-family:Inter,sans-serif;">
                        ✗ Confirm Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleExpand(id) {
        const row = document.getElementById('expand-' + id);
        row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
    }

    function openApprove(id, ref) {
        document.getElementById('approve-ref').textContent = 'Complaint: ' + ref;
        document.getElementById('approve-form').action = '/admin/complaints/' + id + '/status';
        document.getElementById('approve-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeApprove() {
        document.getElementById('approve-modal').style.display = 'none';
        document.body.style.overflow = '';
    }

    function openReject(id, ref) {
        document.getElementById('reject-ref').textContent = 'Complaint: ' + ref;
        document.getElementById('reject-form').action = '/admin/complaints/' + id + '/status';
        document.getElementById('reject-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeReject() {
        document.getElementById('reject-modal').style.display = 'none';
        document.body.style.overflow = '';
    }

    // Close modal on backdrop click
    document.getElementById('approve-modal').addEventListener('click', function(e) {
        if (e.target === this) closeApprove();
    });
    document.getElementById('reject-modal').addEventListener('click', function(e) {
        if (e.target === this) closeReject();
    });
    </script>

</x-app-layout>