<table>
    <!-- no thead intentionally -->
    <!-- test url: https://yapcp.test/contest/export/e8ac5674-c3d1-4afa-adaf-a7d5ed82d292/FIAF -->
    <tbody>
        <!-- row: 1 -->
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="9" style="font-weight:bold;text-align:center;font-size:20px">Concorso {{$contest->name_en}}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:78px">Patrocinio concorso</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:78px">Tessera FIAF</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:154px">Codice Fiscale</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:92px">Cognome Autore</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:92px">Nome Autore</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:232px">Indirizzo Autore</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:63px">CAP</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:166px">Autore Città</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:69px">Autore Provincia Indirizzo</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:120px">Autore email</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width: 120px;">onorificenza</td>
            <!-- for every section/theme -->
            @foreach ($contest->sections as $section)
            <td style="font-size:9px;font-weight:bold;text-align:center;width:120px;">  {{$section->name_en}} - Partecipazione - {{$section->code}}</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;width:120px;"> {{$section->name_en}} - Numero Ammissioni - {{$section->code}}</td>
            @endforeach 
            <!--/for every section/theme -->
        </tr>
        @foreach($excel_rows as $part)
        <tr>
            <td style="font-size:9px;font-weight:bold;text-align:center;">{{$contest->federation_list}}</td>
            <td>{{$part['fed_cardId']}}</td>
            <td>{{$part['fed_italianTaxId']}}</td>
            <td>{{$part['last_name']}}</td>
            <td>{{$part['first_name']}}</td>
            <td>{{$part['address']}}</td>
            <td>{{$part['postal_code']}}</td>
            <td>{{$part['city']}}</td>
            <td>{{$part['region']}}</td>
            <td><a href="mailto:{{$part['email']}}">{{$part['email']}}</a></td>
            <td>{{$part['fed_fiafDistinctions']}}</td>
            @foreach ($contest->sections as $section)
            <td style="font-size:9px;font-weight:bold;text-align:center;"> {{$part['sez_'.$section->code.'_has']}}</td>
            <td style="font-size:9px;font-weight:bold;text-align:center;"> {{$part['sez_'.$section->code.'_admit']}}</td>
            @endforeach 
        </tr>
        @endforeach
    </tbody>
</table>