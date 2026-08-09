# (A) feat: UserWork remove from gallery

> **Branch:** `feat/0162-user-work-remove`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-06.04  
> **Titolo e urgenza:** (A) feat: UserWork remove from gallery   
> **Project/issue link:** [#162](https://github.com/mrai64/yapcp/issues/162)  
> **milestone link:** [M1](https://github.com/mrai64/yapcp/milestones/1)  

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Rispetto al branch base `refactor/0129-user-works`, la funzione di rimozione delle opere dalla galleria utente (`UserWork`) nel branch `feat/0162-user-work-remove` è stata migrata dall'architettura controller standard Livewire al componente Volt Single-File ed è stata integrata nelle viste della galleria.

### 1. Refactoring Componente UI (Livewire Volt)

- **Migrazione a Volt Single-File Component:** È stato rimosso il vecchio controller Livewire a file separati (`app/Livewire/User/Work/Remove.php` e la relativa vista `resources/views/livewire/work/remove.blade.php`). Al suo posto è stato creato il componente Volt anonimo `resources/views/livewire/user/work/remove.blade.php` (`new class extends Component`).
- **Registrazione Rotta Volt:** Registrata la rotta Volt con parametro binding dell'opera:
  `Volt::route('/user/work/remove/{user_work}', 'user.work.remove')->middleware(['auth', 'verified'])->name('user.work.remove');`
- **Integrazione nelle Gallerie Utente:** Nelle viste della galleria dell'utente (`user.work.listed1` in formato lista e `user.work.listed2` in formato griglia di miniature) sono stati aggiunti i link diretti di rimozione (`route('user.work.remove', ['user_work' => $work])`).

### 2. Interfaccia di Rimozione & Logica di Soft Delete

- **Visualizzazione Anteprima e Dettagli:** La pagina di conferma mostra un'anteprima dell'immagine (`storage/photos/{imageUrl}`), il titolo dell'opera, le dimensioni fisiche (`width` &times; `height` px), l'orientamento (`Landscape`/`Portrait`), il tipo di colore (`Monochromatic`/`Colour`) e l'eventuale presenza del file RAW (`has_raw_file`).
- **Azione di Conferma:** Un form con il pulsante `Confirm remove` invoca il metodo Volt `removeUserWork()`.
- **Soft Delete:** Il metodo `removeUserWork()` esegue la cancellazione logica (`$this->userWork->delete()`), mantenendo intatto il file su disco e impostando il campo `deleted_at` sul database.
- **Reindirizzamento:** Al termine della cancellazione, l'utente viene reindirizzato alla propria dashboard (`route('user.dashboard')`) con un messaggio di sessione notificante l'avvenuta rimozione (`Removed ":title" from your Gallery`).

---

## 🗄️ Modifiche al Database

- [x] Nessuna nuova migration richiesta. Il modello `App\Models\UserWork` utilizza già il trait `SoftDeletes` e la colonna `deleted_at`.

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test passano in verde (`php artisan test`). È stata creata la suite di test Pest `tests/Feature/m002/i0162/UserWorkRemoveTest.php` che verifica autenticazione, rendering del componente Volt, esecuzione della soft delete e reindirizzamento con flash message.
- [x] **Docs:** Il file in `/resources/docs/dev/feat/0162-user-work-remove.md` è stato interamente aggiornato ed esteso.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte (`resources/docs/1.0/users/work_remove.md`).
- [x] **Cleanup:** Rimosso il vecchio controller `app/Livewire/User/Work/Remove.php` ed la relativa vista `resources/views/livewire/work/remove.blade.php`.
- [x] **Commit:** I messaggi dei commit sono chiari.

---

## 🚀 Note per il Deploy

- Niente da segnalare.