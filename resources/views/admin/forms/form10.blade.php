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
        OFFICE OF THE PUNONG BARANGAY
    </div>

    <div class="title">NOTICE FOR CONSTITUTION OF PANGKAT</div>

    <div class="body-text">
        TO: <u>{{ $complaint->complainant_formal_name }}</u> &nbsp;&nbsp;&nbsp;&nbsp;
            <u>{{ $complaint->respondent_name }}</u><br>
        <div style="display:flex;justify-content:space-between;">
            <span class="label">Complainant/s</span>
            <span class="label">Respondent/s</span>
        </div>
    </div>

    <div class="body-text">
        You are hereby required to appear before me on the
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('d') : '____' }}</u>
        day of
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F') : '________' }}</u>,
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('Y') : '19__' }}</u>,
        at
        <u>{{ $complaint->hearing_time ? \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i') : '______' }}</u>
        o'clock in the morning/afternoon for the constitution of the Pangkat ng
        Tagapagkasundo which shall conciliate your dispute. Should you fail to agree
        on the Pangkat membership or to appear on the aforesaid date for the
        constitution of the Pangkat, I shall determine the membership thereof by
        drawing lots.
    </div>

    <div class="body-text">
        This <u>{{ now()->format('d') }}</u> day of <u>{{ now()->format('F') }}</u>, <u>{{ now()->format('Y') }}</u>.
    </div>

    <div class="sig-line">&nbsp;</div>
    Punong Barangay
    <br><br>

    Notified this <u>________</u> day of <u>____________</u>, <u>{{ now()->format('Y') }}</u>.
    <br><br>

    <table>
        <tr>
            <td style="width:50%;">
                TO:<br>
                <div class="sig-line">&nbsp;</div>
                Complainant/s
            </td>
            <td style="width:50%;">
                <br>
                <div class="sig-line">&nbsp;</div>
                Respondent/s
            </td>
        </tr>
    </table>
</div>
</body>
</html>