<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Times New Roman', serif; font-size: 13px; margin: 40px; color: #000; }
    .center { text-align: center; }
    .bold { font-weight: bold; }
    .underline { text-decoration: underline; }
    .header { text-align: center; margin-bottom: 20px; }
    .form-title { font-size: 11px; font-weight: bold; text-transform: uppercase; border-bottom: 2px solid #000; padding-bottom: 4px; margin-bottom: 20px; }
    .label { font-size: 11px; color: #555; display: block; margin-bottom: 2px; }
    .value-line { border-bottom: 1px solid #000; min-height: 22px; margin-bottom: 14px; padding: 2px 4px; font-size: 13px; }
    .section-title { font-weight: bold; text-align: center; font-size: 14px; letter-spacing: 2px; margin: 18px 0 10px; }
    .two-col { display: flex; gap: 30px; }
    .two-col > div { flex: 1; }
    .sig-line { border-bottom: 1px solid #000; margin-top: 40px; margin-bottom: 4px; }
    .sig-label { font-size: 11px; text-align: center; }
    .footer { margin-top: 40px; font-size: 11px; }
    hr { border: none; border-top: 1px solid #000; }
</style>
</head>
<body>

<div class="form-title">KP FORM # 7: COMPLAINANT'S FORM</div>

<div class="header">
    Republic of the Philippines<br>
    Province of <span class="underline">&nbsp;&nbsp;{{ $barangay['province'] }}&nbsp;&nbsp;</span><br>
    City/Municipality of <span class="underline">&nbsp;&nbsp;{{ $barangay['city'] }}&nbsp;&nbsp;</span><br>
    Barangay <span class="underline">&nbsp;&nbsp;{{ $barangay['name'] }}&nbsp;&nbsp;</span><br><br>
    OFFICE OF THE LUPONG TAGAPAMAYAPA
</div>

<div style="display:flex; justify-content:space-between; margin: 20px 0;">
    <div>
        Barangay Case No. <span class="underline">&nbsp;&nbsp;{{ $complaint->case_number }}&nbsp;&nbsp;</span>
    </div>
    <div>
        For: <span class="underline">&nbsp;&nbsp;{{ $complaint->category }}&nbsp;&nbsp;</span>
    </div>
</div>

<div style="margin-bottom: 8px;">
    <span class="underline" style="display:inline-block; min-width:200px;">{{ $complaint->complainant_formal_name ?? $complaint->user->name }}</span><br>
    <span style="font-size:11px;">Complainant/s</span>
</div>

<div style="text-align:center; margin: 10px 0;">— against —</div>

<div style="margin-bottom: 20px;">
    <span class="underline" style="display:inline-block; min-width:200px;">{{ $complaint->respondent_name ?? '___________________________' }}</span><br>
    <span style="font-size:11px;">Respondent/s</span>
</div>

<div class="section-title">C O M P L A I N T</div>

<p style="margin-bottom: 8px;">I/WE hereby complain against the above named respondent/s for violating my/our rights and interests in the following manner:</p>

<div style="min-height: 80px; border-bottom: 1px solid #000; margin-bottom: 14px; padding: 6px;">
    {{ $complaint->description }}
</div>
<div class="value-line">&nbsp;</div>
<div class="value-line">&nbsp;</div>

<p style="margin-bottom: 8px;">THEREFORE, I/WE pray that the following relief's be granted to me/us in accordance with law and/or equity:</p>

<div style="min-height: 60px; border-bottom: 1px solid #000; margin-bottom: 8px; padding: 6px;">
    {{ $complaint->relief_requested ?? '_______________________________________________' }}
</div>
<div class="value-line">&nbsp;</div>

<p>Made this <span class="underline">&nbsp;&nbsp;{{ \Carbon\Carbon::parse($complaint->created_at)->format('d') }}&nbsp;&nbsp;</span> day of <span class="underline">&nbsp;&nbsp;{{ \Carbon\Carbon::parse($complaint->created_at)->format('F') }}&nbsp;&nbsp;</span>, {{ \Carbon\Carbon::parse($complaint->created_at)->format('Y') }}</p>

<div style="margin-top: 30px;">
    <div class="sig-line" style="width: 250px;"></div>
    <div class="sig-label" style="width: 250px;">Complainant/s</div>
</div>

<div style="margin-top: 20px;">
    <p>Received and filed this <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> day of <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, {{ date('Y') }}.</p>
    <div style="margin-top: 30px;">
        <div class="sig-line" style="width: 250px;"></div>
        <div class="sig-label" style="width: 250px;">Punong Barangay/Lupon Chairman</div>
    </div>
</div>

</body>
</html>
