# *Gemini say*


Domanda: In Laravel eloquent devo realizzare una query un po' complessa, prende i voti di una tabella concorso di cui ci sono :total_participant_works, con un :contest_id e un :section_id per estrarre l'elenco dei lavori più votati discendente e una percentuale sul numero di voti assegnati pari o superiori. 

```sql
SELECT
    vote_data.vote_received,
    vote_data.voted_sum,
    vote_data.work_id,
    -- Usa la funzione RANK() per calcolare la posizione (numero di record con voto >=)
    RANK() OVER (ORDER BY vote_data.voted_sum DESC) AS rank_by_voted_sum,
    (100 * RANK() OVER (ORDER BY vote_data.voted_sum DESC) / :total_participant_works) as PERCENT
FROM (
    -- Subquery per calcolare i voti totali (voted_sum) e il numero di voti (vote_received)
    SELECT
        COUNT(*) AS vote_received,
        SUM(vote) AS voted_sum,
        work_id
    FROM
        `pcp_contest_votes`
    WHERE
        contest_id = :contest_id
        AND section_id = :section_id
    GROUP BY
        work_id
) AS vote_data
ORDER BY
    vote_data.voted_sum DESC;
```

Risposta: serve una funzione che partendo dai
3 dati in input: contest_id, section_id e numero di lavori partecipanti,

```php
use Illuminate\Support\Facades\DB;

/**
 * Esegue la query per ottenere la classifica e la percentuale dei lavori più votati.
 *
 * @param int $contestId L'ID del concorso.
 * @param int $sectionId L'ID della sezione.
 * @param int $totalParticipantWorks Il numero totale di lavori partecipanti in questa sezione.
 * @return \Illuminate\Support\Collection
 */
function getRankedWorks($contestId, $sectionId, $totalParticipantWorks)
{
    // 1. Definisci i parametri che saranno legati (binding) alla query.
    // Questo è fondamentale per prevenire attacchi di SQL Injection.
    $bindings = [
        'contest_id' => $contestId,
        'section_id' => $sectionId,
        'total_participant_works' => $totalParticipantWorks,
    ];

    // 2. Costruisci la Subquery (la parte interna)
    // Selezioniamo il conteggio dei voti, la somma dei voti e raggruppiamo per work_id
    $subquery = DB::table('pcp_contest_votes')
        ->select(
            DB::raw('COUNT(*) AS vote_received'),
            DB::raw('SUM(vote) AS voted_sum'),
            'work_id'
        )
        ->where('contest_id', $contestId)
        ->where('section_id', $sectionId)
        ->groupBy('work_id');

    // 3. Costruisci la Query Principale (la parte esterna)
    // Utilizziamo la subquery come una "tabella" temporanea
    $results = DB::table(DB::raw("({$subquery->toSql()}) AS vote_data"))
        ->select(
            'vote_data.vote_received',
            'vote_data.voted_sum',
            'vote_data.work_id',
            // Aggiungi le funzioni di finestra RANK() e il calcolo della percentuale
            DB::raw('RANK() OVER (ORDER BY vote_data.voted_sum DESC) AS rank_by_voted_sum'),
            // Il calcolo della percentuale utilizzando il parametro totalParticipantWorks
            DB::raw("(100 * RANK() OVER (ORDER BY vote_data.voted_sum DESC) / {$totalParticipantWorks}) as percent")
        )
        ->mergeBindings($subquery) // **IMPORTANTE**: Unisce i binding della subquery
        ->orderBy('vote_data.voted_sum', 'desc')
        ->get();

    return $results;
}

// Esempio di utilizzo:
// $rankedWorks = getRankedWorks(1, 2, 50);
```
