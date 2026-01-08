<table>
    <!-- no thead intentionally -->
    <!-- test url: https://yapcp.test/contest/export/e8ac5674-c3d1-4afa-adaf-a7d5ed82d292/FIAF -->
    <tbody>
        <!-- row: 1 -->
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="9" style="font-weight:bold;font-size:20px">Concorso {{$contest->name_en}}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size:9px;font-weight:bold;">Codice patrocinio</td>
            <td style="font-size:9px;font-weight:bold;">Tessera FIAF</td>
            <td style="font-size:9px;font-weight:bold;">Codice Fiscale</td>
            <td style="font-size:9px;font-weight:bold;">Cognome Autore</td>
            <td style="font-size:9px;font-weight:bold;">Nome Autore</td>
            <td style="font-size:9px;font-weight:bold;">Indirizzo Autore</td>
            <td style="font-size:9px;font-weight:bold;">CAP Autore</td>
            <td style="font-size:9px;font-weight:bold;">Autore Città</td>
            <td style="font-size:9px;font-weight:bold;">Autore Provincia</td>
            <td style="font-size:9px;font-weight:bold;">Autore email</td>
            <td style="font-size:9px;font-weight:bold;">onorificenza</td>
            <!-- for every section/theme -->
            @foreach ($contest->sections as $section)
            <td style="font-size:9px;font-weight:bold;">Section {{$section->code}} - {{$section->name_en}} - Partecipazione </td>
            <td style="font-size:9px;font-weight:bold;">Section {{$section->code}} - {{$section->name_en}} - Numero Ammissioni </td>
            @endforeach 
            <!--/for every section/theme -->
        </tr>
        @foreach($excel_rows as $part)
        <tr>
            <td style="font-size:9px;font-weight:bold;">{{$contest->federation_list}}</td>
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
        <tr>
            <td style="font-size:9px;font-weight:bold;">2019Y1</td>
            <td>045821</td>
            <td>PPLPNI46A18H734G</td>
            <td>Pallino</td>
            <td>Pinco</td>
            <td>Via V giornate, 37</td>
            <td>35013</td>
            <td>Cittadella</td>
            <td>PD</td>
            <td><a href="mailto:pinco.pallino@infiniteone.it">pinco.pallino@infiniteone.it</a></td>
            <td>AFIAP</td>
            <td>sezione 1 -partecipazione</td>
            <td>sezione 1 - numero opere ammesse</td>
        </tr>
    </tbody>
</table>