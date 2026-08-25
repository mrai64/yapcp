# Feature: Nome Funzione

> **Branch:** `fix/0235-federation-more-referenced-set-typo`  
> **Stato:** Chiuso
> **priorità:** A  
> **id assegnato:** 2026-08-24.01  
> **Titolo e urgenza:** Quello riportato nel project, solo senza [id...]  
> **Project/issue link:** [#235](https://github.com/mrai64/yapcp/issues/235)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

# Scheda Tecnica: Confronto Branch fix/0235 vs feat/0231

## Panoramica

La branch **fix/0235-federation-mores-referenced-set-typo** contiene correzioni di naming convention e aggiunta di relazioni nel modello `FederationMore`, basato sulla feature in **feat/0231-federation-more-listed**.

---

## Modifiche Principali

### 1. **Rinominazione Model (Singolare → Singolare)**

> <!-- avoid larecpe index -->
- ❌ `FederationMoresReferencedSets.php` (plurale - sconsigliato)
- ✅ `FederationMoresReferencedSet.php` (singolare - convention corretta)

**Motivo:** La naming convention di Laravel prevede nomi di modelli al singolare.

---

### 2. **Aggiornamento Modello FederationMore**

#### 2.1 Commento Documentazione

```diff
- 'referenced', //             real pk - lowercase
+ 'referenced', //             fk federation_mores_referenced_sets.id
```

**Chiarimento:** Il campo `referenced` non è una PK bensì una foreign key verso la lookup table.

#### 2.2 Nuovo Metodo Relazione (BelongsTo)

```php
// federation_mores.referenced > federation_mores_referenced_sets.id
public function federationMoresReferenced(): BelongsTo
{
    $referenced = $this->belongsTo(
        related: FederationMoresReferencedSet::class,
        foreignKey: 'referenced', // should be federation_mores.referenced_table_id
        ownerKey: 'id' // federation_mores_related_sets.id 
    );
    // Log
    return $referenced;
}
```

**Nota:** Metodo aggiunto a scopo documentativo, definisce esplicitamente il legame con la lookup table.

#### 2.3 TODO Comment

```php
// federation_mores.federation_id > user_contact_mores.federation_id
+ // TODO must become userContactMores()
public function userMores(): HasMany
```

**Riflessione tecnica:** Metodo rinominazione futura per coerenza di naming.

#### 2.4 Correzione Nome Model in Metodo

```diff
- $referencedTables = FederationMoresReferencedSets::all();
+ $referencedTables = FederationMoresReferencedSet::all();
```

#### 2.5 Miglioramento Commento Documentazione

```diff
- /**
-  * Loop over the, few but dynamically listed, referenced in
-  * federation_mores_referenceds to check if "is in use"
-  * in the table itself - first true exit true
-  */
+ /**
+  * Loop over the, few but dynamically listed, referenced in
+  * federation_mores_referenced_sets to check if "is in use"
+  * in the table itself - OR sequence, first true: exit true
+  */
```

**Miglioramenti:**

> <!-- avoid larecpe index -->
- Nome tabella corretto (typo: `_referenceds` → `_referenced_sets`)
- Logica esplicitata: "OR sequence" (primo true: exit)

---

### 3. **File Database - Factory**

> <!-- avoid larecpe index -->
- ❌ `database/factories/FederationMoresReferencedSetsFactory.php`
- ✅ `database/factories/FederationMoresReferencedSetFactory.php`

**Contenuto aggiornato:** Nome classe da `FederationMoresReferencedSetsFactory` → `FederationMoresReferencedSetFactory`

---

### 4. **File Database - Seeder**

> <!-- avoid larecpe index -->
- ❌ `database/seeders/FederationMoresReferencedSetsSeeder.php`
- ✅ `database/seeders/FederationMoresReferencedSetSeeder.php`

**Aggiornamenti interni:**

```diff
- use App\Models\FederationMoresReferencedSets;
+ use App\Models\FederationMoresReferencedSet;

- FederationMoresReferencedSets::factory()->create([
+ FederationMoresReferencedSet::factory()->create([
   'id' => 'user_contact_mores',
 ]);
- FederationMoresReferencedSets::factory()->create([
+ FederationMoresReferencedSet::factory()->create([
   'id' => 'user_work_mores',
 ]);
```

---

### 5. **Dev Diary Update**

File: `dev-diary/2026-08/2026-08-24_IT.md`

Aggiunta sezione che documenta il fix:

```markdown
## fix/0235-federation-mores-referenced-set-typo

Il nome della tabella è corretto, come tabella di lookup è composto da: nome tabella riferita, nome della colonna riferita, "sets".
Il nome del modello deve essere al singolare.

Riscontrato che la definizione della tabella è corretta, e vanno modificati 
il factory e il seeder e il model, Gemini stesso mi dice che faccio prima
e meglio a rinominare dentro e fuori il model. Ne approfitto per aggiungere
al model FederationMore la funzione belongsTo che non sarà mai usata,
ma intanto documenta il legame e com'è.

Adesso faccio sudare Copilot per creare la scheda tecnica.
```

---

## Riassunto delle Modifiche

| Elemento | Prima | Dopo | Tipo |
| ---------- | ------- | ------ | ------ |
| **Model Name** | `FederationMoresReferencedSets` | `FederationMoresReferencedSet` | Singolare (convention) |
| **Factory** | `FederationMoresReferencedSetsFactory` | `FederationMoresReferencedSetFactory` | Coerente |
| **Seeder** | `FederationMoresReferencedSetsSeeder` | `FederationMoresReferencedSetSeeder` | Coerente |
| **Commento `referenced`** | "real pk - lowercase" | "fk federation_mores_referenced_sets.id" | Chiarimento |
| **Relazione BelongsTo** | ❌ Non presente | ✅ Aggiunta | Documentazione |
| **Metodo `isInUse()`** | `FederationMoresReferencedSets::all()` | `FederationMoresReferencedSet::all()` | Coerenza |
| **Doc comentari** | Typo: `_referenceds` | Corretto: `_referenced_sets` | Precisione |

---

## Dettagli Tecnici

### Struttura della Lookup Table

```
federation_mores_referenced_sets
├── id (string, PK) — nome tabella di riferimento
├── created_at
├── updated_at
└── deleted_at (soft delete)
```

### Relazioni

```
FederationMore
  ├── belongsTo(FederationMoresReferencedSet)
  │   └── foreignKey: 'referenced'
  │       ownerKey: 'id'
  └── hasMany(UserMores) // TODO: rinominare in userContactMores()

FederationMoresReferencedSet
  └── hasMany(FederationMore)
      └── foreignKey: 'referenced'
          localKey: 'id'
```

---

## Logica del Metodo `isInUse()`

Il metodo itera su tutte le lookup table registrate in `federation_mores_referenced_sets` e verifica se il `FederationMore` è effettivamente referenziato da una o più righe nelle tabelle collegate.

**Flusso:**

1. Recupera tutte le tabelle di riferimento (`user_contact_mores`, `user_work_mores`, etc.)
2. Per ogni tabella di riferimento:
   - Controlla se esiste almeno una riga che referenzia il `FederationMore` corrente
   - Se trovato (primo true): **exit e ritorna true**
3. Se nessuna tabella lo referenzia: ritorna false

**Semantica:** OR logico con short-circuit al primo match.

---

## Note Conclusive

✅ **Tutti i cambiamenti sono coerenti** con Laravel conventions (modelli singolari)  
✅ **Documentazione migliorata** con commenti chiarificativi  
✅ **Relazione esplicita aggiunta** per tracciabilità del legame FK  
✅ **No breaking changes** – solo pulizia e chiarimenti  

### Consiglio Strategico

Questa fix è **propedeutica e complementare** alla feat/0231. Si consiglia di:

- **Opzione A:** Mergiare fix/0235 prima di feat/0231 per mantenere coerenza di naming fin dall'inizio
- **Opzione B:** Fare un rebase di feat/0231 su fix/0235 in caso di conflitti minori

---

## File Interessati da Questa Fix

```
app/Models/
├── FederationMore.php (modificato)
├── FederationMoresReferencedSet.php (rinominato da FederationMoresReferencedSets.php)
└── [deleted] FederationMoresReferencedSets.php

database/factories/
├── FederationMoresReferencedSetFactory.php (rinominato)
└── [deleted] FederationMoresReferencedSetsFactory.php

database/seeders/
├── FederationMoresReferencedSetSeeder.php (rinominato)
└── [deleted] FederationMoresReferencedSetsSeeder.php

dev-diary/2026-08/
└── 2026-08-24_IT.md (aggiornamento)
```

---
