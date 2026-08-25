# Feature: Elencare i "campi in più" richiesti dalle Federazioni

> **Branch:** `feat/0195-federation-more-read`  
> **Stato:** chiuso
> **priorità:** A  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, solo senza [id...]  
> **Project/issue link:** [#195](https://github.com/mrai64/yapcp/issues/195)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

---

## 📝 Logica Tecnica

Questa feature documenta la vista di **consultazione pubblica** del modello `FederationMore`. L'architettura segue il pattern server-side rendering con Blade template, garantendo:

- **Accesso pubblico:** Nessuna autenticazione richiesta per la visualizzazione
- **Rendering lato server:** Template Blade renderizzato dal framework Laravel
- **Componenti UI condizionali:** Elementi di gestione (modifica, eliminazione) assenti per utenti non-admin
- **Impaginazione e filtri:** Gestione dell'elenco con supporto a paginazione, ricerca e ordinamento

La vista espone esclusivamente i campi destinati alla consultazione pubblica, nascondendo metadati amministrativi sensibili.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Tabella `federation_mores` già creata (dalla macro-issue #183)
- [x] Campi di base: `id`, `federation_id`, `field_name`, `field_value`, `field_type`, `is_required`, `visibility`
- [x] Timestamp: `created_at`, `updated_at`
- [x] Tracciabilità: `created_by` (FK su `users`)
- [ ] Aggiunto indice su `federation_id` per query optimization
- [ ] Aggiunto indice su `visibility` per filtri pubblici

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna nuova migration richiesta (il modello è stato creato in #183)
- Verificare la route di consultazione in `routes/web.php`:
  - `GET /federation` → lista paginata
  - `GET /federation/{id}` → dettaglio singolo record
- Assicurare che i middleware di autenticazione NON siano applicati a queste rotte
- Cache: valutare il caching della lista con TTL di 5 minuti (`@cache`)

---

## 🎯 Checklist di Dettaglio

- [ ] Documentare la rotta web di consultazione (es. `/federation` o `/federation/{id}`)
- [ ] Elencare i campi visualizzati a schermo per l'utente standard
  - [ ] Titolo della federation
  - [ ] Nome del campo aggiuntivo (`field_name`)
  - [ ] Valore del campo (`field_value`)
  - [ ] Tipo di dato (`field_type` - leggibile dall'utente)
  - [ ] Data di creazione (`created_at`)
- [ ] Documentare le logiche di impaginazione, filtri e ordinamento presenti
  - [ ] Impaginazione: 15 record per pagina (configurabile)
  - [ ] Filtro per Federation
  - [ ] Ricerca per `field_name`
  - [ ] Ordinamento: per data (desc), nome (asc)
- [ ] Verificare che nei template NON vengano renderizzati pulsanti di gestione per utenti non-admin

## 📊 Matrice di Visibilità UI

| Elemento | Guest | Autenticato | Admin |
| --- | --- | --- | --- |
| Lista campi | ✅ | ✅ | ✅ |
| Dettagli campo | ✅ | ✅ | ✅ |
| Pulsante Modifica | ❌ | ❌ | ✅ |
| Pulsante Elimina | ❌ | ❌ | ✅ |
| Pulsante Nuovo | ❌ | ❌ | ✅ |
| Metadati admin | ❌ | ❌ | ✅ |

---

## ✅ Criteria di Accettazione (Definition of Done)

- [x] La vista di consultazione è descritta in ogni sua componente UI
- [x] È confermato che la consultazione non richiede autenticazione
- [x] Template Blade completamente documentati
- [x] Impaginazione e filtri specificati
- [x] Matrice di visibilità per ruoli definita
