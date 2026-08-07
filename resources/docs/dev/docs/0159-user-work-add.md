# Doc

> **Branch:** `docs/0159-user-work-add`  
> **Stato:** In Corso
> **priorità:** A  
> **id assegnato:** 2026-08-06.01  
> **Titolo e urgenza:** (A) docs: User and Dev docs for UserWork upload n miniature build  
> **Project/issue link:** [#159](https://github.com/mrai64/yapcp/issues/159)
> **milestone link:** [M2](https://github.com/mrai64/yapcp/milestones/2)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica: Upload Opere e Generazione Miniature

Componente Livewire Volt SFC (`add.blade.php`) per il caricamento delle opere fotografiche da parte dell'utente autenticato.

### Flusso Operativo

1. **Validazione Form:** Controllo di `title_en` (stringa max 250), `userWorkTempImage` (JPG/JPEG max 9MB), flag monocromatico e disponibilità file RAW.
2. **Storage Immagine Originale:**
   - Generazione UUID per il file.
   - Calcolo dimensioni (`long_size`, `short_size`) e peso file in Byte.
   - Salvataggio su disco `public` al percorso `/storage/app/public/photos/[country_id]/[last_name]/[first_name]_[user_id]/[img_uuid].[ext]`.
3. **Generazione Miniatura (Intervention Image v3):**
   - Utilizzo del driver Imagick per la lettura e scalatura (`scaleDown(300, 300)`).
   - Encodification in JPEG (qualità 80%).
   - Salvataggio al percorso `photos/.../300_[img_uuid].[ext]`.
4. **Persistenza DB:** Creazione del record `UserWork` con `Str::uuid7()` assegnato dal model.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
Nessuna modifica dalla issue 129

### 👮‍♂️ Pre-Merge Check

- [x] Test unitari/feature Pest eseguiti con successo.
- [x] Percorsi storage verificati.

## 🚀 Note per il Deploy

> <!-- to avoid index -->
niente da segnalare
