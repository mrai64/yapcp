#  Language translation

issue: [#93](https://github.com/mrai64/yapcp/issues/93)  
last update: 2026-03-05  
open: 2025-12-25  

- [🏠 index](/{{route}}/dev/state-of-art)

---

Vedi anche <https://laravel.com/docs/12.x/localization>

I sorgenti e i blade sono farciti di messaggi traducibili,
incapsulati nella chiamata di funzione "__", chiamata helper.
La prima opzione
self-made sarebbe quella di esportare una ricerca
di tutte le occorrenze dei caratteri `__(` e poi da questo
ricavare le frasi in inglese che andranno a riempire
il file /lang/en.json, da questo sarà in seguito,
da me e/o tramite volontari, tradotto e *versionato* ogni altro
/lang/lang_code.json

Cosa contiene lang/es.json:  
```json
{
  "English words": "English words"
}
```

Cosa contiene lang/it.json:  
```json
{
  "English words": "Termini inglesi"
}
```

Si possono mettere delle frasi con parametri: Sì. 
Esempio:
'max upload file size is :max-size', oppure  
'max-size.error': 'max upload file size is :max-size'

nel sorgente  
echo __("max-size.error", "6MB");

## Esistono dei package per questo

Certo che sì.
