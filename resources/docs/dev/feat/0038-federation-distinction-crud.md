# Feature: Nome Funzione

> **Branch:** `feat/0038-federation-distinction-crud`  
> **Stato:** In Corso  
> **priorità:** C  
> **id assegnato:** 2025-10-18.03  
> **Titolo e urgenza:** new Federation Recognition, Honors, Distinction management  
> **Project/issue link:** [#38](https://github.com/mrai64/yapcp/issues/38)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Le federazioni prevedono con  un proprio regolamento,
l'assegnazione per meriti o per concessione di titoli onorifici
senza valore legale, ma che possono accompagnare nome e cognome
dei concorrenti ai concorsi, essere riportati nei cataloghi
e nelle comunicazioni ufficiali.  
Questo modello deve rappresentare la lista delle onorificenze
personalmente assegnate e ogni concorrente può aggiustare le proprie.
Nella dashboard dell'utente ci sarà il dato aggiornato
e il link per andarlo ad aggiungere o modificare.


## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration [`2026_05_01_170449_create_federation_distinctions_table`](/database/migrations/2026_05_01_170449_create_federation_distinctions_table.php)
- [ ] Lorem ipsum
- [ ] Lorem ipsum
- [ ] Lorem ipsum
- [ ] Lorem ipsum

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
- Eseguire `php artisan db:seed --class=FederationDistinctionSeeder`
