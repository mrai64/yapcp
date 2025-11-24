# yaPCP Documentation

*in progress*

* [index](../index.md)

## Tech: database schema

* cache  
  reserved laravel

* cache_locks  
  reserved laravel
* [**contests**](#contests)  
  contest n circuit main info  
  contest name, organization, calendar, fee info etc
  related to countries and organizations
* *contests_vote_rule_sets*  
  auxiliary table to limited value for contests.vote_rule
* [**contest_awards**](#contest-awards)  
  related to contests, award list for contest n circuit and for contest sections
* [**contest_juries**](#contest-juries)  
  related to contests and contest_sections
* [**contest_sections**](#contest-sections)  
  related to contests and federation_sections
* **contest_votes**
  related to contests, contest_sections, works, contest_juries
* **contest_waitings**  
  TODO rename as contest_waiting_works  
  works that can't participate but should be readmitted
  related to contests, contest_sections, works, user_contacts (twice, for participant and for organization member)
* **contest_works**  
  related to contests, contest_sections, countries, user_contacts (participants)
  payload: country_id ?
* *countries*  
  auxiliary table for user_contacts, organizations,
  federations, contests  
  pk is based on [iso-3366-3 alpha code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3)
* failed_jobs  
  reserved laravel
* **federations**  
  who's define contest sections and rules to assign
  at contest its patronage /sponsorships
  related to countries and user_roles
* *federation_sections*  
  related to federations
* jobs  
  reserved laravel
* job_batches  
  reserved laravel
* migrations  
  reserved laravel
* **organizations**  
  who organize contests  
  related to countries, user_contacts, user_roles, contests
* password_reset_tokens  
  reserved laravel
* sessions  
  reserved laravel
* users  
  reserved laravel
  should be "integrated" with user_contacts
* **user_contacts**  
  related to countries, user_roles,
  contests, organizations, federations
* **user_roles**  
  related to users, user_contacts,
  organization, federations, contests
* *user_roles_role_sets*  
  auxiliary table to define limit values for
  col user_roles.role
* **works** (in future user_works)  
  related to user_contacts, contests_works
  
### Missing tables

Should be but not is

* timezones  
  auxiliary table for timezone cols

* lang_codes  
  auxiliary table for local lang code
  (maybe related or not with countries)

Tables description

Every pk must be named 'id'? not necessarily, but in case
pk-name must be replied also in fk fields to avoid
misunderstanding.

### contests

It'd the father for 5 child tables. It contains
some info about contest like id, name, organizer id and info,
country id, calendar dates, link to rule page, entry page link,
participant board page link, etc.
Contest should be also associated in a set named "Circuit",
so a record should be flagged as "is_circuit" and associated
contests should have che circuit contest_id as "circuit_id"
1:1 with countries table  
1:1 with organizations table (next the term table will be implied)

### contest sections

In that table are reported name of every  
section / theme composing the contest, with a list of params
for few automated rules like max number of works participant,
long side size in pixel and so on.  
Circuit should have sections. The same section of all contests.
1:N with contests

### contest juries

For every section a odd list of juror  
Circuit have no section jury  
1:N with contest_sections  
1:1: user_contacts, every juror need to access yapcp platform
and should be also involved in other roles with natural
exclusion (not juror and participant, btw)

### contest awards

Prize and honorable mentions are usual in photographic contests,
so also "best author" should be away from any section theme prize list.  
Circuit have a limited award list i.e. Best Author, based on
circuit rules.  

