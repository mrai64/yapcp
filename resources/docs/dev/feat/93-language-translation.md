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

Seguendo una richiesta, che avevo credo già fatto, a Gemini
ho installato un package per estrarre le stringhe
di testo traducibili, metterle in sequenza alfabetica
e salvarle in lang/xx.json per la traduzione.

```sh
clear
composer require kkomelin/laravel-translatable-string-exporter --dev
php artisan vendor:publish --provider="Kkomelin\TranslatableStringExporter\Providers\ExporterServiceProvider" --tag="config"
composer require kkomelin/laravel-translatable-string-exporter --dev
php artisan config:clear
php artisan cache:clear
php artisan vendor:publish --provider="Kkomelin\TranslatableStringExporter\Providers\ExporterServiceProvider" --tag="config"
php artisan vendor:publish
php artisan translatable:export en
php artisan translatable:export it
```

Rilevate anche delle chiavi "appena diverse" come
`Contest id` vs `Contest Id` vs `Contest id:`,
e verificato che rilanciando l'export i file vengono aggiornati
per le chiavi mancanti / aggiunte, ma quelle già convertite
restano immutate.

Adesso però serve passare e ripassare /lang/en.json
per ridurre le chiavi. Sono state modificate una manciata di blade per
questo.

## Chiusura della issue

Per verificare come funziona la chiusura automatica,
comunque la modifica dei due file continuerà.

