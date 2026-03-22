# 🇮🇹 🗄️ Documentazione Schema Database

> **Valido fino alla data del:** 22/03/2026 - 21:28:22

Questa cartella contiene la struttura tecnica del database per il supporto allo sviluppo.

Per rigenerare questo documento eseguire in Terminale il seguente comando:
php artisan db:con
---

## Indice alfabetico

- [cache](#-tabella-cache)
- [cache_locks](#-tabella-cache_locks)
- [contest_awards](#-tabella-contest_awards)
- [contest_juries](#-tabella-contest_juries)
- [contest_participants](#-tabella-contest_participants)
- [contest_patronages](#-tabella-contest_patronages)
- [contest_sections](#-tabella-contest_sections)
- [contest_votes](#-tabella-contest_votes)
- [contest_waitings](#-tabella-contest_waitings)
- [contest_works](#-tabella-contest_works)
- [contests](#-tabella-contests)
- [contests_vote_rule_sets](#-tabella-contests_vote_rule_sets)
- [countries](#-tabella-countries)
- [failed_jobs](#-tabella-failed_jobs)
- [federation_mores](#-tabella-federation_mores)
- [federation_mores_referenced_tables](#-tabella-federation_mores_referenced_tables)
- [federation_sections](#-tabella-federation_sections)
- [federations](#-tabella-federations)
- [job_batches](#-tabella-job_batches)
- [jobs](#-tabella-jobs)
- [lang_lists](#-tabella-lang_lists)
- [migrations](#-tabella-migrations)
- [organizations](#-tabella-organizations)
- [password_reset_tokens](#-tabella-password_reset_tokens)
- [sessions](#-tabella-sessions)
- [timezone_region_sets](#-tabella-timezone_region_sets)
- [timezones](#-tabella-timezones)
- [user_contact_mores](#-tabella-user_contact_mores)
- [user_contacts](#-tabella-user_contacts)
- [user_roles](#-tabella-user_roles)
- [user_roles_context_sets](#-tabella-user_roles_context_sets)
- [user_roles_role_contexts](#-tabella-user_roles_role_contexts)
- [user_roles_role_sets](#-tabella-user_roles_role_sets)
- [user_work_mores](#-tabella-user_work_mores)
- [user_work_validations](#-tabella-user_work_validations)
- [user_works](#-tabella-user_works)
- [users](#-tabella-users)

---

## 📋 Tabella: `cache`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **key** | varchar(255) | *-* | NO | PRI | *NULL* |
| **value** | mediumtext | *-* | NO |  | *NULL* |
| **expiration** | int | *-* | NO |  | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `cache_locks`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **key** | varchar(255) | *-* | NO | PRI | *NULL* |
| **owner** | varchar(255) | *-* | NO |  | *NULL* |
| **expiration** | int | *-* | NO |  | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `contest_awards`

**Descrizione:** Contest:award list for every section and for contest/circuit

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *real pk si contest_id + award_code* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *fk: contests.id contest_sections.contest_id* | NO | MUL | *NULL* |
| **section_id** | char(36) | *fk: contest_sections.id* | YES | MUL | *NULL* |
| **section_code** | varchar(10) | *from: section.id->code | null for contest/circuit* | YES | MUL | *NULL* |
| **award_code** | varchar(10) | *mut be unique in contest* | NO | MUL | *NULL* |
| **award_name** | varchar(255) | *free* | NO |  | *NULL* |
| **is_award** | tinyint(1) | *true - award/award prize, false - HM or other* | NO |  | 0 |
| **winner_work_id** | char(36) | *-* | YES | MUL | *NULL* |
| **winner_user_id** | char(36) | *-* | YES | MUL | *NULL* |
| **winner_name** | varchar(255) | *winner not in previous cols* | NO |  |  |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `contest_id` → `contests(id)`
- 🔗 `section_id` → `contest_sections(id)`

---

## 📋 Tabella: `contest_juries`

**Descrizione:** juror contest section list

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *reak pk section_id + juror user_id* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *fk: contests.id* | NO | MUL | *NULL* |
| **section_id** | char(36) | *fk: contest_sections.id* | NO | MUL | *NULL* |
| **user_id** | char(36) | *fk: user_contacts.id - juror* | NO | MUL | *NULL* |
| **is_president** | tinyint(1) | *used to put first in juror list* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `section_id` → `contest_sections(id)`
- 🔗 `contest_id` → `contests(id)`
- 🔗 `user_id` → `user_contacts(id)`

---

## 📋 Tabella: `contest_participants`

**Descrizione:** Participant list w/fee semaphore

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *-* | NO | MUL | *NULL* |
| **user_contact_id** | char(36) | *-* | NO | MUL | *NULL* |
| **fee_payment_completed** | tinyint(1) | *reserved for contest organization members* | NO | MUL | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `contest_id` → `contests(id)`
- 🔗 `user_contact_id` → `user_contacts(id)`

---

## 📋 Tabella: `contest_patronages`

**Descrizione:** additional values for user_contacts based on federation_mores

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *fk for contests id* | NO | MUL | *NULL* |
| **federation_id** | varchar(10) | *fk federations id* | NO | MUL | *NULL* |
| **patronage_code** | varchar(20) | *-* | NO |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `contest_sections`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *real pk contest_id n code* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *fk: contests.id* | NO | MUL | *NULL* |
| **code** | varchar(10) | *fk: federationSections.code but also not* | NO | MUL | *NULL* |
| **under_patronage** | tinyint(1) | *section-theme valid for federation* | NO |  | 0 |
| **federation_section_id** | bigint unsigned | *fk: federation_sections.id* | YES | MUL | *NULL* |
| **name_en** | varchar(255) | *international* | NO |  | *NULL* |
| **name_local** | varchar(255) | *in local lang - see contests.lang_local* | YES |  | *NULL* |
| **rule_format** | varchar(255) | *list of permitted extension* | NO |  | jpg |
| **rule_min** | int unsigned | *minimum works-per-section* | NO |  | 0 |
| **rule_max** | int unsigned | *maximum works-per-section* | NO |  | 4 |
| **rule_min_size** | int unsigned | *minimum short_side px* | NO |  | 1024 |
| **rule_max_size** | int unsigned | *maximum long_side px* | NO |  | 2500 |
| **rule_max_weight** | int unsigned | *file weight in KB* | NO |  | 6000 |
| **rule_monochromatic** | tinyint(1) | *BW / M only* | NO |  | 0 |
| **rule_raw_required** | tinyint(1) | *RAW required* | NO |  | 0 |
| **rule_only_one** | tinyint(1) | *unique award per person per section-theme* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `contest_id` → `contests(id)`
- 🔗 `federation_section_id` → `federation_sections(id)`

---

## 📋 Tabella: `contest_votes`

**Descrizione:** The Jury vote board

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *real pk: section_id + contest_work_id + juror_id* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *fk: contests.id contest_sections.contest_id* | NO | MUL | *NULL* |
| **section_id** | char(36) | *fk: contest_sections.id* | NO | MUL | *NULL* |
| **contest_work_id** | char(36) | *fk: contest_works.work_id - NOT user_works.id* | NO | MUL | *NULL* |
| **juror_user_id** | char(36) | *fk: user_contacts.id juror* | NO | MUL | *NULL* |
| **vote** | varchar(255) | *based on contests.vote_rule* | NO | MUL | *NULL* |
| **review_required** | tinyint(1) | *false - not required* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *date of vote* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `contest_id` → `contests(id)`
- 🔗 `contest_work_id` → `contest_works(id)`
- 🔗 `juror_user_id` → `user_contacts(id)`
- 🔗 `section_id` → `contest_sections(id)`

---

## 📋 Tabella: `contest_waitings`

**Descrizione:** Parking table for user_works with any problem

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *real pk: contest_work_id* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *fk: contests.id* | NO | MUL | *NULL* |
| **section_id** | char(36) | *fk: contest_sections.id* | NO | MUL | *NULL* |
| **user_work_id** | char(36) | *fk: user_works.id* | NO | MUL | *NULL* |
| **portfolio_sequence** | tinyint unsigned | *to ripristinate original record* | NO |  | 0 |
| **participant_user_id** | char(36) | *fk: user_contacts.id author* | NO | MUL | *NULL* |
| **email** | varchar(255) | *for notification* | NO |  | *NULL* |
| **organization_user_id** | char(36) | *fk: user_works.id organization member* | NO | MUL | *NULL* |
| **because** | text | *why that work is out* | NO |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `contest_id` → `contests(id)`
- 🔗 `organization_user_id` → `user_contacts(id)`
- 🔗 `participant_user_id` → `user_contacts(id)`
- 🔗 `section_id` → `contest_sections(id)`
- 🔗 `user_work_id` → `user_works(id)`

---

## 📋 Tabella: `contest_works`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *-* | NO | PRI | *NULL* |
| **contest_id** | char(36) | *fk: contests.id* | NO | MUL | *NULL* |
| **section_id** | char(36) | *fk: contest_sections.id* | NO | MUL | *NULL* |
| **country_id** | char(3) | *fk: countries.id* | NO | MUL | *NULL* |
| **user_id** | char(36) | *fk:user_contacts.id author* | NO | MUL | *NULL* |
| **user_work_id** | char(36) | *fk: user_works.id* | NO | MUL | *NULL* |
| **extension** | varchar(6) | *used to build file name* | NO |  | jpg |
| **portfolio_sequence** | tinyint unsigned | *sequence also for portfolio* | NO |  | 0 |
| **is_admit** | tinyint(1) | *0 = not admit, admit otherwise* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `contest_id` → `contests(id)`
- 🔗 `country_id` → `countries(id)`
- 🔗 `section_id` → `contest_sections(id)`
- 🔗 `user_id` → `user_contacts(id)`

---

## 📋 Tabella: `contests`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *-* | NO | PRI | *NULL* |
| **country_id** | char(3) | *fk: countries.id* | NO | MUL | *NULL* |
| **name_en** | varchar(255) | *-* | NO | MUL | *NULL* |
| **name_local** | varchar(255) | *-* | YES | MUL | *NULL* |
| **lang_local** | varchar(5) | *dev: in LangList[]* | NO |  | en |
| **organization_id** | char(36) | *fk: organizations.id* | NO | MUL | *NULL* |
| **is_circuit** | char(1) | *Y/N, N when not Y* | NO |  | N |
| **circuit_id** | char(36) | *null or self fk: contests.id* | YES | MUL | *NULL* |
| **federation_list** | varchar(255) | *under patronage of federation code[]* | YES |  | *NULL* |
| **contest_mark** | varchar(255) | *The contest or organization passport photo - mark* | YES |  | *NULL* |
| **contact_info** | text | *contest headquarter, email and so on* | NO |  | *NULL* |
| **award_ceremony_info** | text | *Site and date, or link to broadcast platform* | YES |  | *NULL* |
| **fee_info** | text | *only text description of fee for participation* | YES |  | *NULL* |
| **vote_rule** | varchar(255) | *fk: contests_vote_rule_sets.vote_rule* | NO | MUL | num:1..10 |
| **url_1_rule** | varchar(255) | *how read english rules and subscribe link* | YES |  | *NULL* |
| **url_2_concurrent_list** | varchar(255) | *-* | YES |  | *NULL* |
| **url_3_admit_n_award_list** | varchar(255) | *only the result list, not a catalogue* | YES |  | *NULL* |
| **url_4_catalogue** | varchar(255) | *catalogue download page* | YES |  | *NULL* |
| **timezone_id** | varchar(255) | *fk: timezones.id* | NO | MUL | *NULL* |
| **day_1_opening** | datetime | *T1 Reveal the contest, opening for subscription* | NO |  | *NULL* |
| **day_2_closing** | datetime | *T2 >= T1 End of receive works* | NO |  | *NULL* |
| **day_3_jury_opening** | datetime | *T3 > T2 Start of juror works* | NO |  | *NULL* |
| **day_4_jury_closing** | datetime | *T4 >= T3 End of juror works* | NO |  | *NULL* |
| **day_5_revelations** | datetime | *T5 > T4 Publicly result communications* | NO |  | *NULL* |
| **day_6_awards** | datetime | *T6 > T5 Award Ceremony* | NO | MUL | *NULL* |
| **day_7_catalogues** | datetime | *T7 > T6 Publicly Catalogue publications* | NO |  | *NULL* |
| **day_8_closing** | datetime | *T8 > T7 Closing date for award postal send* | NO |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `country_id` → `countries(id)`
- 🔗 `organization_id` → `organizations(id)`
- 🔗 `circuit_id` → `contests(id)`
- 🔗 `vote_rule` → `contests_vote_rule_sets(vote_rule)`
- 🔗 `timezone_id` → `timezones(id)`

---

## 📋 Tabella: `contests_vote_rule_sets`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **vote_rule** | varchar(255) | *-* | NO | UNI | *NULL* |
| **synopsis** | text | *-* | YES |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `countries`

**Descrizione:** Based on iso-3166, and mledoze/countries

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(3) | *iso-3166 alpha-3 uppercase* | NO | PRI | *NULL* |
| **country** | varchar(255) | *english official* | NO | MUL | *NULL* |
| **flag_code** | char(20) | *Unicode chars for country flag emoji* | YES |  | *NULL* |
| **lang_code** | char(7) | *lang=xx_YY* | YES | MUL | *NULL* |
| **locale** | char(6) | *lang=xx* | YES | MUL | *NULL* |
| **calling_code** | char(10) | *[+nn] - [+nnn] - [+1 nnn]* | YES | MUL | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `failed_jobs`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **uuid** | varchar(255) | *-* | NO | UNI | *NULL* |
| **connection** | text | *-* | NO |  | *NULL* |
| **queue** | text | *-* | NO |  | *NULL* |
| **payload** | longtext | *-* | NO |  | *NULL* |
| **exception** | longtext | *-* | NO |  | *NULL* |
| **failed_at** | timestamp | *-* | NO |  | CURRENT_TIMESTAMP |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `federation_mores`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *the real pk is federation_id + field_name* | NO | PRI | *NULL* |
| **referenced_table** | char(40) | *real pk - lowercase* | NO | UNI | *NULL* |
| **federation_id** | varchar(10) | *fk federations.id* | NO | MUL | *NULL* |
| **field_name** | varchar(20) | *lowercase* | NO |  | *NULL* |
| **field_label** | varchar(255) | *label for the field* | NO |  | *NULL* |
| **field_validation_rules** | varchar(255) | *string or function(), validation rules for the field, nullable if none* | NO |  | string|max:255 |
| **field_default_value** | varchar(255) | *empty string as default default value* | NO |  |  |
| **field_suggest** | varchar(255) | *message to explain what insert* | NO |  |  |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `federation_id` → `federations(id)`
- 🔗 `referenced_table` → `federation_mores_referenced_tables(referenced_table)`

---

## 📋 Tabella: `federation_mores_referenced_tables`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **referenced_table** | char(40) | *real pk - lowercase* | NO | UNI | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `federation_sections`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *real pk is federation_id + code* | NO | PRI | *NULL* |
| **federation_id** | char(10) | *-* | NO | MUL | *NULL* |
| **code** | char(10) | *-* | NO | MUL | *NULL* |
| **name_en** | varchar(255) | *official name in english* | NO | MUL | *NULL* |
| **local_lang** | char(2) | *follow iso-3166 2 ascii lowercase* | NO |  | en |
| **name_local** | varchar(255) | *in local name* | NO |  |  |
| **rule_definition** | text | *synopsis from federal regulation docs* | YES |  | *NULL* |
| **file_formats** | varchar(255) | *list of ext, comma separated* | NO |  | jpg,tif,raw,raf,nef,cr2 |
| **min_works** | int unsigned | *greater zero == portfolio* | NO |  | 0 |
| **max_works** | int unsigned | *-* | NO |  | 4 |
| **min_short_side** | int unsigned | *px* | NO |  | 1080 |
| **max_long_side** | int unsigned | *px* | NO |  | 2500 |
| **max_weight** | int | *Bytes* | NO |  | 6000000 |
| **monochromatic_required** | tinyint(1) | *0 == false, 1 == true* | NO |  | 0 |
| **raw_required** | tinyint(1) | *section require raw original works (not only)* | NO |  | 0 |
| **only_one** | tinyint(1) | *required only one prize / author n section* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `federation_id` → `federations(id)`

---

## 📋 Tabella: `federations`

**Descrizione:** Who build the contest rules for patronages

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(10) | *UPPER, when code are equals add :country_id to both* | NO | PRI | *NULL* |
| **country_id** | char(3) | *fk countries.id* | NO | MUL | *NULL* |
| **name_en** | varchar(255) | *official name in english* | NO | MUL | *NULL* |
| **website** | varchar(255) | *official website or fb info page* | NO |  |  |
| **local_lang** | char(6) | *follow iso-3166 2 ascii lowercase* | NO |  | en |
| **name_local** | varchar(255) | *when differ from official english* | NO |  |  |
| **timezone_id** | varchar(255) | *HQ address* | NO | MUL |  |
| **contact_info** | text | *HQ address, email, and other infos* | NO |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `country_id` → `countries(id)`
- 🔗 `timezone_id` → `timezones(id)`

---

## 📋 Tabella: `job_batches`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | varchar(255) | *-* | NO | PRI | *NULL* |
| **name** | varchar(255) | *-* | NO |  | *NULL* |
| **total_jobs** | int | *-* | NO |  | *NULL* |
| **pending_jobs** | int | *-* | NO |  | *NULL* |
| **failed_jobs** | int | *-* | NO |  | *NULL* |
| **failed_job_ids** | longtext | *-* | NO |  | *NULL* |
| **options** | mediumtext | *-* | YES |  | *NULL* |
| **cancelled_at** | int | *-* | YES |  | *NULL* |
| **created_at** | int | *-* | NO |  | *NULL* |
| **finished_at** | int | *-* | YES |  | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `jobs`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **queue** | varchar(255) | *-* | NO | MUL | *NULL* |
| **payload** | longtext | *-* | NO |  | *NULL* |
| **attempts** | tinyint unsigned | *-* | NO |  | *NULL* |
| **reserved_at** | int unsigned | *-* | YES |  | *NULL* |
| **available_at** | int unsigned | *-* | NO |  | *NULL* |
| **created_at** | int unsigned | *-* | NO |  | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `lang_lists`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **created_at** | timestamp | *-* | YES |  | *NULL* |
| **updated_at** | timestamp | *-* | YES |  | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `migrations`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | int unsigned | *-* | NO | PRI | *NULL* |
| **migration** | varchar(255) | *-* | NO |  | *NULL* |
| **batch** | int | *-* | NO |  | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `organizations`

**Descrizione:** who organize contests

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *-* | NO | PRI | *NULL* |
| **country_id** | char(3) | *fk: countries.id - hq country* | NO | MUL | *NULL* |
| **name** | varchar(255) | *english official* | NO | MUL | *NULL* |
| **email** | varchar(255) | *-* | NO | UNI | *NULL* |
| **website** | varchar(255) | *official organization website* | YES |  | *NULL* |
| **contact** | text | *hq postal address* | YES |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `country_id` → `countries(id)`

---

## 📋 Tabella: `password_reset_tokens`

**Descrizione:** user reserved

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **email** | varchar(255) | *-* | NO | PRI | *NULL* |
| **token** | varchar(255) | *-* | NO |  | *NULL* |
| **created_at** | datetime | *-* | YES |  | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `sessions`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | varchar(255) | *-* | NO | PRI | *NULL* |
| **user_id** | char(36) | *-* | YES | MUL | *NULL* |
| **ip_address** | varchar(45) | *-* | YES |  | *NULL* |
| **user_agent** | text | *-* | YES |  | *NULL* |
| **payload** | longtext | *-* | NO |  | *NULL* |
| **last_activity** | int | *-* | NO | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `timezone_region_sets`

**Descrizione:** timezones lookup table

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(12) | *-* | NO | PRI | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `timezones`

**Descrizione:** correspond to php_timezone version 2025.3

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | varchar(40) | *valid for php_timezones* | NO | PRI | *NULL* |
| **region_id** | char(12) | *fk timezone_region_sets.id* | NO | MUL | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `region_id` → `timezone_region_sets(id)`

---

## 📋 Tabella: `user_contact_mores`

**Descrizione:** additional values for user_contacts based on federation_mores

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *real pk is user_contact_id n federation_id n field_name* | NO | PRI | *NULL* |
| **user_id** | char(36) | *fk for user_contact id* | NO | MUL | *NULL* |
| **federation_id** | varchar(10) | *fk federation_mores* | NO | MUL | *NULL* |
| **field_name** | varchar(20) | *fk federation_mores* | NO |  | *NULL* |
| **field_value** | varchar(255) | *following rules when updated* | NO |  |  |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `federation_id` → `federation_mores(federation_id)`
- 🔗 `field_name` → `federation_mores(field_name)`
- 🔗 `user_id` → `user_contacts(id)`

---

## 📋 Tabella: `user_contacts`

**Descrizione:** the real users info table

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *pk fk: users.id* | NO | PRI | *NULL* |
| **country_id** | char(3) | *fk: countries.id* | NO | MUL | ITA |
| **first_name** | varchar(255) | *-* | NO | MUL | *NULL* |
| **last_name** | varchar(255) | *-* | NO | MUL | *NULL* |
| **nick_name** | varchar(255) | *alias, aka* | YES | MUL | *NULL* |
| **email** | varchar(255) | *fk: users.email* | NO | UNI | *NULL* |
| **cellular** | varchar(20) | *country code prefixed* | NO |  |  |
| **passport_photo** | varchar(255) | *as rounded avatars* | NO |  | anon.jpg |
| **lang_code** | char(7) | *xx_YY - for future use in html lang* | NO |  | it_IT |
| **timezone_id** | varchar(40) | *fk: timezones.id* | NO | MUL | Europe/Rome |
| **address** | varchar(255) | *in latin char* | NO |  |  |
| **address_line2** | varchar(255) | *-* | NO |  |  |
| **city** | varchar(255) | *-* | NO |  |  |
| **region** | varchar(255) | *not timezone region* | NO |  |  |
| **postal_code** | varchar(10) | *-* | NO |  |  |
| **website** | varchar(255) | *url of personal site* | YES |  | *NULL* |
| **facebook** | varchar(255) | *url of personal page* | YES |  | *NULL* |
| **x_twitter** | varchar(255) | *url of personal page* | YES |  | *NULL* |
| **instagram** | varchar(255) | *url of personal page* | YES |  | *NULL* |
| **whatsapp** | varchar(255) | *url to chat into* | YES |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `country_id` → `countries(id)`
- 🔗 `timezone_id` → `timezones(id)`
- 🔗 `id` → `users(id)`
- 🔗 `email` → `users(email)`

---

## 📋 Tabella: `user_roles`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **user_id** | char(36) | *fk: user_contacts.id* | NO | MUL | *NULL* |
| **role** | varchar(25) | *fk: user_roles_role_sets.role* | NO | MUL | member |
| **organization_id** | char(36) | *fk: organizations.id* | YES | MUL | *NULL* |
| **contest_id** | char(36) | *fk: contests.id* | YES | MUL | *NULL* |
| **federation_id** | char(10) | *fk: federations.id* | YES | MUL | *NULL* |
| **role_opening** | datetime | *Start of role works - default: today* | NO | MUL | CURRENT_TIMESTAMP |
| **role_closing** | datetime | *End of role works default:future* | NO |  | 9999-12-31 23:59:59 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `contest_id` → `contests(id)`
- 🔗 `federation_id` → `federations(id)`
- 🔗 `organization_id` → `organizations(id)`
- 🔗 `role` → `user_roles_role_sets(role)`

---

## 📋 Tabella: `user_roles_context_sets`

**Descrizione:** lookup table for: user_roles.context_type

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **context_type** | char(16) | *the real pk* | NO | UNI | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `user_roles_role_contexts`

**Descrizione:** pivot table

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **role** | varchar(25) | *fk user_roles_role_sets.id* | NO | MUL | *NULL* |
| **context** | char(16) | *fk user_roles_context_set.id* | NO | MUL | *NULL* |
| **green** | tinyint(1) | *true green flag, false red flag* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `context` → `user_roles_context_sets(context_type)`
- 🔗 `role` → `user_roles_role_sets(role)`

---

## 📋 Tabella: `user_roles_role_sets`

**Descrizione:** lookup table for: user_roles.role

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **role** | varchar(25) | *the real pk* | NO | UNI | *NULL* |
| **role_weight** | tinyint unsigned | *higher to admin* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `user_work_mores`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *-* | NO | PRI | *NULL* |
| **user_work_id** | char(36) | *fk: user_works.id* | NO | MUL | *NULL* |
| **federation_id** | varchar(10) | *fk: federation_mores.federation_id* | NO | MUL | *NULL* |
| **field_name** | varchar(20) | *fk: federation_mores.field_name* | NO |  | *NULL* |
| **field_value** | varchar(255) | *following rules when updated* | NO | MUL |  |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---

## 📋 Tabella: `user_work_validations`

**Descrizione:** human checked user_works, based on federation_sections rules

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | bigint unsigned | *real pk is: user_work_id + federation_section_id* | NO | PRI | *NULL* |
| **user_work_id** | char(36) | *fk: user_works.id* | NO | MUL | *NULL* |
| **federation_section_id** | bigint unsigned | *fk: federation_sections.id* | NO | MUL | *NULL* |
| **validator_user_id** | char(36) | *contest organization members that validate the work for specific section* | NO | MUL | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `federation_section_id` → `federation_sections(id)`
- 🔗 `user_work_id` → `user_works(id)`
- 🔗 `validator_user_id` → `user_contacts(id)`

---

## 📋 Tabella: `user_works`

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *-* | NO | PRI | *NULL* |
| **user_id** | char(36) | *-* | NO | MUL | *NULL* |
| **work_file** | varchar(255) | *path n filename internal* | NO | UNI |  |
| **extension** | char(6) | *-* | NO | MUL |  |
| **title_en** | varchar(255) | *english title* | NO |  | *NULL* |
| **title_local** | varchar(255) | *lang title* | NO |  | *NULL* |
| **long_side** | int unsigned | *pixel* | NO |  | *NULL* |
| **short_side** | int unsigned | *pixel* | NO |  | *NULL* |
| **monochromatic** | tinyint(1) | *declared BW monochromatic* | NO |  | 0 |
| **raw** | tinyint(1) | *Original RAW available* | NO |  | 0 |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- 🔗 `user_id` → `user_contacts(id)`

---

## 📋 Tabella: `users`

**Descrizione:** aka passwords table - for platform access only - other user info un user_contacts

| Campo | Tipo | Descrizione | Null | Chiave | Default |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **id** | char(36) | *lowercase uuid* | NO | PRI | *NULL* |
| **name** | varchar(255) | *surname, name - not used for access* | NO | MUL | *NULL* |
| **email** | varchar(255) | *-* | NO | UNI | *NULL* |
| **email_verified_at** | datetime | *-* | YES |  | *NULL* |
| **password** | varchar(255) | *hashed obv* | NO |  | *NULL* |
| **remember_token** | varchar(100) | *-* | YES |  | *NULL* |
| **created_at** | datetime | *-* | NO |  | CURRENT_TIMESTAMP |
| **updated_at** | datetime | *-* | NO | MUL | CURRENT_TIMESTAMP |
| **deleted_at** | datetime | *-* | YES | MUL | *NULL* |

### **Relazioni (Foreign Keys):**

- ❌ Nessuna relazione trovata.

---
