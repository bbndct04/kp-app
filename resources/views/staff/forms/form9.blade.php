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
    .sig-line { border-bottom: 1px solid #000; margin-top: 50px; margin-bottom: 4px; width: 250px; }
    .sig-label { font-size: 11px; }
</style>
</head>
<body>

<div class="form-title">KP FORM # 9: SUMMON FOR THE RESPONDENT</div>

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

<div class="section-title">S U M M O N S</div>

<p style="margin-top: 20px;">TO: <span class="underline" style="min-width:300px;display:inline-block;">&nbsp;{{ $complaint->respondent_name ?? '___________________________' }}&nbsp;</span></p>
<p style="margin-left:40px; font-size:11px;">Respondents</p>

<p style="margin-top:20px; line-height:2;">
    You are hereby summoned to appear before me in person, together with your witnesses, on the
    <span class="underline">&nbsp;{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('d') : '______' }}&nbsp;</span>
    day of
    <span class="underline">&nbsp;{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F Y') : '________________' }}&nbsp;</span>,
    at
    <span class="underline">&nbsp;{{ $complaint->hearing_time ? \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i') : '______' }}&nbsp;</span>
    o'clock in the
    <span class="underline">&nbsp;{{ $complaint->hearing_time ? (\Carbon\Carbon::parse($complaint->hearing_time)->format('A') === 'AM' ? 'morning' : 'afternoon') : '___________' }}&nbsp;</span>
    and there to answer to a complaint made before me, copy of which is attached hereto, for mediation/conciliation of your dispute with complainant/s.
</p>

<p style="margin-top:16px; line-height:1.8;">
    You are hereby warned that if you refuse or willfully fail to appear in obedience to this summons, you may be barred from filing any counterclaim arising from said complaint.
</p>

<p style="margin-top:16px; font-weight:bold;">FAIL NOT or else face punishment as for contempt of court.</p>

<p style="margin-top:20px;">
    This <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> day of <span class="underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, {{ date('Y') }}.
</p>

<div style="margin-top:40px;">
    <div class="sig-line"></div>
    <div class="sig-label">Punong Barangay/Pangkat Chairman</div>
</div>

</body>
</html>
