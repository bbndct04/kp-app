<x-app-layout>
    <x-slot name="title">Submit Complaint</x-slot>
    <x-slot name="header">Submit Complaint</x-slot>

    <div style="max-width:800px;margin:0 auto;">

        {{-- Page Header --}}
        <div style="margin-bottom:20px;">
            <p style="font-size:13.5px;color:#64748b;">Fill in all required fields. A unique reference number will be generated automatically.</p>
        </div>

        {{-- Info Banner --}}
        <div style="background:#e8eef8;border:1px solid #c5d5f0;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
            <svg width="16" height="16" fill="none" stroke="#3554a0" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-size:13.5px;color:#3554a0;">
                A unique reference number (e.g. <strong>BL-2026-001</strong>) will be automatically generated after submission.
            </span>
        </div>

        {{-- Success --}}
        @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;border:1px solid #a7f3d0;font-size:14px;font-weight:500;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:20px;border:1px solid #fca5a5;font-size:14px;">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
        @endif

        {{-- Form --}}
        <div class="card" style="overflow:hidden;">
            <div style="padding:18px 22px 14px;border-bottom:1px solid #f1f5f9;">
                <div style="font-size:15px;font-weight:600;color:#1e2d5e;">Complaint / Incident Report Form</div>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px;">All fields marked * are required</div>
            </div>

            <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
                @csrf
                <div style="padding:22px;">

                    {{-- Category --}}
                    <div style="margin-bottom:18px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                            Complaint Category <span style="color:#dc2626;">*</span>
                        </label>
                        <select name="category" required
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

                    {{-- Date & Time --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px;">
                        <div>
                            <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                                Incident Date <span style="color:#dc2626;">*</span>
                            </label>
                            <input type="date" name="incident_date"
                                value="{{ old('incident_date') }}"
                                max="{{ date('Y-m-d') }}" required
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
                    <div style="margin-bottom:18px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                            Incident Location <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="text" name="location"
                            value="{{ old('location') }}"
                            placeholder="e.g. Purok 3, Mabini Street, near the church" required
                            style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;background:#fff;outline:none;font-family:Inter,sans-serif;"
                            onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                    </div>

                    {{-- Description --}}
                    <div style="margin-bottom:18px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                            Description <span style="color:#dc2626;">*</span>
                        </label>
                        <textarea name="description" rows="5" required
                            placeholder="Describe the incident in detail. Include what happened, who was involved, and any other relevant information."
                            style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;background:#fff;outline:none;font-family:Inter,sans-serif;resize:vertical;min-height:120px;"
                            onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">{{ old('description') }}</textarea>
                    </div>

                    {{-- Persons Involved --}}
                    <div style="margin-bottom:18px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                            Persons Involved
                            <span style="color:#94a3b8;font-weight:400;">(Optional)</span>
                        </label>
                        <input type="text" name="persons_involved"
                            value="{{ old('persons_involved') }}"
                            placeholder="Names of persons involved or witnesses"
                            style="width:100%;padding:10px 12px;border:1.5px solid #d1d9e6;border-radius:8px;font-size:14px;color:#1e2d5e;background:#fff;outline:none;font-family:Inter,sans-serif;"
                            onfocus="this.style.borderColor='#3554a0'" onblur="this.style.borderColor='#d1d9e6'">
                    </div>

                    {{-- File Upload --}}
                    <div style="margin-bottom:8px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#475569;margin-bottom:6px;">
                            Attach Evidence
                            <span style="color:#94a3b8;font-weight:400;">(Optional)</span>
                        </label>
                        <div class="upload-zone" id="upload-zone" onclick="document.getElementById('file-input').click()" style="background:#f8fafc;">
                            <input type="file" id="file-input" name="attachment"
                                accept="image/*,.pdf,.doc,.docx"
                                style="display:none;"
                                onchange="handleFile(this)">
                            <div id="file-placeholder">
                                <svg width="32" height="32" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px;display:block;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <div style="font-size:14px;font-weight:600;color:#475569;margin-bottom:4px;">Click to upload evidence</div>
                                <div style="font-size:12px;color:#94a3b8;">Photos, PDF, Word documents — Max 10MB</div>
                            </div>
                            <div id="file-selected" style="display:none;align-items:center;gap:10px;">
                                <svg width="24" height="24" fill="none" stroke="#059669" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <div>
                                    <div id="file-name" style="font-size:14px;font-weight:600;color:#059669;"></div>
                                    <div style="font-size:12px;color:#64748b;margin-top:2px;">Click to change file</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div style="padding:16px 22px;border-top:1px solid #f1f5f9;display:flex;gap:10px;background:#f8fafc;">
                    <a href="{{ route('dashboard') }}"
                        class="btn-outline"
                        style="flex:1;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" style="flex:3;border-radius:8px;">
                        Submit Report
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
    function handleFile(input) {
        const file = input.files[0];
        if (!file) return;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-placeholder').style.display = 'none';
        document.getElementById('file-selected').style.display = 'flex';
    }
    </script>

</x-app-layout>