<table>
    <!-- no thead intentionally -->
    <!-- test url: https://yapcp.test/contest/export/FIAF2/e8ac5674-c3d1-4afa-adaf-a7d5ed82d292/FIAF -->
    <tbody>
        <!-- row: 1 -->
        <tr>
            <td>&nbsp;</td>
            <td colspan="11" style="font-weight:bold;text-align:center;font-size:20px">Concorso {{$contest->name_en}}</td>
        </tr>
        <!-- row: 2 headers it_IT --> 
        <tr>
            <td style="height:65px;width:78px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Patrocinio concorso
            </td>
            <td style="height:65px;width:92px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Cognome autore
            </td>
            <td style="height:65px;width:92px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Nome autore
            </td>
            <td style="height:65px;width:153px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Codice Fiscale
            </td>
            <td style="height:65px;width:80px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Tessera FIAF
            </td>
            <td style="height:65px;width:100px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                onorificenza FIAF FIAP
            </td>
            <td style="height:65px;width:100px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Sezione
            </td>
            <td style="height:65px;width:80px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Codifica Tema
            </td>
            <td style="height:65px;width:200px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Titolo Foto
            </td>
            <td style="height:65px;width:80px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Anno prima ammissione
            </td>
            <td style="height:65px;width:80px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Esito giuria
            </td>
            <td style="height:65px;width:200px;font-size:9px;font-family:sans-serif;font-weight:bold;text-align:center;vertical-align:middle;">
                Eventuale premio assegnato
            </td>
        </tr>
        <!-- rows 3...n -->
        @foreach ($reportData as $row)
        <tr>
            <td style="text-align:center">{{$patronage_code }}</td>
            <td>{{$row['lastName']     }}</td>
            <td>{{$row['firstName']    }}</td>
            <td>{{$row['italianTaxId'] }}</td>
            <td>{{$row['cardId']       }}</td>
            <td>{{$row['distinction']  }}</td>
            <td style="text-align:center">{{$row['section'] }}</td>
            <td style="text-align:center">{{$row['theme_code'] }}</td>
            <td>{{$row['work_title'] }}</td>
            <td style="text-align:center">{{$row['yof1st'] }}</td>
            <td style="text-align:center">{{$row['admit'] }}</td>
            <td>{{$row['award'] ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>