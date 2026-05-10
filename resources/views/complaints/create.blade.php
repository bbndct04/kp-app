<x-app-layout>
    <x-slot name="title">Submit Complaint</x-slot>
    <x-slot name="header">Submit Complaint</x-slot>

    <div style="max-width:780px;margin:0 auto;">

        {{-- Info Banner --}}
        <div style="background:#e8eef8;border:1px solid #c5d5f0;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
            <svg width="16" height="16" fill="none" stroke="#3554a0" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-size:13.5px;color:#3554a0;">
                A unique reference number (e.g. <strong>BL-2026-001</strong>) will be automatically generated after submission.
            </span>
        </div>

        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fca5a5;font-size:14px;">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
        @endif

        {{-- Form Card --}}
        <div class="card" style="overflow:hidden;">
            <div style="padding:18px 22px 14px;border-bottom:1px solid #f1f5f9;background:#1e2d5e;">
                <div style="font-size:15px;font-weight:700;color:#fff;">📝 Complaint / Incident Report Form</div>
                <div style="font-size:12px;color:rgba(255,255,255,.6);margin-top:2px;">All fields marked * are required</div>
            </div>

            <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" id="complaint-form">
                @csrf
                <div style="padding:22px;">

                    {{-- ── SECTION 1: Complainant Info ── --}}
                    <div style="margin-bottom:24px;">
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#3554a0;background:#e8eef8;padding:8px 12px;border-radius:6px;margin-bottom:16px;">
                            👤 Section 1 — Complainant Information
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;" class="form-grid-2">
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                    Full Name of Complainant <span style="color:#dc2626;">*</span>
                                </label>
                                <input type="text" name="complainant_formal_name"
                                    value="{{ old('complainant_formal_name', auth()->user()->name) }}" required
                                    placeholder="Full legal name"
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                    Contact Number <span style="color:#dc2626;">*</span>
                                </label>
                                <input type="tel" name="complainant_contact"
                                    value="{{ old('complainant_contact') }}" required
                                    placeholder="09XX-XXX-XXXX"
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                        </div>

                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Complainant Address <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="text" name="complainant_address"
                                value="{{ old('complainant_address') }}" required
                                placeholder="Purok, Street, Barangay New Kababae, Olongapo City"
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>
                    </div>

                    {{-- ── SECTION 2: Subject of Complaint ── --}}
                    <div style="margin-bottom:24px;">
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#991b1b;background:#fee2e2;padding:8px 12px;border-radius:6px;margin-bottom:16px;">
                            ⚠️ Section 2 — Subject of Complaint
                        </div>

                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Name of Person / Subject of Complaint <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="text" name="respondent_name"
                                value="{{ old('respondent_name') }}" required
                                placeholder="Full name of the person being complained against"
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>

                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Address of Subject of Complaint <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="text" name="respondent_address"
                                value="{{ old('respondent_address') }}" required
                                placeholder="Purok, Street, Barangay, City"
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>
                    </div>

                    {{-- ── SECTION 3: Incident Details ── --}}
                    <div style="margin-bottom:22px;">
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#065f46;background:#d1fae5;padding:8px 12px;border-radius:6px;margin-bottom:16px;">
                            📋 Section 3 — Incident Details
                        </div>

                        {{-- Category --}}
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Complaint Category <span style="color:#dc2626;">*</span>
                            </label>
                            <select name="category" required id="category-select"
                                onchange="toggleOther(this.value)"
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;background:#fff;outline:none;font-family:Inter,sans-serif;cursor:pointer;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                                <option value="">Select a category</option>
                                @foreach([
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
                                ] as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Other Category field --}}
                        <div id="other-category-box"
                            style="display:{{ old('category') === 'Other' ? 'block' : 'none' }};margin-bottom:14px;">
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Please specify your complaint <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="text" name="other_category"
                                value="{{ old('other_category') }}"
                                id="other-category-input"
                                placeholder="Describe your specific complaint category..."
                                style="width:100%;padding:10px 12px;border:1.5px solid #f4a94a;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;background:#fff9ee;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#d97706'" onblur="this.style.borderColor='#f4a94a'">
                        </div>

                        {{-- Date & Time --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;" class="form-grid-2">
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                    Incident Date <span style="color:#dc2626;">*</span>
                                </label>
                                <input type="date" name="incident_date"
                                    value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}" required
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;background:#fff;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                            <div>
                                <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                    Incident Time <span style="color:#dc2626;">*</span>
                                </label>
                                <input type="time" name="incident_time"
                                    value="{{ old('incident_time') }}" required
                                    style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;background:#fff;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                            </div>
                        </div>

                        {{-- Location --}}
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Incident Location <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="text" name="location"
                                value="{{ old('location') }}" required
                                placeholder="e.g. Purok 3, Mabini Street, near the church"
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                        </div>

                        {{-- Description --}}
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Description of Incident <span style="color:#dc2626;">*</span>
                            </label>
                            <textarea name="description" rows="4" required
                                placeholder="Describe the incident in detail — what happened, how it started, and any other relevant information."
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;min-height:100px;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">{{ old('description') }}</textarea>
                        </div>

                        {{-- Relief Requested --}}
                        <div style="margin-bottom:14px;">
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Relief Requested <span style="color:#dc2626;">*</span>
                            </label>
                            <textarea name="relief_requested" rows="3" required
                                placeholder="What action or resolution are you requesting from the barangay?"
                                style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;outline:none;font-family:Inter,sans-serif;resize:vertical;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">{{ old('relief_requested') }}</textarea>
                        </div>

                        {{-- Attachment --}}
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Attach Evidence
                                <span style="color:#94a3b8;font-weight:400;">(Optional)</span>
                            </label>
                            <div class="upload-zone" onclick="document.getElementById('file-input').click()" style="background:#f8fafc;">
                                <input type="file" id="file-input" name="attachment"
                                    accept="image/*,.pdf,.doc,.docx"
                                    style="display:none;"
                                    onchange="handleFile(this)">
                                <div id="file-placeholder">
                                    <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <div style="font-size:14px;font-weight:600;color:#475569;margin-bottom:3px;">Click to upload evidence</div>
                                    <div style="font-size:12px;color:#94a3b8;">Photos, PDF, Word documents — Max 10MB</div>
                                </div>
                                <div id="file-selected" style="display:none;align-items:center;gap:10px;justify-content:center;">
                                    <svg width="22" height="22" fill="none" stroke="#059669" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    <div>
                                        <div id="file-name" style="font-size:14px;font-weight:600;color:#059669;"></div>
                                        <div style="font-size:12px;color:#64748b;">Click to change file</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div style="padding:16px 22px;border-top:1px solid #f1f5f9;display:flex;gap:10px;background:#f8fafc;" class="btn-row">
                    <a href="{{ route('dashboard') }}" class="btn-outline"
                        style="flex:1;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" style="flex:3;border-radius:8px;">
                        📨 Submit Report
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ═══ SUCCESS POPUP MODAL ═══ --}}
    @if(session('complaint_submitted'))
    <div id="success-modal" style="position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.6);display:flex;align-items:center;justify-content:center;padding:20px;">
        <div style="background:#fff;border-radius:20px;padding:36px 32px;max-width:460px;width:100%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.25);animation:popIn .4s cubic-bezier(.175,.885,.32,1.275);">

            <div style="width:72px;height:72px;border-radius:50%;background:#d1fae5;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:32px;">✅</div>

            <h2 style="font-size:20px;font-weight:700;color:#1e2d5e;margin-bottom:8px;">Complaint Submitted!</h2>

            <div style="background:#e8eef8;border-radius:8px;padding:10px 16px;margin-bottom:16px;">
                <div style="font-size:12px;color:#64748b;margin-bottom:3px;">Your Reference Number</div>
                <div style="font-size:22px;font-weight:700;color:#3554a0;font-family:monospace;">
                    {{ session('complaint_submitted') }}
                </div>
            </div>

            {{-- 24hr Warning --}}
            <div style="background:#fef3c7;border:1.5px solid #fcd34d;border-radius:10px;padding:14px 16px;margin-bottom:20px;text-align:left;">
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <span style="font-size:20px;flex-shrink:0;">⚠️</span>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#92400e;margin-bottom:4px;">Important Notice</div>
                        <div style="font-size:13px;color:#78350f;line-height:1.6;">
                            The complainant must <strong>personally appear at the Barangay Hall</strong> within <strong>24 hours</strong> from submission to formally file this complaint.
                        </div>
                        <div style="font-size:12px;color:#92400e;margin-top:8px;font-weight:600;line-height:1.6;">
                            📍 Barangay New Kababae Hall, Olongapo City<br>
                            ⏰ 8:00 AM – 5:00 PM, Monday to Friday
                        </div>
                    </div>
                </div>
            </div>

            <p style="font-size:13px;color:#64748b;margin-bottom:20px;line-height:1.6;">
                Save your reference number. You can use it to track your complaint status anytime.
            </p>

            <div style="display:flex;gap:10px;">
                <a href="{{ route('track') }}?ref={{ session('complaint_submitted') }}"
                    style="flex:1;background:#1e2d5e;color:#fff;border-radius:8px;padding:12px;font-size:14px;font-weight:600;text-decoration:none;display:block;text-align:center;">
                    Track Status
                </a>
                <a href="{{ route('my-reports') }}"
                    style="flex:1;background:#f5f7fa;color:#1e2d5e;border:1.5px solid #d1d9e6;border-radius:8px;padding:12px;font-size:14px;font-weight:600;text-decoration:none;display:block;text-align:center;">
                    My Reports
                </a>
            </div>
        </div>
    </div>
    <style>
        @keyframes popIn {
            from { opacity:0; transform:scale(.8); }
            to   { opacity:1; transform:scale(1); }
        }
    </style>
    @endif

    <script>
    function toggleOther(val) {
        const box   = document.getElementById('other-category-box');
        const input = document.getElementById('other-category-input');
        if (val === 'Other') {
            box.style.display = 'block';
            input.required = true;
            input.focus();
        } else {
            box.style.display = 'none';
            input.required = false;
            input.value = '';
        }
    }

    function handleFile(input) {
        const file = input.files[0];
        if (!file) return;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-placeholder').style.display = 'none';
        document.getElementById('file-selected').style.display = 'flex';
    }

    window.addEventListener('DOMContentLoaded', () => {
        const sel = document.getElementById('category-select');
        if (sel && sel.value === 'Other') toggleOther('Other');
    });
    </script>

</x-app-layout>