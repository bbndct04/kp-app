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

    <div class="title">
        NOTICE OF HEARING<br>
        (RE: FAILURE TO APPEAR)
    </div>

    <div class="body-text">
        TO: <u>{{ $complaint->respondent_name }}</u><br>
        <div class="label">Respondent/s</div>
    </div>

    <div class="body-text">
        You are hereby required to appear me/the Pangkat on the
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('d') : '____' }}</u>
        day of
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F') : '________' }}</u>,
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('Y') : '19__' }}</u>,
        at
        <u>{{ $complaint->hearing_time ? \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i') : '______' }}</u>
        o'clock in the morning/afternoon to explain why you failed to appear for
        mediation/conciliation scheduled on
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F d, Y') : '____________' }}</u>
        and why your counterclaim (if any) arising from the complaint should not be
        dismissed, a certificate to bar the filing of said counterclaim in court/government
        office should not be issued, and contempt proceedings should not be initiated in
        court for willful failure or refusal to appear before the Punong Barangay/Pangkat
        ng Tagapagkasundo.
    </div>

    <div class="body-text">
        This <u>{{ now()->format('d') }}</u> day of <u>{{ now()->format('F') }}</u>, <u>{{ now()->format('Y') }}</u>.
    </div>

    <div class="sig-line">&nbsp;</div>
    Punong Barangay/Pangkat Chairman<br>
    <span style="font-size:11px;">(Cross out whichever is not applicable)</span>
    <br><br>

    Notified this <u>________</u> day of <u>____________</u>, <u>{{ now()->format('Y') }}</u>.
    <br><br>

    <table>
        <tr>
            <td>Respondent/s<br><div class="sig-line">&nbsp;</div></td>
            <td>Complainant/s<br><div class="sig-line">&nbsp;</div></td>
        </tr>
    </table>
</div>
</body>
</html>