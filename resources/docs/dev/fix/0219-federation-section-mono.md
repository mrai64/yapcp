# Feature: Fix Federation Section Monochrome Field

> **Branch:** `fix/0219-federation-section-mono`  
> **Stato:** In Corso / Revisione  
> **priorità:** A  
> **id assegnato:** 2026-08-21.01  
> **Titolo e urgenza:** (A) fix: FederationSection Monochrome required flag even off  
> **Project/issue link:** [#219](https://github.com/mrai64/yapcp/issues/219)
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Problema: la visualizzazione del flag "Monochrome only" nella view della sezione di una federazione non mostrava correttamente lo stato perché veniva usato un nome di campo errato nella view.

Soluzione applicata:

- Nella view `resources/views/livewire/federation-section/listed.blade.php` il codice faceva riferimento a `$section->monochrome_required` (nome errato).  
- Il campo corretto nel modello/dataset è `$section->monochromatic_required`.  
  Ho aggiornato la view per usare la proprietà corretta, così la UI riflette
  lo stato reale della sezione (✅ YES / ❌ NO).

Motivazione:

- La discrepanza tra il nome della proprietà usata nella view e quella presente nel modello causava la mancata visualizzazione del flag monocromatico.
- Correggere il nome evita di introdurre altri rami di compatibilità (alias, accessor) e mantiene il codice coerente col modello esistente.

Impatto:

- Cambiamento localizzato alla view; non sono necessarie modifiche al modello né alla migration.
- Comportamento utente: il badge/testo "Monochrome only" ora mostra correttamente lo stato atteso.

## 🗂️ File modificati (con sintesi)

1) Correzione view Livewire:

- File: resources/views/livewire/federation-section/listed.blade.php
- Tipo: modifica riga singola — uso della proprietà corretta.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Nessuna modifica al database necessaria

## ✅ Test e verifiche consigliate

> <!-- to avoid index -->
- Verificare in ambiente di staging che per una sezione con `monochromatic_required = true` la view mostri `✅ YES`, e `❌ NO` se false.
- Eseguire test manuale della pagina di listing federazioni con diverse sezioni (BN/Color).
- Eventualmente aggiungere test browser/feature che *assertino* la presenza del testo corretto.

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna migration da eseguire.
- Deploy standard del codice; dopo deploy verificare la view elencata in produzione/staging.

## Riferimenti

- Branch di confronto: `docs/0189-federation-section-listed` → `fix/0219-federation-section-mono`
- Issue: <https://github.com/mrai64/yapcp/issues/219>

autore: github gratuito
revisore: mrai64
ultima modifica: 21 agosto 2026
