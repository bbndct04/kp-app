<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Times New Roman', serif; font-size: 13px; margin: 60px; color: #000; }
    .center { text-align: center; }
    .underline { text-decoration: underline; }
    .header { text-align: center; margin-bottom: 30px; line-height: 1.8; }
    .form-title { font-size: 11px; font-weight: bold; text-transform: uppercase; border-bottom: 2px solid #000; padding-bottom: 4px; margin-bottom: 30px; }
    .section-title { font-weight: bold; text-align: center; font-size: 14px; letter-spacing: 2px; margin: 20px 0 14px; }
    .value-line { border-bottom: 1px solid #000; min-height: 22px; display: inline-block; min-width: 150px; }
    .sig-line { border-bottom: 1px solid #000; margin-top: 50px; margin-bottom: 4px; width: 250px; }
    .sig-label { font-size: 11px; }
</style>
</head>
<body>

<div class="form-title">KP FORM # 8: NOTICE OF HEARING</div>

<div class="header">
    Republic of the Philippines<br>
    Province of <span class="underline">&nbsp;{{ $barangay['province'] }}&nbsp;</span><br>
    City/Municipality of <span class="underline">&nbsp;{{ $barangay['city'] }}&nbsp;</span><br>
    Barangay <span class="underline">&nbsp;{{ $barangay['name'] }}&nbsp;</span><br><br>
    OFFICE OF THE LUPONG TAGAPAMAYAPA
</div>

<div class="section-title">NOTICE OF HEARING<br><span style="font-size:12px;">(MEDIATION PROCEEDINGS)</span></div>

<p>TO: <span class="underline" style="min-width:300px; display:inline-block;">&nbsp;{{ $complaint->complainant_formal_name ?? $complaint->user->name }}&nbsp;</span></p>
<p style="margin-left: 40px; font-size: 11px;">Complainant/s</p>

<p style="margin-top: 20px; line-height: 2;">
    You are hereby required to appear before me on the
    <span class="underline">&nbsp;{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('d') : '______' }}&nbsp;</span>
    day of
    <span class="underline">&nbsp;{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F Y') : '________________' }}&nbsp;</span>,
    at
    <span class="underline">&nbsp;{{ $complaint->hearing_time ? \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i') : '______' }}&nbsp;</span>
    o'clock in the
    <span class="underline">&nbsp;{{ $complaint->hearing_time ? (\Carbon\Carbon::parse($complaint->hearing_time)->format('A') === 'AM' ? 'morning' : 'afternoon') : '___________' }}&nbsp;</span>
    for the hearing of your complaint.
</p>

<p style="margin-top: 20px;">
    This <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> day of <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, {{ date('Y') }}.
</p>

<div style="margin-top: 40px;">
    <div class="sig-line"></div>
    <div class="sig-label">Punong Barangay/Lupon Chairman</div>
</div>

<div style="margin-top: 30px;">
    <p>Notified this <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> day of <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, {{ date('Y') }}.</p>
    <div style="margin-top: 30px;">
        <div class="sig-line"></div>
        <div class="sig-label">complainant/s</div>
    </div>
</div>

</body>
</html>
