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
        ol { line-height: 2; }
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

    <div class="title">CERTIFICATION TO FILE ACTION</div>

    <div class="body-text">This is to certify that:</div>

    <ol>
        <li>There has been a personal confrontation between the parties before the Punong Barangay/Pangkat ng Tagapagkasundo;</li>
        <li>A settlement was reached;</li>
        <li>The settlement has been repudiated in a statement sworn to before the Punong Barangay by <u>______________</u> on ground of <u>______________</u>; and</li>
        <li>Therefore, the corresponding complaint for the dispute may now be filed in court/government office.</li>
    </ol>

    <div class="body-text">
        This <u>{{ now()->format('d') }}</u> day of <u>{{ now()->format('F') }}</u>, <u>{{ now()->format('Y') }}</u>.
    </div>

    <div class="sig-line">&nbsp;</div>
    Lupon Secretary
    <br><br>
    Attested:
    <div class="sig-line">&nbsp;</div>
    Lupon Chairman<br>
    <span style="font-size:11px;">{{ $complaint->punong_barangay }}</span>
</div>
</body>
</html>