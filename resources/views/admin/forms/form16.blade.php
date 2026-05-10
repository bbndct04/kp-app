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

    <div class="title">AMICABLE SETTLEMENT</div>

    <div class="body-text">
        We, complainant/s and respondent/s in the above-captioned case, do hereby
        agree to settle our dispute as follows:
    </div>

    <div style="margin:16px 0;">
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        {{ $complaint->settlement_details ?? $complaint->mediation_notes }}
    </div>

    <div class="body-text">
        and bind ourselves to comply honestly and faithfully with the above terms of settlement.<br>
        Entered into this
        <u>{{ now()->format('d') }}</u>
        day of
        <u>{{ now()->format('F') }}</u>,
        <u>{{ now()->format('Y') }}</u>.
    </div>

    <table style="margin-top:20px;">
        <tr>
            <td style="width:50%;">
                <div class="sig-line">&nbsp;</div>
                Complainant/s<br>
                <span style="font-size:11px;">{{ $complaint->complainant_formal_name }}</span>
            </td>
            <td style="width:50%;">
                <div class="sig-line">&nbsp;</div>
                Respondent/s<br>
                <span style="font-size:11px;">{{ $complaint->respondent_name }}</span>
            </td>
        </tr>
    </table>

    <div style="margin-top:24px;">
        <div style="font-weight:bold;text-align:center;">ATTESTATION</div>
        <div class="body-text">
            I hereby certify that the foregoing amicable settlement was entered into by the
            parties freely and voluntarily, after I had explained to them the nature and
            consequence of such settlement.
        </div>
        <div class="sig-line">&nbsp;</div>
        Punong Barangay/Pangkat Chairman<br>
        <span style="font-size:11px;">{{ $complaint->punong_barangay }}</span>
    </div>
</div>
</body>
</html>