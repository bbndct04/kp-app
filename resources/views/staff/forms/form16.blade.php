<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Times New Roman', serif; font-size: 13px; margin: 60px; color: #000; }
    .underline { text-decoration: underline; }
    .header { text-align: center; margin-bottom: 30px; line-height: 1.8; }
    .form-title { font-size: 11px; font-weight: bold; text-transform: uppercase; border-bottom: 2px solid #000; padding-bottom: 4px; margin-bottom: 30px; }
    .section-title { font-weight: bold; text-align: center; font-size: 14px; letter-spacing: 2px; margin: 20px 0 14px; }
    .sig-line { border-bottom: 1px solid #000; margin-top: 50px; margin-bottom: 4px; }
    .sig-label { font-size: 11px; }
    .two-col { display: flex; gap: 60px; margin-top: 40px; }
    .two-col > div { flex: 1; }
</style>
</head>
<body>

<div class="form-title">KP FORM # 16: AMICABLE SETTLEMENT</div>

<div class="header">
    Republic of the Philippines<br>
    Province of <span class="underline">&nbsp;{{ $barangay['province'] }}&nbsp;</span><br>
    City/Municipality of <span class="underline">&nbsp;{{ $barangay['city'] }}&nbsp;</span><br>
    Barangay <span class="underline">&nbsp;{{ $barangay['name'] }}&nbsp;</span><br><br>
    OFFICE OF THE LUPONG TAGAPAMAYAPA
</div>

<div style="display:flex; justify-content:space-between; margin-bottom:20px;">
    <div>Barangay Case No. <span class="underline">&nbsp;{{ $complaint->case_number }}&nbsp;</span></div>
    <div>For: <span class="underline">&nbsp;{{ $complaint->category }}&nbsp;</span></div>
</div>

<p>{{ $complaint->complainant_formal_name ?? $complaint->user->name }},</p>
<p style="font-size:11px; margin-left:20px;">Complainant/s</p>
<p style="text-align:center;">— against —</p>
<p>{{ $complaint->respondent_name ?? '___________________________' }},</p>
<p style="font-size:11px; margin-left:20px;">Respondent/s</p>

<div class="section-title">AMICABLE SETTLEMENT</div>

<p style="line-height:1.8;">
    We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:
</p>

<div style="min-height:80px; border-bottom:1px solid #000; padding:8px; margin-bottom:10px;">
    {{ $complaint->settlement_details ?? '_______________________________________________' }}
</div>
<div style="border-bottom:1px solid #000; min-height:22px; margin-bottom:10px;">&nbsp;</div>
<div style="border-bottom:1px solid #000; min-height:22px; margin-bottom:20px;">&nbsp;</div>

<p style="line-height:1.8;">
    and bind ourselves to comply honestly and faithfully with the above terms of settlement.<br>
    Entered into this <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> day of
    <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>,
    {{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('Y') : date('Y') }}.
</p>

<div class="two-col">
    <div>
        <div class="sig-line"></div>
        <div class="sig-label">Complainant/s</div>
    </div>
    <div>
        <div class="sig-line"></div>
        <div class="sig-label">Respondent/s</div>
    </div>
</div>

<div style="margin-top:40px; border-top:1px solid #000; padding-top:16px;">
    <p style="font-weight:bold; margin-bottom:10px;">ATTESTATION</p>
    <p style="line-height:1.8;">
        I hereby certify that the foregoing amicable settlement was entered into by the parties freely and voluntarily, after I had explained to them the nature and consequence of such settlement.
    </p>
    <div style="margin-top:40px;">
        <div class="sig-line" style="width:280px;"></div>
        <div class="sig-label">Punong Barangay/Pangkat Chairman</div>
    </div>
</div>

</body>
</html>
