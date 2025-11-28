select distinct vote_list.sum_vote from
(select sum(vote) as sum_vote, work_id
from pcp_contest_votes
where section_id = '059e0687-f8a4-4dbf-9add-8e9c6ff04ca7'
group by work_id
order by sum_vote desc) as vote_list;

select count(*)
from pcp_contest_works
where section_id = '059e0687-f8a4-4dbf-9add-8e9c6ff04ca7';

SELECT
    distinct vote_data.voted_sum,
    -- Usa la funzione RANK() per calcolare la posizione (numero di record con voto >=)
    RANK() OVER (ORDER BY vote_data.voted_sum DESC) AS rank_by_voted_sum,
    (10000 * RANK() OVER (ORDER BY vote_data.voted_sum DESC) / 192) as PERCENT -- :total_participant_works
FROM (
    -- Subquery per calcolare i voti totali (voted_sum) e il numero di voti (vote_received)
    SELECT
        SUM(vote) AS voted_sum,
        work_id
    FROM
        `pcp_contest_votes`
    WHERE
        section_id = '059e0687-f8a4-4dbf-9add-8e9c6ff04ca7' -- :section_id
    GROUP BY
        work_id
) AS vote_data
GROUP BY
    vote_data.voted_sum
ORDER BY
    vote_data.voted_sum DESC;

select distinct
    board_votes.voted_sum,
    board_votes.rank_voted_sum,
    board_votes.percentuale
from (

SELECT
    vote_data.voted_sum as voted_sum,
    vote_data.work_id,
    -- Usa la funzione RANK() per calcolare la posizione (numero di record con voto >=)
    RANK() OVER (ORDER BY vote_data.voted_sum DESC) AS rank_voted_sum,
    ROUND(10000 * RANK() OVER (ORDER BY vote_data.voted_sum DESC) / 192) as percentuale -- :total_participant_works) as PERCENT
FROM (
    -- Subquery per calcolare i voti totali (voted_sum) e il numero di voti (vote_received)
    SELECT
        COUNT(*) AS vote_received,
        SUM(vote) AS voted_sum,
        work_id
    FROM
        `pcp_contest_votes`
    WHERE
        section_id = '059e0687-f8a4-4dbf-9add-8e9c6ff04ca7' -- :section_id
    GROUP BY
        work_id
) AS vote_data
    ) as board_votes
group by
    board_votes.voted_sum,
    board_votes.rank_voted_sum,
    board_votes.percentuale
ORDER BY
    board_votes.voted_sum desc;
