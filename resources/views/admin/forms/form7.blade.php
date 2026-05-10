<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 40px; color: #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-weight: bold; font-size: 13px; text-transform: uppercase; text-align: center; margin: 16px 0 10px; }
        .parties { display: flex; margin-bottom: 10px; }
        .case-info { float: right; text-align: left; }
        .line { border-bottom: 1px solid #000; margin: 4px 0 2px; min-width: 200px; display: block; }
        .label { font-size: 11px; text-align: center; }
        .section { margin: 14px 0; }
        .body-text { text-align: justify; line-height: 1.8; }
        .signature-area { margin-top: 20px; }
        .sig-line { border-bottom: 1px solid #000; width: 220px; margin-bottom: 2px; }
        table { width: 100%; }
        .border-box { border: 1px solid #000; padding: 20px; }
    </style>
</head>
<body>
<div class="border-box">
    <div class="header">
        Republic of the Philippines<br>
        Province of Zambales<br>
        CITY/MUNICIPALITY OF Olongapo<br>
        Barangay New Kababae<br>
        OFFICE OF THE LUPONG TAGAPAMAYAPA
    </div>

    <table>
        <tr>
            <td style="width:50%;vertical-align:top;">
                <span class="line" style="width:180px;">&nbsp;</span>
                <span class="line" style="width:180px;">&nbsp;</span>
                <div class="label">Complainant/s</div>
                <br>— against —<br><br>
                <span class="line" style="width:180px;">&nbsp;</span>
                <span class="line" style="width:180px;">&nbsp;</span>
                <div class="label">Respondent/s</div>
            </td>
            <td style="width:50%;vertical-align:top;">
                Barangay Case No.: <strong>{{ $complaint->case_number }}</strong><br>
                For: <strong>{{ $complaint->category }}</strong><br><br>
                {{ $complaint->complainant_formal_name }}<br><br><br><br>
                {{ $complaint->respondent_name }}
            </td>
        </tr>
    </table>

    <div class="title">C O M P L A I N T</div>

    <div class="body-text">
        I/WE hereby complain against above named respondent/s for violating my/our
        rights and interests in the following manner:
    </div>

    <div style="margin:16px 0;">
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        {{ $complaint->description }}
    </div>

    <div class="body-text">
        THEREFORE, I/WE pray that the following relief/s be granted to me/us in
        accordance with law and/or equity:
    </div>

    <div style="margin:16px 0;">
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        {{ $complaint->relief_requested }}
    </div>

    <div>
        Made this <u>{{ \Carbon\Carbon::parse($complaint->created_at)->format('d') }}</u>
        day of <u>{{ \Carbon\Carbon::parse($complaint->created_at)->format('F') }}</u>,
        <u>{{ \Carbon\Carbon::parse($complaint->created_at)->format('Y') }}</u>.
    </div>

    <div class="signature-area">
        <div class="sig-line">&nbsp;</div>
        <div>Complainant/s</div>
        <br>
        Received and filed this
        <u>{{ \Carbon\Carbon::parse($complaint->created_at)->format('d') }}</u>
        day of
        <u>{{ \Carbon\Carbon::parse($complaint->created_at)->format('F') }}</u>,
        <u>{{ \Carbon\Carbon::parse($complaint->created_at)->format('Y') }}</u>.
        <br><br>
        <div class="sig-line">&nbsp;</div>
        <div>Punong Barangay/Lupon Chairman</div>
    </div>
</div>
</body>
</html>