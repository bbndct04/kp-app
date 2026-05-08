<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BlotterLink — Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --blue-50:  #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f0f4fc;
            font-family: Inter, sans-serif;
            min-height: 100vh;
        }

        /* ── Layout ── */
        .page-grid {
            display: grid;
            grid-template-columns: 400px 1fr;
            min-height: 100vh;
        }

        /* ── Left Panel ── */
        .auth-panel {
            background: linear-gradient(160deg, #0b1b4d 0%, #102060 50%, #0e2272 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            position: relative;
            overflow: hidden;
        }

        .auth-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(59,130,246,.18) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 80%, rgba(37,99,235,.12) 0%, transparent 60%);
            pointer-events: none;
        }

        .auth-panel-inner {
            position: relative;
            z-index: 1;
            text-align: center;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* ── Logos ── */
        .logos-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .logo-circle {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(255,255,255,.35);
            flex-shrink: 0;
        }

        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .logo-divider {
            width: 1.5px;
            height: 52px;
            background: rgba(255,255,255,.2);
            border-radius: 99px;
            flex-shrink: 0;
        }

        @keyframes bounceReg {
            0%, 100% { transform: translateY(0px); }
            30%       { transform: translateY(-16px); }
            50%       { transform: translateY(-7px); }
            70%       { transform: translateY(-12px); }
        }

        .bounce-1 { animation: bounceReg 2.8s ease-in-out 1.2s infinite; }
        .bounce-2 { animation: bounceReg 2.8s ease-in-out 1.5s infinite; }

        /* ── Brand Title ── */
        .brand-title {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.5px;
            margin-bottom: 6px;
        }

        .brand-sub {
            font-size: 13px;
            color: rgba(255,255,255,.45);
            margin-bottom: 32px;
        }

        /* ── Step Sidebar ── */
        .step-list {
            text-align: left;
            width: fit-content;
            margin: 0 auto;
        }

        .reg-step-side {
            display: flex;
            align-items: center;
            gap: 14px;
            opacity: .4;
            transition: all .3s;
        }

        .reg-step-side.active { opacity: 1; }
        .reg-step-side.done   { opacity: .75; }

        .reg-step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,.7);
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            transition: all .3s;
        }

        .reg-step-side.active .reg-step-num {
            background: var(--blue-500);
            border-color: var(--blue-400);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(43,126,237,.25);
        }

        .reg-step-side.done .reg-step-num {
            background: rgba(13,122,78,.7);
            border-color: rgba(13,122,78,.9);
            color: #fff;
        }

        .reg-step-label { color: #fff; font-size: 14px; font-weight: 600; }
        .reg-step-sub   { color: rgba(255,255,255,.45); font-size: 12px; margin-top: 1px; }

        .reg-step-line {
            width: 2px;
            height: 28px;
            background: rgba(255,255,255,.12);
            margin: 4px 0 4px 15px;
            border-radius: 2px;
            align-self: flex-start;
        }

        /* ── Right Side ── */
        .form-side {
            background: #f0f4fc;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 52px;
            overflow-y: auto;
            min-height: 100vh;
        }

        .form-inner {
            width: 100%;
            max-width: 580px;
        }

        /* ── Form elements ── */
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #424966;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d4daea;
            border-radius: 8px;
            font-size: 14px;
            font-family: Inter, sans-serif;
            color: #1e2130;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-input:focus {
            border-color: var(--blue-400);
            box-shadow: 0 0 0 3px rgba(96,165,250,.15);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: var(--blue-600);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            font-family: Inter, sans-serif;
            transition: background .2s, box-shadow .2s;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--blue-700);
            box-shadow: 0 4px 14px rgba(37,99,235,.35);
        }

        .btn-ghost {
            background: none;
            border: 1.5px solid #d4daea;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #5e6882;
            cursor: pointer;
            font-family: Inter, sans-serif;
            transition: border-color .2s;
        }

        .btn-ghost:hover { border-color: var(--blue-400); color: var(--blue-600); }

        /* ── Upload Zone ── */
        .upload-zone-reg {
            border: 2px dashed #d4daea;
            border-radius: 14px;
            padding: 32px 24px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: #f8f9ff;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-zone-reg:hover {
            border-color: var(--blue-400);
            background: var(--blue-50);
        }

        /* ── Input with lock ── */
        .input-lock-wrap { position: relative; }

        .lock-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            display: none;
        }

        .lock-icon.show { display: block; }

        .autofilled {
            background: #fffbeb !important;
            border-color: #f59e0b !important;
        }

        /* ── Terms ── */
        .terms-box {
            border: 1.5px solid #e0e4ee;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .terms-header {
            background: #f5f6fa;
            padding: 11px 14px;
            font-size: 13px;
            font-weight: 700;
            color: #424966;
            border-bottom: 1px solid #e0e4ee;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .terms-body {
            padding: 14px;
            max-height: 160px;
            overflow-y: auto;
            font-size: 13px;
            color: #5e6882;
            line-height: 1.7;
        }

        .terms-body p { margin-bottom: 10px; }

        .terms-hint {
            padding: 8px 14px;
            background: #fff8e1;
            color: #c25b00;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            border-top: 1px solid rgba(194,91,0,.15);
        }

        .terms-hint.unlocked { background: #f0fdf4; color: #0d7a4e; }

        /* ── Scan status ── */
        .scan-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            margin-top: 10px;
        }

        .scan-status.scanning { background: var(--blue-50); color: var(--blue-700); border: 1px solid var(--blue-200); }
        .scan-status.success  { background: #f0fdf4; color: #0d7a4e; border: 1px solid rgba(13,122,78,.2); }
        .scan-status.error    { background: #fef2f2; color: #b91c1c; border: 1px solid rgba(185,28,28,.2); }

        @keyframes spin { to { transform: rotate(360deg); } }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid var(--blue-200);
            border-top-color: var(--blue-600);
            border-radius: 50%;
            animation: spin .7s linear infinite;
            flex-shrink: 0;
        }

        /* ── Custom Checkbox ── */
        .custom-check-wrap {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
        }

        .custom-check {
            width: 20px;
            height: 20px;
            border-radius: 5px;
            border: 2px solid #d4daea;
            background: #f5f6fa;
            flex-shrink: 0;
            margin-top: 1px;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-check.checked {
            background: var(--blue-600);
            border-color: var(--blue-600);
        }

        .custom-check.checked::after {
            content: '';
            width: 5px;
            height: 9px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg) translateY(-1px);
            display: block;
        }

        .custom-check.disabled { opacity: .4; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="page-grid">

    {{-- ═══════════════════════════════
         LEFT PANEL
    ═══════════════════════════════ --}}
    <div class="auth-panel">
        <div class="auth-panel-inner">

            {{-- Dual Logos --}}
            <div class="logos-row">
                <div class="logo-circle bounce-1">
                    <img src="{{ asset('images/blotterlink-logo.png') }}" alt="BlotterLink">
                </div>
                <div class="logo-divider"></div>
                <div class="logo-circle bounce-2" style="background:#fff;">
                    <img src="{{ asset('images/barangay-logo.jpg') }}" alt="Barangay New Kababae">
                </div>
            </div>

            {{-- Brand --}}
            <div class="brand-title">BlotterLink</div>
            <div class="brand-sub">Barangay Complaint &amp; Incident System</div>

            {{-- Step Progress --}}
            <div class="step-list" id="step-sidebar">
                <div class="reg-step-side active" id="side-1">
                    <div class="reg-step-num" id="snum-1">1</div>
                    <div>
                        <div class="reg-step-label">ID Verification</div>
                        <div class="reg-step-sub">Upload your valid ID</div>
                    </div>
                </div>
                <div class="reg-step-line"></div>
                <div class="reg-step-side" id="side-2">
                    <div class="reg-step-num" id="snum-2">2</div>
                    <div>
                        <div class="reg-step-label">Face Photo</div>
                        <div class="reg-step-sub">Take or upload a selfie</div>
                    </div>
                </div>
                <div class="reg-step-line"></div>
                <div class="reg-step-side" id="side-3">
                    <div class="reg-step-num" id="snum-3">3</div>
                    <div>
                        <div class="reg-step-label">Your Details</div>
                        <div class="reg-step-sub">Review &amp; complete info</div>
                    </div>
                </div>
                <div class="reg-step-line"></div>
                <div class="reg-step-side" id="side-4">
                    <div class="reg-step-num" id="snum-4">4</div>
                    <div>
                        <div class="reg-step-label">Terms &amp; Account</div>
                        <div class="reg-step-sub">Agree and set password</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════
         RIGHT FORM SIDE
    ═══════════════════════════════ --}}
    <div class="form-side">
        <div class="form-inner">

            <div style="margin-bottom:24px;">
                <h2 style="font-size:24px;font-weight:700;color:#0e1e5b;letter-spacing:-.4px;margin-bottom:4px;" id="step-title">
                    Step 1 — Upload Valid ID
                </h2>
                <p style="font-size:14px;color:#5e6882;" id="step-sub">
                    Upload a clear photo of your government-issued ID. We'll automatically fill in your details.
                </p>
            </div>

            {{-- Laravel Errors --}}
            @if($errors->any())
            <div style="background:#fee2e2;color:#b91c1c;padding:12px 14px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="reg-form" enctype="multipart/form-data">
                @csrf

                {{-- Hidden fields --}}
                <input type="hidden" name="name"                  id="h-name">
                <input type="hidden" name="email"                 id="h-email">
                <input type="hidden" name="password"              id="h-password">
                <input type="hidden" name="password_confirmation" id="h-password-confirm">
                <input type="hidden" name="contact"               id="h-contact">
                <input type="hidden" name="address"               id="h-address">

                {{-- ═══════════════
                     STEP 1: ID Upload
                ═══════════════ --}}
                <div id="step-1">
                    <div class="upload-zone-reg" id="id-zone" onclick="document.getElementById('id-file').click()">
                        <input type="file" id="id-file" accept="image/*" style="display:none" onchange="handleIDUpload(this)">

                        <div id="id-placeholder">
                            <div style="width:72px;height:72px;background:var(--blue-100);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                <svg width="32" height="32" fill="none" stroke="var(--blue-600)" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                                    <circle cx="8" cy="10" r="1.5"/>
                                    <path d="m2 15 5-5 4 4 3-3 5 5"/>
                                </svg>
                            </div>
                            <div style="font-size:15px;font-weight:700;color:#1e2130;margin-bottom:6px;">Click to upload your valid ID</div>
                            <div style="font-size:13px;color:#8590a8;margin-bottom:4px;">PhilSys, Driver's License, Passport, UMID, Voter's ID</div>
                            <div style="font-size:12px;color:#b0b9cc;">JPG, PNG — Max 10MB</div>
                        </div>

                        <div id="id-preview-wrap" style="display:none;width:100%;">
                            <img id="id-preview" src="" alt="ID" style="max-width:100%;max-height:200px;border-radius:10px;object-fit:contain;display:block;margin:0 auto;">
                            <div id="scan-scanning" class="scan-status scanning" style="display:none;">
                                <div class="spinner"></div>
                                <span>Reading your ID with AI — please wait...</span>
                            </div>
                            <div id="scan-success" class="scan-status success" style="display:none;">
                                <span>✓</span><span>ID scanned! Your details have been filled in automatically.</span>
                            </div>
                            <div id="scan-error" class="scan-status error" style="display:none;">
                                <span>⚠</span><span id="scan-error-msg">Could not read ID. Please try a clearer photo.</span>
                            </div>
                            <button type="button" onclick="event.stopPropagation();resetID()"
                                style="margin-top:10px;background:none;border:1.5px solid #d4daea;border-radius:6px;padding:6px 14px;font-size:13px;color:#5e6882;cursor:pointer;font-family:Inter,sans-serif;">
                                Change ID
                            </button>
                        </div>
                    </div>

                    <div style="margin-top:18px;display:flex;justify-content:space-between;align-items:center;">
                        <button type="button" onclick="skipID()" class="btn-ghost">
                            Skip — Fill manually
                        </button>
                        <button type="button" id="btn-step1-next" onclick="goStep(2)" disabled
                            class="btn-primary" style="width:auto;padding:11px 28px;opacity:.5;cursor:not-allowed;">
                            Next — Take Selfie ›
                        </button>
                    </div>
                </div>

                {{-- ═══════════════
                     STEP 2: Face Photo
                ═══════════════ --}}
                <div id="step-2" style="display:none;">
                    <div class="upload-zone-reg" id="face-zone" onclick="document.getElementById('face-file').click()">
                        <input type="file" id="face-file" accept="image/*" style="display:none" onchange="handleFaceUpload(this)">

                        <div id="face-placeholder">
                            <div style="width:72px;height:72px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                <svg width="32" height="32" fill="none" stroke="#0d7a4e" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <div style="font-size:15px;font-weight:700;color:#1e2130;margin-bottom:6px;">Upload your selfie / face photo</div>
                            <div style="font-size:13px;color:#8590a8;">Make sure your face is clearly visible and well-lit</div>
                        </div>

                        <div id="face-preview-wrap" style="display:none;text-align:center;">
                            <img id="face-preview" src="" alt="Face" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid #c5dffe;display:block;margin:0 auto 10px;">
                            <div id="face-status" class="scan-status success" style="display:none;">
                                <span>✓</span><span>Face photo uploaded!</span>
                            </div>
                            <br>
                            <button type="button" onclick="event.stopPropagation();resetFace()"
                                style="margin-top:8px;background:none;border:1.5px solid #d4daea;border-radius:6px;padding:6px 14px;font-size:13px;color:#5e6882;cursor:pointer;font-family:Inter,sans-serif;">
                                Change Photo
                            </button>
                        </div>
                    </div>

                    <div style="margin-top:18px;display:flex;justify-content:space-between;">
                        <button type="button" onclick="goStep(1)" class="btn-ghost">‹ Back</button>
                        <button type="button" id="btn-step2-next" onclick="goStep(3)" disabled
                            class="btn-primary" style="width:auto;padding:11px 28px;opacity:.5;cursor:not-allowed;">
                            Next — Review Details ›
                        </button>
                    </div>
                </div>

                {{-- ═══════════════
                     STEP 3: Personal Info
                ═══════════════ --}}
                <div id="step-3" style="display:none;">
                    <div style="background:var(--blue-50);border:1px solid var(--blue-200);border-radius:8px;padding:10px 14px;margin-bottom:18px;font-size:13px;color:var(--blue-700);display:flex;gap:8px;">
                        <span>🔒</span>
                        <span>Fields marked with 🔒 were auto-filled from your ID. You may still edit them.</span>
                    </div>

                    {{-- First & Last Name --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                        <div>
                            <label class="form-label">First Name *</label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="text" id="f-firstname" placeholder="First name" required>
                                <span class="lock-icon" id="lock-fn">🔒</span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Last Name *</label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="text" id="f-lastname" placeholder="Last name" required>
                                <span class="lock-icon" id="lock-ln">🔒</span>
                            </div>
                        </div>
                    </div>

                    {{-- Middle Name & DOB --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                        <div>
                            <label class="form-label">Middle Name</label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="text" id="f-middlename" placeholder="Middle name">
                                <span class="lock-icon" id="lock-mn">🔒</span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Date of Birth *</label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="date" id="f-dob" required>
                                <span class="lock-icon" id="lock-dob">🔒</span>
                            </div>
                        </div>
                    </div>

                    {{-- Sex & Contact --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                        <div>
                            <label class="form-label">Sex</label>
                            <div class="input-lock-wrap">
                                <select class="form-input" id="f-sex">
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <span class="lock-icon" id="lock-sex">🔒</span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Contact Number</label>
                            <input class="form-input" type="tel" id="f-contact" placeholder="09XX-XXX-XXXX">
                        </div>
                    </div>

                    {{-- Address --}}
                    <div style="margin-bottom:16px;">
                        <label class="form-label">Home Address *</label>
                        <div class="input-lock-wrap">
                            <input class="form-input" type="text" id="f-address" placeholder="Purok, Street, Barangay" required>
                            <span class="lock-icon" id="lock-addr">🔒</span>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div style="margin-bottom:16px;">
                        <label class="form-label">Email Address *</label>
                        <input class="form-input" type="email" id="f-email" placeholder="your@gmail.com" required>
                        <div style="font-size:12px;color:#8590a8;margin-top:4px;">
                            📧 A verification link will be sent to this email after registration.
                        </div>
                    </div>

                    <div style="display:flex;justify-content:space-between;margin-top:8px;">
                        <button type="button" onclick="goStep(2)" class="btn-ghost">‹ Back</button>
                        <button type="button" onclick="validateStep3()" class="btn-primary" style="width:auto;padding:11px 28px;">
                            Next — Terms &amp; Password ›
                        </button>
                    </div>
                </div>

                {{-- ═══════════════
                     STEP 4: Terms + Password
                ═══════════════ --}}
                <div id="step-4" style="display:none;">

                    <div class="terms-box">
                        <div class="terms-header">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            Terms of Service &amp; Privacy Policy
                        </div>
                        <div class="terms-body" id="terms-body" onscroll="checkScroll()">
                            <p><strong>1. Acceptance of Terms</strong><br>By registering for a BlotterLink account, you agree to be bound by these Terms of Service. If you do not agree, please do not use this system.</p>
                            <p><strong>2. Purpose of the System</strong><br>BlotterLink is a barangay complaints and incident reporting system designed exclusively for residents to report community concerns to barangay officials.</p>
                            <p><strong>3. User Responsibilities</strong><br>You agree to provide accurate and truthful information. Filing false, misleading, or malicious complaints is strictly prohibited and may result in account suspension and legal action.</p>
                            <p><strong>4. Privacy and Data Use</strong><br>Personal information collected during registration is used solely for identity verification and account creation. Your data will not be shared with third parties without consent, in compliance with the Data Privacy Act of 2012 (RA 10173).</p>
                            <p><strong>5. ID Verification</strong><br>Your government-issued ID is scanned only to pre-fill your registration form. The image is processed temporarily and is not permanently stored in a form that can identify you outside this service.</p>
                            <p><strong>6. Prohibited Conduct</strong><br>You must not submit false complaints, impersonate another person, or use the system for any unlawful purpose.</p>
                            <p><strong>7. Account Suspension</strong><br>The barangay administrator reserves the right to suspend accounts found in violation of these terms.</p>
                            <p>By checking the box below, you confirm that you have read, understood, and agree to these Terms of Service and Privacy Policy.</p>
                        </div>
                        <div class="terms-hint" id="terms-hint">
                            ↓ Scroll down to read all terms before agreeing
                        </div>
                    </div>

                    <div style="margin-bottom:20px;" onclick="toggleTerms()">
                        <div class="custom-check-wrap">
                            <div class="custom-check disabled" id="terms-check-box"></div>
                            <span style="font-size:13.5px;color:#5e6882;line-height:1.5;cursor:pointer;">
                                I have read and agree to the <strong style="color:var(--blue-600);">Terms of Service</strong> and <strong style="color:var(--blue-600);">Privacy Policy</strong>
                            </span>
                        </div>
                        <div id="terms-lock-note" style="font-size:12px;color:#b0b9cc;margin-top:5px;margin-left:30px;display:flex;align-items:center;gap:4px;">
                            🔒 Scroll and read all terms above to unlock
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                        <div>
                            <label class="form-label">Password *</label>
                            <input class="form-input" type="password" id="f-password" placeholder="Min 8 characters" required minlength="8">
                        </div>
                        <div>
                            <label class="form-label">Confirm Password *</label>
                            <input class="form-input" type="password" id="f-password-confirm" placeholder="Repeat password" required>
                        </div>
                    </div>

                    <button type="submit" id="reg-submit-btn" onclick="prepareSubmit(event)"
                        class="btn-primary" disabled
                        style="opacity:.5;cursor:not-allowed;margin-bottom:8px;">
                        🚀 Create Account
                    </button>
                    <div id="submit-hint" style="font-size:12.5px;color:#b0b9cc;text-align:center;">
                        You must agree to the terms to create your account.
                    </div>

                    <div style="margin-top:14px;">
                        <button type="button" onclick="goStep(3)" class="btn-ghost" style="width:auto;padding:10px 20px;">‹ Back</button>
                    </div>
                </div>

            </form>

            <div style="text-align:center;margin-top:20px;font-size:14px;color:#5e6882;">
                Already have an account?
                <a href="{{ route('login') }}" style="color:var(--blue-600);font-weight:600;text-decoration:none;margin-left:4px;">Sign in</a>
            </div>

        </div>
    </div>
</div>

{{-- GSAP --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
// ─── Step Titles ───────────────────────────────────────────────
const titles = {
    1: ['Step 1 — Upload Valid ID',      "Upload a clear photo of your government-issued ID. We'll automatically fill in your details."],
    2: ['Step 2 — Face Verification',    'Upload a selfie or face photo for identity verification.'],
    3: ['Step 3 — Review Your Details',  'Review and complete your personal information.'],
    4: ['Step 4 — Terms & Password',     'Read and accept the Terms of Service, then set your password.'],
};

// ─── State ─────────────────────────────────────────────────────
let state = { step: 1, idScanned: false, faceUploaded: false, termsRead: false, termsChecked: false };
let idFaceBase64 = null;
let faceBase64   = null;

// ─── Go to Step ────────────────────────────────────────────────
function goStep(n) {
    [1,2,3,4].forEach(i => {
        document.getElementById('step-' + i).style.display = i === n ? 'block' : 'none';
        const side = document.getElementById('side-' + i);
        side.className = 'reg-step-side' + (i === n ? ' active' : i < n ? ' done' : '');
        document.getElementById('snum-' + i).innerHTML = i < n ? '✓' : i;
    });
    state.step = n;
    document.getElementById('step-title').textContent = titles[n][0];
    document.getElementById('step-sub').textContent   = titles[n][1];
    gsap.from('#step-' + n, { duration:.4, y:16, opacity:0, ease:'power2.out' });
}

// ─── ID Upload ─────────────────────────────────────────────────
async function handleIDUpload(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = async (e) => {
        const dataUrl = e.target.result;
        const base64  = dataUrl.split(',')[1];
        const mime    = file.type;
        document.getElementById('id-preview').src = dataUrl;
        document.getElementById('id-placeholder').style.display    = 'none';
        document.getElementById('id-preview-wrap').style.display   = 'block';
        document.getElementById('scan-scanning').style.display     = 'flex';
        document.getElementById('scan-success').style.display      = 'none';
        document.getElementById('scan-error').style.display        = 'none';
        try {
            const data = await scanID(base64, mime);
            applyIDData(data);
            if (data.face) idFaceBase64 = data.face;
            document.getElementById('scan-scanning').style.display = 'none';
            document.getElementById('scan-success').style.display  = 'flex';
            state.idScanned = true;
            unlockNext('btn-step1-next');
        } catch(err) {
            document.getElementById('scan-scanning').style.display = 'none';
            document.getElementById('scan-error').style.display    = 'flex';
            document.getElementById('scan-error-msg').textContent  = err.message;
        }
    };
    reader.readAsDataURL(file);
}

const ID_ANALYZER_KEY = 'm8TvlUj7lHfdSv18NgpWkORXTgSf64xa';

async function scanID(base64, mime) {
    const res = await fetch('https://api2.idanalyzer.com/scan', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-API-KEY': ID_ANALYZER_KEY },
        body: JSON.stringify({ document: base64, saveFile: false, outputImage: false })
    }).catch(() => { throw new Error('Network error. Check your internet connection.'); });

    if (!res.ok) {
        if (res.status === 401) throw new Error('Invalid API key. Please contact support.');
        throw new Error('ID Analyzer error (' + res.status + '). Please try again.');
    }

    const d = await res.json();
    if (d.error) throw new Error(d.error.message || 'Could not read ID. Please upload a clearer photo.');

    const r = d.result || {};
    return {
        firstName:   r.firstName  || r.givenName || '',
        lastName:    r.lastName   || r.surname   || '',
        middleName:  r.middleName || '',
        dateOfBirth: r.dob        ? formatDOB(r.dob) : '',
        sex:         r.sex        ? (r.sex.toLowerCase().startsWith('m') ? 'Male' : 'Female') : '',
        address:     r.address1   || r.address   || '',
    };
}

function formatDOB(dob) {
    if (!dob) return '';
    return dob.replace(/\//g, '-');
}

function applyIDData(data) {
    const map = [
        { id: 'f-firstname',  key: 'firstName',   lock: 'lock-fn'   },
        { id: 'f-lastname',   key: 'lastName',    lock: 'lock-ln'   },
        { id: 'f-middlename', key: 'middleName',  lock: 'lock-mn'   },
        { id: 'f-dob',        key: 'dateOfBirth', lock: 'lock-dob'  },
        { id: 'f-address',    key: 'address',     lock: 'lock-addr' },
    ];
    map.forEach(({ id, key, lock }) => {
        if (data[key]) {
            const el = document.getElementById(id);
            if (el) { el.value = data[key]; el.classList.add('autofilled'); }
            const lk = document.getElementById(lock);
            if (lk) lk.classList.add('show');
        }
    });
    if (data.sex) {
        const s = document.getElementById('f-sex');
        s.value = data.sex;
        s.classList.add('autofilled');
        document.getElementById('lock-sex').classList.add('show');
    }
}

function skipID() {
    state.idScanned = false;
    goStep(2);
}

function resetID() {
    document.getElementById('id-file').value = '';
    document.getElementById('id-placeholder').style.display  = 'block';
    document.getElementById('id-preview-wrap').style.display = 'none';
    state.idScanned = false;
    lockBtn('btn-step1-next');
}

// ─── Face Upload ───────────────────────────────────────────────
async function verifyFace(fb, idb) {
    if (!idb) return null;
    const res = await fetch('https://api2.idanalyzer.com/face', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-API-KEY': ID_ANALYZER_KEY },
        body: JSON.stringify({ face1: fb, face2: idb })
    }).catch(() => null);
    if (!res || !res.ok) return null;
    const d = await res.json();
    return d.confidence || null;
}

function handleFaceUpload(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = async (e) => {
        const dataUrl = e.target.result;
        faceBase64 = dataUrl.split(',')[1];
        document.getElementById('face-preview').src = dataUrl;
        document.getElementById('face-placeholder').style.display  = 'none';
        document.getElementById('face-preview-wrap').style.display = 'block';
        document.getElementById('face-status').style.display = 'flex';
        document.getElementById('face-status').className = 'scan-status scanning';
        document.getElementById('face-status').innerHTML = '<div class="spinner"></div><span>Verifying face — please wait...</span>';

        if (idFaceBase64) {
            const confidence = await verifyFace(faceBase64, idFaceBase64);
            if (confidence !== null) {
                const pct = Math.round(confidence * 100);
                if (pct >= 60) {
                    document.getElementById('face-status').className = 'scan-status success';
                    document.getElementById('face-status').innerHTML = `✓ Face matched with ID — ${pct}% confidence`;
                } else {
                    document.getElementById('face-status').className = 'scan-status error';
                    document.getElementById('face-status').innerHTML = `⚠ Face match too low (${pct}%). Please use a clearer selfie.`;
                    state.faceUploaded = false;
                    lockBtn('btn-step2-next');
                    return;
                }
            } else {
                document.getElementById('face-status').className = 'scan-status success';
                document.getElementById('face-status').innerHTML = '✓ Face photo uploaded!';
            }
        } else {
            document.getElementById('face-status').className = 'scan-status success';
            document.getElementById('face-status').innerHTML = '✓ Face photo uploaded!';
        }

        state.faceUploaded = true;
        unlockNext('btn-step2-next');
    };
    reader.readAsDataURL(file);
}

function resetFace() {
    document.getElementById('face-file').value = '';
    document.getElementById('face-placeholder').style.display  = 'block';
    document.getElementById('face-preview-wrap').style.display = 'none';
    state.faceUploaded = false;
    lockBtn('btn-step2-next');
}

// ─── Step 3 Validate ───────────────────────────────────────────
function validateStep3() {
    const fn = document.getElementById('f-firstname').value.trim();
    const ln = document.getElementById('f-lastname').value.trim();
    const em = document.getElementById('f-email').value.trim();
    const db = document.getElementById('f-dob').value;
    const ad = document.getElementById('f-address').value.trim();
    if (!fn || !ln || !em || !db || !ad) {
        alert('Please fill in all required fields (First Name, Last Name, Email, Date of Birth, Address).');
        return;
    }
    if (!em.includes('@')) { alert('Please enter a valid email address.'); return; }
    goStep(4);
}

// ─── Terms ─────────────────────────────────────────────────────
function checkScroll() {
    const el = document.getElementById('terms-body');
    const atBottom = el.scrollTop + el.clientHeight >= el.scrollHeight - 10;
    if (atBottom && !state.termsRead) {
        state.termsRead = true;
        document.getElementById('terms-check-box').classList.remove('disabled');
        document.getElementById('terms-hint').className = 'terms-hint unlocked';
        document.getElementById('terms-hint').innerHTML = "✓ You've read the terms — click below to agree";
        document.getElementById('terms-lock-note').style.display = 'none';
    }
}

function toggleTerms() {
    if (!state.termsRead) return;
    state.termsChecked = !state.termsChecked;
    const box = document.getElementById('terms-check-box');
    const btn = document.getElementById('reg-submit-btn');
    const hnt = document.getElementById('submit-hint');
    box.classList.toggle('checked', state.termsChecked);
    btn.disabled      = !state.termsChecked;
    btn.style.opacity = state.termsChecked ? '1' : '.5';
    btn.style.cursor  = state.termsChecked ? 'pointer' : 'not-allowed';
    hnt.style.display = state.termsChecked ? 'none' : 'block';
}

// ─── Submit ────────────────────────────────────────────────────
function prepareSubmit(e) {
    if (!state.termsChecked) { e.preventDefault(); return; }
    const pass = document.getElementById('f-password').value;
    const conf = document.getElementById('f-password-confirm').value;
    if (pass !== conf)   { e.preventDefault(); alert('Passwords do not match!'); return; }
    if (pass.length < 8) { e.preventDefault(); alert('Password must be at least 8 characters.'); return; }
    const fn = document.getElementById('f-firstname').value.trim();
    const ln = document.getElementById('f-lastname').value.trim();
    document.getElementById('h-name').value             = fn + ' ' + ln;
    document.getElementById('h-email').value            = document.getElementById('f-email').value.trim();
    document.getElementById('h-password').value         = pass;
    document.getElementById('h-password-confirm').value = conf;
    document.getElementById('h-contact').value          = document.getElementById('f-contact').value;
    document.getElementById('h-address').value          = document.getElementById('f-address').value;
}

// ─── Helpers ───────────────────────────────────────────────────
function unlockNext(id) {
    const b = document.getElementById(id);
    b.disabled = false; b.style.opacity = '1'; b.style.cursor = 'pointer';
}
function lockBtn(id) {
    const b = document.getElementById(id);
    b.disabled = true; b.style.opacity = '.5'; b.style.cursor = 'not-allowed';
}

// ─── GSAP Entrance ─────────────────────────────────────────────
gsap.from('.auth-panel-inner', { duration:.8, x:-30, opacity:0, ease:'power2.out' });
gsap.from('#step-1',           { duration:.8, x:30,  opacity:0, ease:'power2.out', delay:.1 });
</script>

</body>
</html>