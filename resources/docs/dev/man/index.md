# yaPCP dev docs

The developer index about yaPCP - Photographic Contests platform.

- &nbsp;

---

## About a Photographic Contest Platform

Core of platform are Users and Contests. Users should be
only contest participants, or also members of Contest
organizer, or Contest Juror, or member of Federation that
define role of conduct for Contest sponsored.
Contest have an organization that make the Contest
definition, choose section and themes, define jury
composition, define award list and run the contest
in its form.

### [Users](/{{route}}/dev/man/users)

Tables:

- users: name, last name, email, password
- user_contacts: name, lastname, email, postal address, passport photo, timezone
- user_roles: users involved in any organization OR federation OR contest as juror
- user_works: set of images loaded in a personal space, available for
  contest participation
- contest_works: set of images loaded to any contest, with first result on/off of isAdmin()
- contest_awards: when iser_id and contest_owrks are inserted by last jury minute.

Can Do:

- register
- confirm 

### [Admins](/{{route}}/man/admins)

Tables:

- countries
- timezones
- user_roles  (managed by)
- federations (managed by)
- federation_sections
- federation_mores

Admins is a predefined organization that consent to the group members
to execute some jobs like create federation, make backup, or insert / correct some info over organization.

### [Federations](/{{route}}/man/federations)

Are created by admins and are reference for creating contest compliant to
rule written by federation.

- federation
- federation_-_sections
- federation_mores that's a table of infos about user or user_works
  required exclusively from a federation and not common to all.
  i.e. an image title can be requested by every contest,
  but infos like "year of first admission" can be required
  only by FIAP

### [Organizations](/{{route}}/man/organizations)

Are group of members which have the purpose to design and manage
one or more contest.

### [Build a Contest](/{{route}}/man/build-a-contest)

Done by an organization defining:

* main contest data (name, calendar, award ceremony and fee infos)
* composition of contest (list of section-themes)
* composition of section jury
* awards list for every section and contest

### [Run a Contest](/{{route}}/man/run-a-contest)



### [Jury works](/{{route}}/man/jury-works)
