<x-app-layout>
    <x-slot name="title">Submit Complaint</x-slot>
    <x-slot name="header">Submit Complaint</x-slot>

    <div style="max-width:800px;margin:0 auto;">

        {{-- Page Header --}}
        <div data-aos="fade-down" style="margin-bottom:24px;">
            <h2 style="font-size:22px;font-weight:700;color:#fff;margin-bottom:4px;">
                File a Complaint / Incident Report
            </h2>
            <p style="font-size:14px;color:rgba(255,255,255,.45);">
                Fill in all required fields. A unique reference number will be generated automatically.
            </p>
        </div>

        {{-- Info Banner --}}
        <div data-aos="fade-down" data-aos-delay="50"
            style="background:rgba(43,126,237,.2);border:1px solid rgba(91,160,245,.3);border-radius:12px;padding:12px 16px;margin-bottom:24px;display:flex;align-items:center;gap:10px;">
            <span style="font-size:18px;">ℹ️</span>
            <span style="font-size:13.5px;color:rgba(255,255,255,.75);line-height:1.5;">
                A unique reference number (e.g. <strong style="color:var(--blue-300);">BL-2025-001</strong>) will be automatically generated after submission.
            </span>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div data-aos="fade-down"
            style="background:rgba(13,122,78,.25);border:1px solid rgba(74,222,128,.3);border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
            <span style="font-size:18px;">✅</span>
            <div>
                <div style="font-size:14px;font-weight:700;color:#4ade80;">Complaint Submitted!</div>
                <div style="font-size:13px;color:rgba(255,255,255,.6);margin-top:2px;">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
        <div data-aos="fade-down"
            style="background:rgba(185,28,28,.25);border:1px solid rgba(248,113,113,.3);border-radius:12px;padding:14px 18px;margin-bottom:20px;">
            <div style="font-size:14px;font-weight:700;color:#f87171;margin-bottom:6px;">Please fix the following:</div>
            @foreach($errors->all() as $error)
                <div style="font-size:13px;color:rgba(255,255,255,.6);padding:2px 0;">• {{ $error }}</div>
            @endforeach
        </div>
        @endif

        {{-- Form Card --}}
        <div class="glass-card" style="border-radius:20px;overflow:hidden;" data-aos="fade-up" data-aos-delay="100">

            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <div style="padding:28px 28px 0;">

                    {{-- Category --}}
                    <div style="margin-bottom:20px;">
                        <label class="form-label" style="color:rgba(255,255,255,.75);">
                            Complaint Category <span style="color:#f87171;">*</span>
                        </label>
                        <select name="category_id" required
                            style="width:100%;padding:11px 14px;border:1.5px solid rgba(255,255,255,.15);border-radius:8px;font-size:14.5px;color:#fff;background:rgba(255,255,255,.08);outline:none;font-family:Inter,sans-serif;cursor:pointer;transition:all .2s;"
                            onfocus="this.style.borderColor='var(--blue-400)';this.style.background='rgba(43,126,237,.15)'"
                            onblur="this.style.borderColor='rgba(255,255,255,.15)';this.style.background='rgba(255,255,255,.08)'">
                            <option value="" style="background:#071442;color:#fff;">Select a category</option>
                            @foreach([
                                'Noise Complaint',
                                'Property Dispute',
                                'Theft',
                                'Public Disturbance',
                                'Vandalism',
                                'Illegal Parking',
                                'Environmental Violation',
                                'Domestic Issue',
                                'Other',
                            ] as $cat)
                            <option value="{{ $cat }}" style="background:#071442;color:#fff;"
                                {{ old('category_id') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date & Time --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                        <div>
                            <label class="form-label" style="color:rgba(255,255,255,.75);">
                                Incident Date <span style="color:#f87171;">*</span>
                            </label>
                            <input type="date" name="incident_date"
                                value="{{ old('incident_date') }}"
                                max="{{ date('Y-m-d') }}"
                                required
                                style="width:100%;padding:11px 14px;border:1.5px solid rgba(255,255,255,.15);border-radius:8px;font-size:14.5px;color:#fff;background:rgba(255,255,255,.08);outline:none;font-family:Inter,sans-serif;transition:all .2s;color-scheme:dark;"
                                onfocus="this.style.borderColor='var(--blue-400)'"
                                onblur="this.style.borderColor='rgba(255,255,255,.15)'">
                        </div>
                        <div>
                            <label class="form-label" style="color:rgba(255,255,255,.75);">
                                Incident Time <span style="color:#f87171;">*</span>
                            </label>
                            <input type="time" name="incident_time"
                                value="{{ old('incident_time') }}"
                                required
                                style="width:100%;padding:11px 14px;border:1.5px solid rgba(255,255,255,.15);border-radius:8px;font-size:14.5px;color:#fff;background:rgba(255,255,255,.08);outline:none;font-family:Inter,sans-serif;transition:all .2s;color-scheme:dark;"
                                onfocus="this.style.borderColor='var(--blue-400)'"
                                onblur="this.style.borderColor='rgba(255,255,255,.15)'">
                        </div>
                    </div>

                    {{-- Location --}}
                    <div style="margin-bottom:20px;">
                        <label class="form-label" style="color:rgba(255,255,255,.75);">
                            Incident Location <span style="color:#f87171;">*</span>
                        </label>
                        <input type="text" name="location"
                            value="{{ old('location') }}"
                            placeholder="e.g. Purok 3, Mabini Street, near the church"
                            required
                            style="width:100%;padding:11px 14px;border:1.5px solid rgba(255,255,255,.15);border-radius:8px;font-size:14.5px;color:#fff;background:rgba(255,255,255,.08);outline:none;font-family:Inter,sans-serif;transition:all .2s;"
                            onfocus="this.style.borderColor='var(--blue-400)';this.style.background='rgba(43,126,237,.1)'"
                            onblur="this.style.borderColor='rgba(255,255,255,.15)';this.style.background='rgba(255,255,255,.08)'"
                            style="color-scheme:dark">
                        <input type="text" name="location" placeholder="color fix" style="display:none">
                    </div>

                    {{-- Description --}}
                    <div style="margin-bottom:20px;">
                        <label class="form-label" style="color:rgba(255,255,255,.75);">
                            Description <span style="color:#f87171;">*</span>
                        </label>
                        <textarea name="description" rows="5" required
                            placeholder="Describe the incident in detail. Include what happened, when it started, and any other relevant information."
                            style="width:100%;padding:11px 14px;border:1.5px solid rgba(255,255,255,.15);border-radius:8px;font-size:14.5px;color:#fff;background:rgba(255,255,255,.08);outline:none;font-family:Inter,sans-serif;transition:all .2s;resize:vertical;min-height:120px;"
                            onfocus="this.style.borderColor='var(--blue-400)';this.style.background='rgba(43,126,237,.1)'"
                            onblur="this.style.borderColor='rgba(255,255,255,.15)';this.style.background='rgba(255,255,255,.08)'">{{ old('description') }}</textarea>
                    </div>

                    {{-- Persons Involved --}}
                    <div style="margin-bottom:20px;">
                        <label class="form-label" style="color:rgba(255,255,255,.75);">
                            Persons Involved
                            <span style="color:rgba(255,255,255,.35);font-weight:400;margin-left:4px;">(Optional)</span>
                        </label>
                        <input type="text" name="persons_involved"
                            value="{{ old('persons_involved') }}"
                            placeholder="Names of persons involved, witnesses, etc."
                            style="width:100%;padding:11px 14px;border:1.5px solid rgba(255,255,255,.15);border-radius:8px;font-size:14.5px;color:#fff;background:rgba(255,255,255,.08);outline:none;font-family:Inter,sans-serif;transition:all .2s;"
                            onfocus="this.style.borderColor='var(--blue-400)';this.style.background='rgba(43,126,237,.1)'"
                            onblur="this.style.borderColor='rgba(255,255,255,.15)';this.style.background='rgba(255,255,255,.08)'">
                    </div>

                    {{-- File Upload --}}
                    <div style="margin-bottom:28px;">
                        <label class="form-label" style="color:rgba(255,255,255,.75);">
                            Attach Evidence
                            <span style="color:rgba(255,255,255,.35);font-weight:400;margin-left:4px;">(Optional)</span>
                        </label>
                        <div class="upload-zone" id="upload-zone"
                            onclick="document.getElementById('file-input').click()"
                            x-data="{ fileName: '' }">
                            <input type="file" id="file-input" name="attachment"
                                accept="image/*,.pdf,.doc,.docx"
                                style="display:none;"
                                onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''; document.getElementById('file-placeholder').style.display = this.files[0] ? 'none' : 'block'; document.getElementById('file-selected').style.display = this.files[0] ? 'flex' : 'none';">

                            {{-- Placeholder --}}
                            <div id="file-placeholder">
                                <div style="font-size:36px;margin-bottom:10px;">📎</div>
                                <div style="font-size:14px;font-weight:600;color:rgba(255,255,255,.7);margin-bottom:4px;">
                                    Click to upload evidence
                                </div>
                                <div style="font-size:12px;color:rgba(255,255,255,.35);">
                                    Photos, PDF, Word documents — Max 10MB
                                </div>
                            </div>

                            {{-- File Selected --}}
                            <div id="file-selected" style="display:none;align-items:center;gap:12px;">
                                <span style="font-size:28px;">📄</span>
                                <div>
                                    <div id="file-name" style="font-size:14px;font-weight:600;color:#4ade80;"></div>
                                    <div style="font-size:12px;color:rgba(255,255,255,.4);margin-top:2px;">
                                        File attached — click to change
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Form Footer --}}
                <div style="padding:20px 28px;border-top:1px solid rgba(255,255,255,.08);display:flex;gap:12px;background:rgba(0,0,0,.15);">
                    <a href="/dashboard"
                        style="flex:1;display:flex;align-items:center;justify-content:center;padding:12px;border-radius:8px;border:1.5px solid rgba(255,255,255,.15);color:rgba(255,255,255,.6);font-size:14px;font-weight:600;text-decoration:none;transition:all .2s;font-family:Inter,sans-serif;"
                        onmouseover="this.style.background='rgba(255,255,255,.08)'"
                        onmouseout="this.style.background='transparent'">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary" style="flex:3;border-radius:8px;font-size:15px;">
                        🚀 Submit Report
                    </button>
                </div>

            </form>
        </div>

    </div>

</x-app-layout>