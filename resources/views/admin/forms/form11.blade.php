<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 40px; color: #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-weight: bold; font-size: 13px; text-transform: uppercase; text-align: center; margin: 16px 0 10px; }
        .line { border-bottom: 1px solid #000; display: block; margin: 4px 0 2px; }
        .label { font-size: 11px; text-align: center; }
        .body-text { text-align: justify; line-height: 1.8; margin: 10px 0; }
        .sig-line { border-bottom: 1px solid #000; width: 220px; margin-bottom: 2px; margin-top: 20px; }
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
                <div class="label">Complainant/s</div>
                <br>— against —<br><br>
                <span class="line" style="width:180px;">&nbsp;</span>
                <div class="label">Respondent/s</div>
            </td>
            <td style="width:50%;vertical-align:top;">
                Barangay Case No.: <strong>{{ $complaint->case_number }}</strong><br>
                For: <strong>{{ $complaint->category }}</strong><br><br>
                {{ $complaint->complainant_formal_name }}<br><br><br>
                {{ $complaint->respondent_name }}
            </td>
        </tr>
    </table>

    <div class="title">NOTICE TO CHOSEN PANGKAT MEMBER</div>

    <div style="text-align:right;">
        (Date): <u>{{ now()->format('F d, Y') }}</u>
    </div>

    <div class="body-text">
        TO: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    </div>

    <div class="body-text">
        Notice is hereby given that you have been chosen member of the Pangkat ng
        Tagapagkasundo amicably conciliate the dispute between the parties in the
        above-entitled case.
    </div>

    <div class="sig-line">&nbsp;</div>
    Punong Barangay/Lupon Secretary
    <br><br>

    Received this <u>________</u> day of <u>____________</u>, <u>{{ now()->format('Y') }}</u>.
    <br><br>

    <div class="sig-line">&nbsp;</div>
    Pangkat Member
</div>
</body>
</html>