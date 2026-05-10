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

    <div class="title">ARBITRATION AWARD</div>

    <div class="body-text">
        After hearing the testimonies given and careful examination of the evidence
        presented in this case, award is hereby made as follows:
    </div>

    <div style="margin:16px 0;">
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        {{ $complaint->settlement_details ?? $complaint->mediation_outcome ?? '' }}
    </div>

    <div class="body-text">
        Made this
        <u>{{ now()->format('d') }}</u>
        day of
        <u>{{ now()->format('F') }}</u>,
        <u>{{ now()->format('Y') }}</u>
        at
        <u>Barangay New Kababae, Olongapo City</u>.
    </div>

    <div class="sig-line">&nbsp;</div>
    Punong Barangay/Pangkat Chairman *<br>
    <span style="font-size:11px;">{{ $complaint->punong_barangay }}</span>
    <br><br>

    <div class="sig-line">&nbsp;</div>
    Member
    <br><br>

    <div class="sig-line">&nbsp;</div>
    Member
    <br><br>

    ATTESTED:
    <br><br>
    <div class="sig-line">&nbsp;</div>
    Punong Barangay/Lupon Secretary **
    <br><br>

    <div style="font-size:11px;margin-top:16px;">
        * To be signed by either, whoever made the arbitration award.<br>
        ** To be signed by the Punong Barangay if the award is made by the Pangkat
        Chairman, and by the Lupon Secretary if the award is made by the Punong Barangay.
    </div>
</div>
</body>
</html>