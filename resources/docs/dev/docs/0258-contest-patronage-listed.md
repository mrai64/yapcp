# Scheda Tecnica: Componente Blade "ContestPatronage"

**Specifiche di Progettazione, Integrazione Livewire Volt SFC e Architettura Eloquent ORM**

---

## 1. Informazioni Generali e Routing

| Proprietà | Dettaglio / Implementazione |
| :--- | :--- |
| **Modulo / Feature** | Organization Design / Contest Patronages |
| **Tipologia Vista** | Livewire 4 Volt Single File Component (SFC) |
| **Route Assegnata** | `/organization/design/contest-patronage/listed/{contest}` |
| **Nome Route** | `organization.design.contest-patronage.listed` |
| **Middleware** | `['auth', 'verified']` |

---

## 2. Panoramica e Scopo

La scheda descrive l'implementazione del componente frontend/backend integrato per la visualizzazione, gestione e indicizzazione dei codici di patrocinio federale (*Contest Patronage*) associati a un concorso fotografico in fase di progettazione. Sostituisce il precedente campo testuale libero `federation_list` presente nella tabella principale dei concorsi, garantendo una relazione strutturata e normalizzata con le federazioni di riferimento (es. FIAP, PSA, GPU, UPI).

---

## 3. Architettura dei Dati ed Entità Coinvolte

Il sistema si basa su un'architettura relazionale definita tramite Eloquent ORM all'interno del framework Laravel:

| Modello Eloquent | Tabella DB | Ruolo nella Vista |
| :--- | :--- | :--- |
| **Contest** | `contests` | Rappresenta il concorso in progettazione. Fornisce l'istanza principale tramite route binding e la relazione con l'organizzazione di appartenenza. |
| **ContestPatronage** | `contest_patronages` | Tabella ponte/associazione che collega il concorso (`contest_id`) alla federazione (`federation_id`) memorizzando lo specifico `patronage_code` rilasciato. |
| **Federation** | `federations` | Contiene le anagrafiche delle federazioni internazionali/nazionali (nome in inglese, ID) ed è associata alla tabella **Country** per il recupero del codice della bandiera (`flag_code`). |
| **Organization** | `organizations` | Ente organizzatore del concorso, utilizzato per i reindirizzamenti alla dashboard di gestione. |

---

## 4. Struttura del Componente Livewire Volt (SFC)

Il componente unisce la logica di backend e la presentazione Blade in un unico file PHP, sfruttando il ciclo di vita di Livewire 4[cite: 1, 2]:

### 4.1. Logica di Mount e Recupero Dati (Backend)
Al caricamento della pagina, il metodo `mount(Contest $contest)` intercetta l'istanza del concorso, recupera l'organizzazione correlata ed estrae l'insieme dei patrocini ordinati per ID federazione e codice di patrocinio:

```php
public function mount(Contest $contest)
{
    $this->contest =$contest;
    $this->organization =$contest->organization;

    $this->contestPatronagesSet = ContestPatronage::where('contest_id',$this->contest->id)
        ->orderBy('federation_id')
        ->orderBy('patronage_code')
        ->get();
}


