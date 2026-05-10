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

    <div class="title">NOTICE OF EXECUTION</div>

    <div class="body-text">
        WHEREAS, on
        <u>{{ $complaint->hearing_date ? \Carbon\Carbon::parse($complaint->hearing_date)->format('F d, Y') : '____________' }}</u>
        (date), an amicable settlement was signed by the parties in the above-entitled
        case [or an arbitration award was rendered by the Punong Barangay/Pangkat ng
        Tagapagkasundo];<br>

        WHEREAS, the terms and conditions of the settlement, the dispositive portion
        of the award, read:
    </div>

    <div style="margin:12px 0;">
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        <span class="line">&nbsp;</span>
        {{ $complaint->settlement_details ?? $complaint->mediation_notes ?? '' }}
    </div>

    <div class="body-text">
        The said settlement/award is now final and executory;<br><br>

        WHEREAS, the party obliged <u>{{ $complaint->respondent_name }}</u> (name)
        has not complied voluntarily with the aforestated amicable settlement/arbitration
        award, within the period of five (5) days from the date of hearing on the motion
        for execution;<br>

        NOW, THEREFORE, in behalf of the Lupong Tagapamayapa and by virtue of the
        powers vested in me and the Lupon by the Katarungang Pambarangay Law and
        Rules, I shall cause to be realized from the goods and personal property of
        <u>{{ $complaint->respondent_name }}</u> (name of party obliged) the sum of
        <u>____________________</u> (state amount of settlement or award) upon in the
        said amicable settlement [or adjudged in the said arbitration award], unless
        voluntary compliance of said settlement or award shall have been made upon
        receipt hereof.<br>

        Signed this <u>{{ now()->format('d') }}</u> day of <u>{{ now()->format('F') }}</u>,
        <u>{{ now()->format('Y') }}</u>.
    </div>

    <div class="sig-line">&nbsp;</div>
    Punong Barangay<br>
    <span style="font-size:11px;">{{ $complaint->punong_barangay }}</span>
    <br><br>

    Copy furnished:
    <table style="margin-top:10px;">
        <tr>
            <td>
                <div class="sig-line">&nbsp;</div>
                Complainant/s<br>
                <span style="font-size:11px;">{{ $complaint->complainant_formal_name }}</span>
            </td>
            <td>
                <div class="sig-line">&nbsp;</div>
                Respondent/s<br>
                <span style="font-size:11px;">{{ $complaint->respondent_name }}</span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>