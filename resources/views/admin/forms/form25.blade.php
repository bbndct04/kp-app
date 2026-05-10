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

    <div class="title">MOTION FOR EXECUTION</div>

    <div class="body-text">Complainant/s Respondent/s state as follows:</div>

    <div class="body-text">
        1. On
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F d, Y') : '____________' }}</u>
        (Date) the parties in this case signed an amicable settlement/received the
        arbitration award rendered by the Lupon/Chairman/Pangkat ng Tagapagkasundo;<br><br>

        2. The period of ten (10) days from the above-stated date has expired without
        any of the parties filing a sworn statement of repudiation of the settlement
        before the Lupon Chairman a petition for nullification of the arbitration award
        in court; and<br><br>

        3. The amicable settlement/arbitration award is now final and executory.
        WHEREFORE, Complainant/s Respondent/s request that the corresponding writ
        of execution be issued by the Lupon Chairman in this case.
    </div>

    <div class="body-text">
        <u>{{ now()->format('F d, Y') }}</u><br>
        (Date)
    </div>

    <div class="sig-line">&nbsp;</div>
    Complainant/s Respondent/s
</div>
</body>
</html>