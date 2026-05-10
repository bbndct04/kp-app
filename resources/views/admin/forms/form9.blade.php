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
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
{{-- FRONT PAGE --}}
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

    <div class="title">S U M M O N S</div>

    <div class="body-text">
        TO: <u>{{ $complaint->respondent_name }}</u> &nbsp;&nbsp; <u>{{ $complaint->respondent_address }}</u><br>
        <div class="label">Respondents</div>
    </div>

    <div class="body-text">
        You are hereby summoned to appear before me in person, together with your
        witnesses, on the
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('d') : '____' }}</u>
        day of
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F') : '________' }}</u>,
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('Y') : '19__' }}</u>
        at
        <u>{{ $complaint->hearing_time ? \Carbon\Carbon::parse($complaint->hearing_time)->format('h:i') : '______' }}</u>
        o'clock in the morning/afternoon, then and there to answer to a complaint
        made before me, copy of which is attached hereto, for mediation/conciliation
        of your dispute with complainant/s.
    </div>

    <div class="body-text">
        You are hereby warned that if you refuse or willfully fail to appear in
        obedience to this summons, you may be barred from filing any counterclaim
        arising from said complaint.
    </div>

    <div class="body-text" style="font-weight:bold;">
        FAIL NOT or else face punishment as for contempt of court.
    </div>

    <div class="body-text">
        This <u>{{ now()->format('d') }}</u> day of <u>{{ now()->format('F') }}</u>, <u>{{ now()->format('Y') }}</u>.
    </div>

    <div class="sig-line">&nbsp;</div>
    Punong Barangay/Pangkat Chairman
</div>

{{-- BACK PAGE: Officer's Return --}}
<div class="page-break"></div>
<div class="border-box" style="margin-top:40px;">
    <div class="title">OFFICER'S RETURN</div>

    <div class="body-text">
        I served this summons upon respondent <u>{{ $complaint->respondent_name }}</u> on
        the <u>________</u> day of <u>____________</u>, <u>{{ now()->format('Y') }}</u>,
        and upon respondent <u>____________________</u> on the day of <u>____________</u>,
        <u>{{ now()->format('Y') }}</u>, by:
        <br><br>
        (Write name/s of respondent/s before mode by which he/they was/were served.)
        <br><br>
        Respondent/s
    </div>

    <table style="margin-top:10px;">
        <tr>
            <td style="width:40%;vertical-align:top;">
                <div class="sig-line">&nbsp;</div> 1.
                <div class="sig-line">&nbsp;</div> 2.
                <div class="sig-line">&nbsp;</div> 3.
                <div class="sig-line">&nbsp;</div> 4.
            </td>
            <td style="width:60%;vertical-align:top;font-size:11px;line-height:2;">
                handing to him/them said summons in person, or<br>
                handing to him/them said summons and he/they refused to receive it, or<br>
                leaving said summons at his/their dwelling with <u>__________</u> (name) a person of suitable age and discretion residing therein, or<br>
                leaving said summons at his/their office/place of business with <u>__________</u> (name) a competent person in charge thereof.
            </td>
        </tr>
    </table>

    <br>
    <div class="sig-line" style="width:150px;">&nbsp;</div>
    Officer
    <br><br>
    Received by Respondent/s representative/s:
    <table style="margin-top:10px;">
        <tr>
            <td>
                <div class="sig-line">&nbsp;</div>
                Signature
            </td>
            <td>
                <div class="sig-line">&nbsp;</div>
                Date
            </td>
        </tr>
        <tr>
            <td>
                <div class="sig-line">&nbsp;</div>
                Signature
            </td>
            <td>
                <div class="sig-line">&nbsp;</div>
                Date
            </td>
        </tr>
    </table>
</div>
</body>
</html>