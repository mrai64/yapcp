# yaPCP dev docs

The developer index about yaPCP - Photographic Contests platform.

- &nbsp;
<!-- no index -->

---

## About a Photographic Contest Platform

Core of platform are *Users*, *Organization*, and *Contests*.  
Users should be: *contest participants*, or also members of *Contest
organizer*, or nominated *Contest Juror*, 
or *member of Federation that sponsored a contest* to check contest works
in some way.
Contest have an organization that make the Contest
definition, choose section and themes, define jury
composition, define award list and run the contest
in its form.

### [Users](/{{route}}/dev/man/users)

Can access and modify these tables:

> <!-- avoid index -->
- users: name, last name, email, password
- user_contacts: name, last name, email address, mail address, passport photo, timezone
- user_roles: users involved in any organization OR federation OR contest as juror
- user_works: set of images loaded in a personal reserved space, available for
  contest participation
- contest_works: set of images loaded to any contest, when user "isAdmin()"
- contest_awards: readonly after user_id and contest_works are inserted during last jury reunion.

Can Do:

- register
- confirm email
- update user contacts

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
