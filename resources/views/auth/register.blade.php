<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KP App — Register</title>
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
        body { background: #f0f4fc; font-family: Inter, sans-serif; min-height: 100vh; }
        .page-grid { display: grid; grid-template-columns: 400px 1fr; min-height: 100vh; }
        .auth-panel { background: linear-gradient(160deg, #0b1b4d 0%, #102060 50%, #0e2272 100%); display: flex; align-items: center; justify-content: center; padding: 40px 32px; position: relative; overflow: hidden; }
        .auth-panel::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 20% 20%, rgba(59,130,246,.18) 0%, transparent 60%), radial-gradient(ellipse at 80% 80%, rgba(37,99,235,.12) 0%, transparent 60%); pointer-events: none; }
        .auth-panel-inner { position: relative; z-index: 1; text-align: center; width: 100%; display: flex; flex-direction: column; align-items: center; }
        .logos-row { display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 24px; }
        .logo-circle { width: 78px; height: 78px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255,255,255,.35); flex-shrink: 0; }
        .logo-circle img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .logo-divider { width: 1.5px; height: 52px; background: rgba(255,255,255,.2); border-radius: 99px; flex-shrink: 0; }
        @keyframes bounceReg { 0%, 100% { transform: translateY(0px); } 30% { transform: translateY(-16px); } 50% { transform: translateY(-7px); } 70% { transform: translateY(-12px); } }
        .bounce-1 { animation: bounceReg 2.8s ease-in-out 1.2s infinite; }
        .bounce-2 { animation: bounceReg 2.8s ease-in-out 1.5s infinite; }
        .brand-title { font-size: 22px; font-weight: 700; color: #fff; letter-spacing: -.5px; margin-bottom: 6px; }
        .brand-sub { font-size: 13px; color: rgba(255,255,255,.45); margin-bottom: 32px; }
        .step-list { text-align: left; width: fit-content; margin: 0 auto; }
        .reg-step-side { display: flex; align-items: center; gap: 14px; opacity: .4; transition: all .3s; }
        .reg-step-side.active { opacity: 1; }
        .reg-step-side.done   { opacity: .75; }
        .reg-step-num { width: 32px; height: 32px; border-radius: 50%; border: 2px solid rgba(255,255,255,.3); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.7); font-size: 13px; font-weight: 700; flex-shrink: 0; transition: all .3s; }
        .reg-step-side.active .reg-step-num { background: var(--blue-500); border-color: var(--blue-400); color: #fff; box-shadow: 0 0 0 4px rgba(43,126,237,.25); }
        .reg-step-side.done .reg-step-num { background: rgba(13,122,78,.7); border-color: rgba(13,122,78,.9); color: #fff; }
        .reg-step-label { color: #fff; font-size: 14px; font-weight: 600; }
        .reg-step-sub   { color: rgba(255,255,255,.45); font-size: 12px; margin-top: 1px; }
        .reg-step-line { width: 2px; height: 28px; background: rgba(255,255,255,.12); margin: 4px 0 4px 15px; border-radius: 2px; align-self: flex-start; }
        .form-side { background: #f0f4fc; display: flex; align-items: flex-start; justify-content: center; padding: 40px 52px; overflow-y: auto; min-height: 100vh; }
        .form-inner { width: 100%; max-width: 580px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #424966; margin-bottom: 6px; }
        .form-input { width: 100%; padding: 10px 14px; border: 1.5px solid #d4daea; border-radius: 8px; font-size: 14px; font-family: Inter, sans-serif; color: #1e2130; background: #fff; outline: none; transition: border-color .2s, box-shadow .2s; }
        .form-input:focus { border-color: var(--blue-400); box-shadow: 0 0 0 3px rgba(96,165,250,.15); }
        .btn-primary { width: 100%; padding: 12px; background: var(--blue-600); color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; font-family: Inter, sans-serif; transition: background .2s, box-shadow .2s; }
        .btn-primary:hover:not(:disabled) { background: var(--blue-700); box-shadow: 0 4px 14px rgba(37,99,235,.35); }
        .btn-ghost { background: none; border: 1.5px solid #d4daea; border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 500; color: #5e6882; cursor: pointer; font-family: Inter, sans-serif; transition: border-color .2s; }
        .btn-ghost:hover { border-color: var(--blue-400); color: var(--blue-600); }
        .upload-zone-reg { border: 2px dashed #d4daea; border-radius: 14px; padding: 32px 24px; text-align: center; cursor: pointer; transition: all .2s; background: #f8f9ff; min-height: 180px; display: flex; align-items: center; justify-content: center; }
        .upload-zone-reg:hover { border-color: var(--blue-400); background: var(--blue-50); }
        .input-lock-wrap { position: relative; }
        .lock-icon { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 14px; display: none; }
        .lock-icon.show { display: block; }
        .autofilled { background: #fffbeb !important; border-color: #f59e0b !important; }
        .terms-box { border: 1.5px solid #e0e4ee; border-radius: 10px; overflow: hidden; margin-bottom: 16px; }
        .terms-header { background: #f5f6fa; padding: 11px 14px; font-size: 13px; font-weight: 700; color: #424966; border-bottom: 1px solid #e0e4ee; display: flex; align-items: center; gap: 8px; }
        .terms-body { padding: 14px; max-height: 200px; overflow-y: auto; font-size: 13px; color: #5e6882; line-height: 1.7; }
        .terms-body p { margin-bottom: 10px; }
        .terms-hint { padding: 8px 14px; background: #fff8e1; color: #c25b00; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 6px; border-top: 1px solid rgba(194,91,0,.15); }
        .terms-hint.unlocked { background: #f0fdf4; color: #0d7a4e; }
        .scan-status { display: flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 500; margin-top: 10px; }
        .scan-status.scanning { background: var(--blue-50); color: var(--blue-700); border: 1px solid var(--blue-200); }
        .scan-status.success  { background: #f0fdf4; color: #0d7a4e; border: 1px solid rgba(13,122,78,.2); }
        .scan-status.error    { background: #fef2f2; color: #b91c1c; border: 1px solid rgba(185,28,28,.2); }
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { width: 16px; height: 16px; border: 2px solid var(--blue-200); border-top-color: var(--blue-600); border-radius: 50%; animation: spin .7s linear infinite; flex-shrink: 0; }
        .custom-check-wrap { display: flex; align-items: flex-start; gap: 10px; cursor: pointer; }
        .custom-check { width: 20px; height: 20px; border-radius: 5px; border: 2px solid #d4daea; background: #f5f6fa; flex-shrink: 0; margin-top: 1px; transition: all .2s; display: flex; align-items: center; justify-content: center; }
        .custom-check.checked { background: var(--blue-600); border-color: var(--blue-600); }
        .custom-check.checked::after { content: ''; width: 5px; height: 9px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(45deg) translateY(-1px); display: block; }
        .custom-check.disabled { opacity: .4; cursor: not-allowed; }
        .error-msg { color: #b91c1c; font-size: 12px; margin-top: 4px; display: none; }
        .error-msg.show { display: block; }
        .form-input.error { border-color: #b91c1c !important; }
        @media (max-width: 768px) {
            .page-grid { grid-template-columns: 1fr; }
            .auth-panel { display: none; }
            .form-side { padding: 24px 20px; }
        }
    </style>
</head>
<body>

<div class="page-grid">

    {{-- LEFT PANEL --}}
    <div class="auth-panel">
        <div class="auth-panel-inner">
            <div class="logos-row">
                <div class="logo-circle bounce-1">
                    <img src="{{ asset('images/blotterlink-logo.png') }}" alt="KP App">
                </div>
                <div class="logo-divider"></div>
                <div class="logo-circle bounce-2" style="background:#fff;">
                    <img src="{{ asset('images/barangay-logo.jpg') }}" alt="Barangay New Kababae">
                </div>
            </div>
            <div class="brand-title">Katarungang Pambarangay App</div>
            <div class="brand-sub">Barangay New Kababae, Olongapo City</div>

            {{-- Step Progress --}}
            <div class="step-list" id="step-sidebar">
                <div class="reg-step-side active" id="side-1">
                    <div class="reg-step-num" id="snum-1">1</div>
                    <div>
                        <div class="reg-step-label">Terms & Privacy</div>
                        <div class="reg-step-sub">Read and agree to terms</div>
                    </div>
                </div>
                <div class="reg-step-line"></div>
                <div class="reg-step-side" id="side-2">
                    <div class="reg-step-num" id="snum-2">2</div>
                    <div>
                        <div class="reg-step-label">ID Verification</div>
                        <div class="reg-step-sub">Upload your valid ID</div>
                    </div>
                </div>
                <div class="reg-step-line"></div>
                <div class="reg-step-side" id="side-3">
                    <div class="reg-step-num" id="snum-3">3</div>
                    <div>
                        <div class="reg-step-label">Face Photo</div>
                        <div class="reg-step-sub">Take or upload a selfie</div>
                    </div>
                </div>
                <div class="reg-step-line"></div>
                <div class="reg-step-side" id="side-4">
                    <div class="reg-step-num" id="snum-4">4</div>
                    <div>
                        <div class="reg-step-label">Your Details</div>
                        <div class="reg-step-sub">Complete your information</div>
                    </div>
                </div>
                <div class="reg-step-line"></div>
                <div class="reg-step-side" id="side-5">
                    <div class="reg-step-num" id="snum-5">5</div>
                    <div>
                        <div class="reg-step-label">Create Account</div>
                        <div class="reg-step-sub">Set your password</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT FORM SIDE --}}
    <div class="form-side">
        <div class="form-inner">

            <div style="margin-bottom:24px;">
                <h2 style="font-size:24px;font-weight:700;color:#0e1e5b;letter-spacing:-.4px;margin-bottom:4px;" id="step-title">
                    Step 1 — Terms & Privacy Policy
                </h2>
                <p style="font-size:14px;color:#5e6882;" id="step-sub">
                    Please read and agree to our Terms of Service and Data Privacy Act before proceeding.
                </p>
            </div>

            @if($errors->any())
            <div style="background:#fee2e2;color:#b91c1c;padding:12px 14px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="reg-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="name"                  id="h-name">
                <input type="hidden" name="email"                 id="h-email">
                <input type="hidden" name="password"              id="h-password">
                <input type="hidden" name="password_confirmation" id="h-password-confirm">
                <input type="hidden" name="contact"               id="h-contact">
                <input type="hidden" name="address"               id="h-address">

                {{-- ═══ STEP 1: Terms & Privacy ═══ --}}
                <div id="step-1">
                    <div class="terms-box">
                        <div class="terms-header">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Terms of Service, Data Privacy Act & Age Requirement
                        </div>
                        <div class="terms-body" id="terms-body" onscroll="checkScroll()">
                            <p><strong>⚠️ Age Requirement</strong><br>
                            This system is exclusively for individuals who are <strong>18 years old and above</strong>. By registering, you confirm that you are at least 18 years of age. Minors are strictly prohibited from using this system in compliance with Philippine law and the Data Privacy Act of 2012.</p>

                            <p><strong>1. Acceptance of Terms</strong><br>
                            By registering for a Katarungang Pambarangay App (KP App) account, you agree to be bound by these Terms of Service and the Data Privacy Act of 2012 (Republic Act No. 10173). If you do not agree, please do not use this system.</p>

                            <p><strong>2. Purpose of the System</strong><br>
                            The KP App is an official digital platform of Barangay New Kababae, Olongapo City, Zambales. It is designed to facilitate the filing, processing, and resolution of complaints following the Katarungang Pambarangay Law (RA 7160, Sections 399-422). The system is exclusively for residents of Barangay New Kababae who are 18 years old and above.</p>

                            <p><strong>3. Data Privacy Act of 2012 (RA 10173)</strong><br>
                            In compliance with the Data Privacy Act of 2012, Barangay New Kababae, as the Personal Information Controller, hereby informs you that:<br><br>
                            a) <strong>Collection:</strong> We collect your personal information including your name, address, contact number, date of birth, and government-issued ID for the purpose of identity verification and account creation.<br><br>
                            b) <strong>Purpose:</strong> Your personal data will be used solely for processing your complaints and facilitating the Katarungang Pambarangay process.<br><br>
                            c) <strong>Sharing:</strong> Your data will only be shared with authorized barangay officials involved in the complaint resolution process. We will not share your data with third parties without your consent.<br><br>
                            d) <strong>Retention:</strong> Your personal data will be retained for the period necessary to fulfill the purposes for which it was collected, in accordance with applicable laws.<br><br>
                            e) <strong>Rights:</strong> You have the right to access, correct, and request deletion of your personal data. Contact the Barangay Secretary for data privacy concerns.<br><br>
                            f) <strong>Security:</strong> We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, disclosure, alteration, or destruction.</p>

                            <p><strong>4. User Responsibilities</strong><br>
                            You agree to provide accurate, truthful, and complete information. Filing false, misleading, or malicious complaints is strictly prohibited and may result in account suspension and legal action under the Revised Penal Code of the Philippines.</p>

                            <p><strong>5. ID Verification</strong><br>
                            Your government-issued ID is scanned using OCR technology only to pre-fill your registration form. The image is processed temporarily and is not permanently stored. Accepted IDs include: PhilSys National ID, Driver's License, Passport, UMID, SSS ID, and Voter's ID.</p>

                            <p><strong>6. Age Verification</strong><br>
                            By proceeding with registration, you declare under oath that you are 18 years of age or older. Providing false information about your age is a violation of these terms and may result in legal consequences.</p>

                            <p><strong>7. Prohibited Conduct</strong><br>
                            You must not: submit false complaints, impersonate another person, use the system for unlawful purposes, or allow minors to use your account.</p>

                            <p><strong>8. Account Suspension</strong><br>
                            The Barangay Administrator reserves the right to suspend or terminate accounts found in violation of these terms without prior notice.</p>

                            <p><strong>9. Consent</strong><br>
                            By checking the box below, you freely give your consent to the collection and processing of your personal data as described above, in accordance with the Data Privacy Act of 2012. You also confirm that you are 18 years of age or older.</p>
                        </div>
                        <div class="terms-hint" id="terms-hint">
                            ↓ Scroll down to read all terms before agreeing
                        </div>
                    </div>

                    <div style="margin-bottom:20px;" onclick="toggleTerms()">
                        <div class="custom-check-wrap">
                            <div class="custom-check disabled" id="terms-check-box"></div>
                            <span style="font-size:13.5px;color:#5e6882;line-height:1.5;cursor:pointer;">
                                I have read and agree to the <strong style="color:var(--blue-600);">Terms of Service</strong>, <strong style="color:var(--blue-600);">Data Privacy Act of 2012</strong>, and confirm that I am <strong style="color:var(--blue-600);">18 years old or above</strong>.
                            </span>
                        </div>
                        <div id="terms-lock-note" style="font-size:12px;color:#b0b9cc;margin-top:5px;margin-left:30px;display:flex;align-items:center;gap:4px;">
                            🔒 Scroll and read all terms above to unlock
                        </div>
                    </div>

                    <button type="button" id="btn-step1-next" onclick="goStep(2)" disabled
                        class="btn-primary" style="opacity:.5;cursor:not-allowed;">
                        I Agree — Proceed to ID Verification ›
                    </button>
                </div>

                {{-- ═══ STEP 2: ID Upload ═══ --}}
                <div id="step-2" style="display:none;">
                    <div class="upload-zone-reg" id="id-zone" onclick="document.getElementById('id-file').click()">
                        <input type="file" id="id-file" accept="image/*" style="display:none" onchange="handleIDUpload(this)">
                        <div id="id-placeholder">
                            <div style="width:72px;height:72px;background:var(--blue-100);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                <svg width="32" height="32" fill="none" stroke="var(--blue-600)" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="8" cy="10" r="1.5"/><path d="m2 15 5-5 4 4 3-3 5 5"/></svg>
                            </div>
                            <div style="font-size:15px;font-weight:700;color:#1e2130;margin-bottom:6px;">Click to upload your valid ID</div>
                            <div style="font-size:13px;color:#8590a8;margin-bottom:4px;">PhilSys, Driver's License, Passport, UMID, Voter's ID</div>
                            <div style="font-size:12px;color:#b0b9cc;">JPG, PNG — Max 10MB</div>
                        </div>
                        <div id="id-preview-wrap" style="display:none;width:100%;">
                            <img id="id-preview" src="" alt="ID" style="max-width:100%;max-height:200px;border-radius:10px;object-fit:contain;display:block;margin:0 auto;">
                            <div id="scan-scanning" class="scan-status scanning" style="display:none;"><div class="spinner"></div><span>Reading your ID — please wait...</span></div>
                            <div id="scan-success" class="scan-status success" style="display:none;"><span>✓</span><span>ID scanned! Your details have been filled in automatically.</span></div>
                            <div id="scan-error" class="scan-status error" style="display:none;"><span>⚠</span><span id="scan-error-msg">Could not read ID clearly. You may fill in your details manually.</span></div>
                            <button type="button" onclick="event.stopPropagation();resetID()"
                                style="margin-top:10px;background:none;border:1.5px solid #d4daea;border-radius:6px;padding:6px 14px;font-size:13px;color:#5e6882;cursor:pointer;font-family:Inter,sans-serif;">
                                Change ID
                            </button>
                        </div>
                    </div>
                    <div style="margin-top:18px;display:flex;justify-content:space-between;align-items:center;">
                        <button type="button" onclick="goStep(1)" class="btn-ghost">‹ Back</button>
                        <div style="display:flex;gap:10px;">
                            <button type="button" onclick="skipID()" class="btn-ghost">Skip — Fill manually</button>
                            <button type="button" id="btn-step2-next" onclick="goStep(3)" disabled
                                class="btn-primary" style="width:auto;padding:11px 28px;opacity:.5;cursor:not-allowed;">
                                Next — Take Selfie ›
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ═══ STEP 3: Face Photo ═══ --}}
                <div id="step-3" style="display:none;">
                    <div class="upload-zone-reg" id="face-zone" onclick="document.getElementById('face-file').click()">
                        <input type="file" id="face-file" accept="image/*" style="display:none" onchange="handleFaceUpload(this)">
                        <div id="face-placeholder">
                            <div style="width:72px;height:72px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                <svg width="32" height="32" fill="none" stroke="#0d7a4e" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div style="font-size:15px;font-weight:700;color:#1e2130;margin-bottom:6px;">Upload your selfie / face photo</div>
                            <div style="font-size:13px;color:#8590a8;">Make sure your face is clearly visible and well-lit</div>
                        </div>
                        <div id="face-preview-wrap" style="display:none;text-align:center;">
                            <img id="face-preview" src="" alt="Face" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid #c5dffe;display:block;margin:0 auto 10px;">
                            <div id="face-status" class="scan-status success" style="display:none;"><span>✓</span><span>Face photo uploaded!</span></div>
                            <br>
                            <button type="button" onclick="event.stopPropagation();resetFace()"
                                style="margin-top:8px;background:none;border:1.5px solid #d4daea;border-radius:6px;padding:6px 14px;font-size:13px;color:#5e6882;cursor:pointer;font-family:Inter,sans-serif;">
                                Change Photo
                            </button>
                        </div>
                    </div>
                    <div style="margin-top:18px;display:flex;justify-content:space-between;">
                        <button type="button" onclick="goStep(2)" class="btn-ghost">‹ Back</button>
                        <button type="button" id="btn-step3-next" onclick="goStep(4)" disabled
                            class="btn-primary" style="width:auto;padding:11px 28px;opacity:.5;cursor:not-allowed;">
                            Next — Review Details ›
                        </button>
                    </div>
                </div>

                {{-- ═══ STEP 4: Personal Info ═══ --}}
                <div id="step-4" style="display:none;">
                    <div style="background:var(--blue-50);border:1px solid var(--blue-200);border-radius:8px;padding:10px 14px;margin-bottom:18px;font-size:13px;color:var(--blue-700);display:flex;gap:8px;">
                        <span>🔒</span>
                        <span>Fields marked with 🔒 were auto-filled from your ID. You may still edit them.</span>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                        <div>
                            <label class="form-label">First Name *</label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="text" id="f-firstname" placeholder="First name" required>
                                <span class="lock-icon" id="lock-fn">🔒</span>
                            </div>
                            <div class="error-msg" id="err-firstname">First name is required.</div>
                        </div>
                        <div>
                            <label class="form-label">Last Name *</label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="text" id="f-lastname" placeholder="Last name" required>
                                <span class="lock-icon" id="lock-ln">🔒</span>
                            </div>
                            <div class="error-msg" id="err-lastname">Last name is required.</div>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                        <div>
                            <label class="form-label">Middle Name</label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="text" id="f-middlename" placeholder="Middle name">
                                <span class="lock-icon" id="lock-mn">🔒</span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Date of Birth * <span style="color:#dc2626;font-size:11px;">(Must be 18+)</span></label>
                            <div class="input-lock-wrap">
                                <input class="form-input" type="date" id="f-dob"
                                    max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                    required>
                                <span class="lock-icon" id="lock-dob">🔒</span>
                            </div>
                            <div class="error-msg" id="err-dob">You must be at least 18 years old to register.</div>
                        </div>
                    </div>

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
                            <label class="form-label">Contact Number *</label>
                            <input class="form-input" type="tel" id="f-contact"
                                placeholder="09XX-XXX-XXXX"
                                maxlength="11">
                            <div class="error-msg" id="err-contact">Enter a valid 11-digit phone number.</div>
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label">Home Address *</label>
                        <div class="input-lock-wrap">
                            <input class="form-input" type="text" id="f-address"
                                placeholder="Purok, Street, Barangay New Kababae, Olongapo City" required>
                            <span class="lock-icon" id="lock-addr">🔒</span>
                        </div>
                        <div class="error-msg" id="err-address">Address is required.</div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label">Email Address *</label>
                        <input class="form-input" type="email" id="f-email"
                            placeholder="your@gmail.com" required>
                        <div style="font-size:12px;color:#8590a8;margin-top:4px;">
                            📧 A verification link will be sent to this email after registration.
                        </div>
                        <div class="error-msg" id="err-email">Enter a valid email address.</div>
                    </div>

                    <div style="display:flex;justify-content:space-between;margin-top:8px;">
                        <button type="button" onclick="goStep(3)" class="btn-ghost">‹ Back</button>
                        <button type="button" onclick="validateStep4()" class="btn-primary" style="width:auto;padding:11px 28px;">
                            Next — Create Account ›
                        </button>
                    </div>
                </div>

                {{-- ═══ STEP 5: Password ═══ --}}
                <div id="step-5" style="display:none;">
                    <div style="background:#d1fae5;border:1px solid #6ee7b7;border-radius:8px;padding:12px 14px;margin-bottom:20px;font-size:13px;color:#065f46;display:flex;gap:8px;">
                        <span>✅</span>
                        <span>Almost done! Set your password to complete your registration.</span>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label">Password *</label>
                        <input class="form-input" type="password" id="f-password"
                            placeholder="Min 8 characters" required minlength="8">
                        <div class="error-msg" id="err-password">Password must be at least 8 characters.</div>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label class="form-label">Confirm Password *</label>
                        <input class="form-input" type="password" id="f-password-confirm"
                            placeholder="Repeat your password" required>
                        <div class="error-msg" id="err-password-confirm">Passwords do not match.</div>
                    </div>

                    <div style="margin-bottom:20px;">
                        <div style="font-size:12px;color:#64748b;margin-bottom:6px;">Password strength:</div>
                        <div style="height:6px;background:#e5e9f0;border-radius:99px;overflow:hidden;">
                            <div id="password-strength-bar" style="height:100%;width:0%;background:#dc2626;border-radius:99px;transition:all .3s;"></div>
                        </div>
                        <div id="password-strength-text" style="font-size:12px;margin-top:4px;color:#94a3b8;"></div>
                    </div>

                    <button type="submit" id="reg-submit-btn" onclick="prepareSubmit(event)"
                        class="btn-primary" style="margin-bottom:8px;">
                        🚀 Create My Account
                    </button>

                    <div style="margin-top:14px;">
                        <button type="button" onclick="goStep(4)" class="btn-ghost" style="width:auto;padding:10px 20px;">‹ Back</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>

// ─── Step Titles ───
const titles = {
    1: ['Step 1 — Terms & Privacy Policy',   'Please read and agree to our Terms of Service and Data Privacy Act before proceeding.'],
    2: ['Step 2 — Upload Valid ID',           "Upload a clear photo of your government-issued ID. We'll automatically fill in your details."],
    3: ['Step 3 — Face Verification',         'Upload a selfie or face photo for identity verification.'],
    4: ['Step 4 — Review Your Details',       'Review and complete your personal information. You must be 18 years old or above.'],
    5: ['Step 5 — Create Your Account',       'Set your password to complete your registration.'],
};

// ─── State ───
let state = {
    step: 1,
    termsRead: false,
    termsChecked: false,
    idScanned: false,
    faceUploaded: false,
};

// ─── Go to Step ───
function goStep(n) {
    for (let i = 1; i <= 5; i++) {
        const stepEl = document.getElementById('step-' + i);
        if (stepEl) stepEl.style.display = i === n ? 'block' : 'none';
        const side = document.getElementById('side-' + i);
        if (side) side.className = 'reg-step-side' + (i === n ? ' active' : i < n ? ' done' : '');
        const snum = document.getElementById('snum-' + i);
        if (snum) snum.innerHTML = i < n ? '✓' : i;
    }
    state.step = n;
    document.getElementById('step-title').textContent = titles[n][0];
    document.getElementById('step-sub').textContent   = titles[n][1];
    gsap.from('#step-' + n, { duration:.4, y:16, opacity:0, ease:'power2.out' });
    window.scrollTo(0, 0);
}

// ─── Terms ───
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
    const btn = document.getElementById('btn-step1-next');
    box.classList.toggle('checked', state.termsChecked);
    btn.disabled      = !state.termsChecked;
    btn.style.opacity = state.termsChecked ? '1' : '.5';
    btn.style.cursor  = state.termsChecked ? 'pointer' : 'not-allowed';
}

// ─── ID Upload — calls Laravel backend (API key hidden) ───
async function handleIDUpload(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = async (e) => {
        const dataUrl = e.target.result;
        document.getElementById('id-preview').src = dataUrl;
        document.getElementById('id-placeholder').style.display  = 'none';
        document.getElementById('id-preview-wrap').style.display = 'block';
        document.getElementById('scan-scanning').style.display   = 'flex';
        document.getElementById('scan-success').style.display    = 'none';
        document.getElementById('scan-error').style.display      = 'none';
        try {
            const data = await scanIDWithOCR(dataUrl);
            applyIDData(data);
            document.getElementById('scan-scanning').style.display = 'none';
            document.getElementById('scan-success').style.display  = 'flex';
            state.idScanned = true;
            unlockNext('btn-step2-next');
        } catch(err) {
            document.getElementById('scan-scanning').style.display = 'none';
            document.getElementById('scan-error').style.display    = 'flex';
            document.getElementById('scan-error-msg').textContent  = err.message;
            // Still allow to proceed manually
            unlockNext('btn-step2-next');
        }
    };
    reader.readAsDataURL(file);
}

// ─── OCR via Laravel Backend (secure - API key never exposed) ───
async function scanIDWithOCR(dataUrl) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const res = await fetch('{{ route("ocr.scan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ image: dataUrl })
    }).catch(() => {
        throw new Error('Network error. Please check your internet connection.');
    });

    if (!res.ok) throw new Error('OCR service error. Please fill in your details manually.');

    const d = await res.json();

    if (d.IsErroredOnProcessing || !d.ParsedResults || !d.ParsedResults[0]) {
        throw new Error('Could not read ID clearly. Please fill in your details manually.');
    }

    const text = d.ParsedResults[0].ParsedText || '';
    return parseIDText(text);
}

// ─── Parse OCR Text ───
function parseIDText(text) {
    const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 1);
    let firstName = '', lastName = '', middleName = '', dateOfBirth = '', address = '', sex = '';

    // Extract date of birth
    const datePatterns = [
        /\b(\d{2})[\/\-](\d{2})[\/\-](\d{4})\b/,
        /\b(\d{4})[\/\-](\d{2})[\/\-](\d{2})\b/,
        /\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})\b/i,
    ];
    for (const line of lines) {
        for (const pattern of datePatterns) {
            const match = line.match(pattern);
            if (match && !dateOfBirth) {
                if (match[3] && match[3].length === 4) {
                    dateOfBirth = match[3] + '-' + String(match[1]).padStart(2,'0') + '-' + String(match[2]).padStart(2,'0');
                } else if (match[1] && match[1].length === 4) {
                    dateOfBirth = match[1] + '-' + match[2] + '-' + match[3];
                }
            }
        }
    }

    // Extract sex
    for (const line of lines) {
        const upper = line.toUpperCase();
        if (upper.includes('FEMALE')) { sex = 'Female'; break; }
        if (upper.includes('MALE')) { sex = 'Male'; break; }
        if (upper.trim() === 'M') { sex = 'Male'; break; }
        if (upper.trim() === 'F') { sex = 'Female'; break; }
    }

    // Extract name
    const nameLines = lines.filter(l => /^[A-Z][A-Z\s,\.]+$/.test(l) && l.length > 3 && l.length < 60);
    if (nameLines.length > 0) {
        const nameParts = nameLines[0].replace(/,/g, ' ').split(/\s+/).filter(p => p.length > 1);
        if (nameParts.length >= 2) {
            lastName   = nameParts[0] || '';
            firstName  = nameParts[1] || '';
            middleName = nameParts[2] || '';
        }
    }

    // Extract address
    const addressKeywords = ['st.', 'street', 'ave', 'avenue', 'blvd', 'purok', 'brgy', 'barangay', 'city', 'olongapo', 'zambales', 'road', 'rd.'];
    for (const line of lines) {
        const lower = line.toLowerCase();
        if (addressKeywords.some(k => lower.includes(k)) && line.length > 8) {
            address = line;
            break;
        }
    }

    return { firstName, lastName, middleName, dateOfBirth, address, sex };
}

// ─── Apply ID Data ───
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
        if (s) { s.value = data.sex; s.classList.add('autofilled'); }
        const lk = document.getElementById('lock-sex');
        if (lk) lk.classList.add('show');
    }
}

function skipID() { state.idScanned = false; goStep(3); }

function resetID() {
    document.getElementById('id-file').value = '';
    document.getElementById('id-placeholder').style.display  = 'block';
    document.getElementById('id-preview-wrap').style.display = 'none';
    state.idScanned = false;
    lockBtn('btn-step2-next');
}

// ─── Face Upload ───
function handleFaceUpload(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('face-preview').src = e.target.result;
        document.getElementById('face-placeholder').style.display  = 'none';
        document.getElementById('face-preview-wrap').style.display = 'block';
        document.getElementById('face-status').style.display = 'flex';
        document.getElementById('face-status').className = 'scan-status success';
        document.getElementById('face-status').innerHTML = '✓ Face photo uploaded successfully!';
        state.faceUploaded = true;
        unlockNext('btn-step3-next');
    };
    reader.readAsDataURL(file);
}

function resetFace() {
    document.getElementById('face-file').value = '';
    document.getElementById('face-placeholder').style.display  = 'block';
    document.getElementById('face-preview-wrap').style.display = 'none';
    state.faceUploaded = false;
    lockBtn('btn-step3-next');
}

// ─── Step 4 Validation with 18+ ───
function validateStep4() {
    let valid = true;

    const fn = document.getElementById('f-firstname').value.trim();
    if (!fn) { showError('err-firstname', 'f-firstname'); valid = false; }
    else hideError('err-firstname', 'f-firstname');

    const ln = document.getElementById('f-lastname').value.trim();
    if (!ln) { showError('err-lastname', 'f-lastname'); valid = false; }
    else hideError('err-lastname', 'f-lastname');

    // 18+ age check
    const dob = document.getElementById('f-dob').value;
    if (!dob) {
        showError('err-dob', 'f-dob');
        document.getElementById('err-dob').textContent = 'Date of birth is required.';
        valid = false;
    } else {
        const today    = new Date();
        const birth    = new Date(dob);
        let age        = today.getFullYear() - birth.getFullYear();
        const mDiff    = today.getMonth() - birth.getMonth();
        if (mDiff < 0 || (mDiff === 0 && today.getDate() < birth.getDate())) age--;
        if (age < 18) {
            showError('err-dob', 'f-dob');
            document.getElementById('err-dob').textContent = '⚠️ You must be at least 18 years old to register.';
            valid = false;
        } else {
            hideError('err-dob', 'f-dob');
        }
    }

    const contact = document.getElementById('f-contact').value.trim();
    if (contact && (!/^[0-9]{11}$/.test(contact))) {
        showError('err-contact', 'f-contact');
        valid = false;
    } else hideError('err-contact', 'f-contact');

    const em = document.getElementById('f-email').value.trim();
    if (!em || !em.includes('@') || !em.includes('.')) {
        showError('err-email', 'f-email');
        valid = false;
    } else hideError('err-email', 'f-email');

    const ad = document.getElementById('f-address').value.trim();
    if (!ad) { showError('err-address', 'f-address'); valid = false; }
    else hideError('err-address', 'f-address');

    if (valid) goStep(5);
}

function showError(errId, inputId) {
    document.getElementById(errId).classList.add('show');
    document.getElementById(inputId).classList.add('error');
}
function hideError(errId, inputId) {
    document.getElementById(errId).classList.remove('show');
    document.getElementById(inputId).classList.remove('error');
}

// ─── Password Strength ───
document.addEventListener('DOMContentLoaded', () => {
    const passInput = document.getElementById('f-password');
    if (passInput) {
        passInput.addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('password-strength-bar');
            const txt = document.getElementById('password-strength-text');
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;
            const levels = [
                { pct: '0%',   color: '#dc2626', text: '' },
                { pct: '25%',  color: '#dc2626', text: 'Weak' },
                { pct: '50%',  color: '#d97706', text: 'Fair' },
                { pct: '75%',  color: '#2563eb', text: 'Good' },
                { pct: '100%', color: '#059669', text: 'Strong ✓' },
            ];
            bar.style.width      = levels[strength].pct;
            bar.style.background = levels[strength].color;
            txt.textContent      = levels[strength].text;
            txt.style.color      = levels[strength].color;
        });
    }
});

// ─── Prepare Submit ───
function prepareSubmit(e) {
    const pass = document.getElementById('f-password').value;
    const conf = document.getElementById('f-password-confirm').value;

    if (pass.length < 8) {
        e.preventDefault();
        showError('err-password', 'f-password');
        return;
    } else hideError('err-password', 'f-password');

    if (pass !== conf) {
        e.preventDefault();
        showError('err-password-confirm', 'f-password-confirm');
        document.getElementById('err-password-confirm').textContent = 'Passwords do not match.';
        return;
    } else hideError('err-password-confirm', 'f-password-confirm');

    const fn = document.getElementById('f-firstname').value.trim();
    const ln = document.getElementById('f-lastname').value.trim();
    document.getElementById('h-name').value             = fn + ' ' + ln;
    document.getElementById('h-email').value            = document.getElementById('f-email').value.trim();
    document.getElementById('h-password').value         = pass;
    document.getElementById('h-password-confirm').value = conf;
    document.getElementById('h-contact').value          = document.getElementById('f-contact').value;
    document.getElementById('h-address').value          = document.getElementById('f-address').value;
}

// ─── Helpers ───
function unlockNext(id) {
    const b = document.getElementById(id);
    if (b) { b.disabled = false; b.style.opacity = '1'; b.style.cursor = 'pointer'; }
}
function lockBtn(id) {
    const b = document.getElementById(id);
    if (b) { b.disabled = true; b.style.opacity = '.5'; b.style.cursor = 'not-allowed'; }
}

// ─── GSAP Entrance ───
gsap.from('.auth-panel-inner', { duration:.8, x:-30, opacity:0, ease:'power2.out' });
gsap.from('#step-1',           { duration:.8, x:30,  opacity:0, ease:'power2.out', delay:.1 });
</script>

</body>
</html>