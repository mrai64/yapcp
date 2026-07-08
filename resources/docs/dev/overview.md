# TECH overview
<!-- absolute links are /resources/docs/dev/    -->
<!-- larecipe links are /{{route}}/dev/ -->
<!-- images must be uploaded in /storage/app/public/docs/dev/ then url prefixed by /docs/dev/ -->

Last updated: 2026-07-07

Yapcp is a photographic contests management platform. That's
means: user participants, with user images, organization that design and manage
contests, jurors that assign votes, admit, and awards.  
As Organization can design contests "under ... Patronage", there is
also a Federation part.

**Platform Goal**: made all *easy to use*. Easy register, easy load images,
easy choose a contest without re-insert personal data everytime,
easy assign *my images* to a contest' theme n section (with pre-warning if
some trouble i.e. colour images in monochromatic section, images size too large).

Platform is also in a github repository.
Developers that wanna collaborate must read issue / *quaestio* 
[#67](https://github.com/mrai64/yapcp/issues/67) *(A) First Read That*

To manage the project that grow I try to follow few standards using
github project to manage **TDL | To Do List** here:  
[The Project 1](https://github.com/users/mrai64/projects/1/views/1)  

That's:
> <!-- to avoid index -->
1. Prioritize w/ABC system, using (A) (B) (C) (D) (E) after the conventional commits
  [see wiki definition](/{{route}}/dev/wiki/abcde-method.md)
  in few words (A) is the more urgent Must Do, (B) Should Do, (C) Nice to Do,
  (D) Delegate, (E) Eliminate from the list
1. Follow Conventional commits, using feat: fix: chore: refactor:
  [name Conventional commits](https://www.conventionalcommits.org/en/v1.0.0/)
1. FIFO | First In First Out  
  Third, after the conventional commits and ABCDE codes i usually add an ID
  composed by iso-date yyyy-mm-dd followed by a counter-in-day 2 digit zero leaded start by 01.

In that way can sort the *project issue table* in 3 way: priority, grouping, older / newest,  
*Before closing* an issue, the prioritize code should be removed. Not should, must be.  
Issue titles that don't follow these few rules must be modified to conform.

When a issue become under dev a branch is created.
name branch in that common way: 

* first a conventional commits feat/ fix/ chore/ refactor/
* second the ssue number in 4 digit zero leaded, i.e. 0100
* third few word from issue title  
  i.e. `feat/0100-agreements.md`  

Technical cards can be put in `/resources/docs/dev` using the branch name
to complete the md file,  
i.e. [`/resources/docs/dev/feat/0100-agreements.md`](/{{route}}/dev/feat/0100-agreements)
Use the [template](/{{route}}/dev/template) when open a new doc file.

---

## What about

A photographic contests platform, that, had 4 subjects:

1. Participants user  
    1. register in platform
    1. see contest open to participation
    1. participate in contest
    1. appreciate result and sometimes win
    1. loop from 1.
1. Organizations  
   which are who design ad manage contest
   1. design contest
      1. main info
      1. sections n themes
      1. jury composition
      1. awards list
    1. award ceremony
    1. send prizes
    1. loop from 1
1. Federations  
   offers help and rules to organization
   for a *better contest* experience,
   and consider the contest a way to
   find "master of photography", awarding
   them with distinctions.
1. "admins Lodge"  
    a user group, or an organization
    that manage platform.
    1. check platform functionality
    1. resolve problems
    1. develop platform evolution
