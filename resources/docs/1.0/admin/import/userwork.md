# Import UserContact + UserWork + UserWorkMore | Admin
<!-- absolute links are /resources/docs/1.0/    -->
<!-- larecipe links are /{{route}}/{{version}}/ -->
<!-- images must be uploaded in /storage/app/public/docs/1.0/ then url prefixed by /docs/1.0/ -->

- [Import skeleton EN](https://yapcp.test/samples/user_work_skeleton_en.yaml)
- [Import skeleton IT](https://yapcp.test/samples/user_work_skeleton_it.yaml)

---

## A backup is *something you ‘should have done earlier’* – so do it  

So, after write a backup sometimes we need to import old data.  
Choose the function, choose the file, start the process.

## One more thing?

When in platform a new contest is designed, maybe done a facility import some data from previous contest

> <!-- avoid insert in larecipe index -->
<!-- when inserted in image folder can't download correctly despite of /docs/ address -->
- [YAML User Work Import sample file EN](https://yapcp.test/samples/user_work_skeleton_en.yaml)
- [YAML User Work Import sample file IT](https://yapcp.test/samples/user_work_skeleton_it.yaml)

1. Only member of admin group can use import facility,
  due the potential risk to lock the platform.
1. Even as admin group, the skeleton file is
  **fulled of instructions**, in form of yaml comments.
1. to edit a yaml file don't use LibreOffice or any wordprecessing program,
  **instead** use a text-only editor as, windows, Notepad or notepad++
  and similar. Wanna use `vi` on unix? use it.
  But remember, it's a easy format but spaces indentation is **a fundament element** in yaml grammar,
  *not, not, NOT replace* initial spaces with tabs, don't.
1. check that every item is rightly indented. At last is easy compile
  but it's also easy insert errors.
1. *"No null"* - facultative fields are facultative, if you wanna skip a value
  leave the row, instead of use "fieldname: null".

Init of row, `data:` and newline.  
two spaces, `users:` and newline.  
four spaces, `- email:`, a space and a valid email, then newline.

Now you have inserted the data: marker of start of data,
the marker for model User, and the first of items list of users model.
*Continue.* Now we insert the other data of first item  
six spaces, `name:`, a space then `"Surname, Name"`, then newline.  

then repeat for second item of User model:

Four spaces, `- email:`, a space, `"anothervalid@email.local"`, newline  
six spaces `name:`, a space, `"Surname, Name"`, newline.

```yaml
data:
  users:
    - email: "john.smith@example.com"
      name: "Smith, John"
    - email: "benny.hill@example.com"
      name: "Hill, Benny"
```

if you know previous assigned id, you can use

```yaml
data:
  users:
    - id: 12345678-1234-1234-1234-123456789012
      email: "john.smith@example.com"
      name: "Smith, John"
    - email: "benny.hill@example.com"
      id: 12345679-1234-1234-1234-123456789012
      name: "Hill, Benny"
  user_contacts:
    - email: "benny.hill@example.com"
      first_name: "Benny"
      last_name: "Hill"
      city: "London"
    - id: 12345678-1234-1234-1234-123456789012
      email: "john.smith@example.com"
      first_name: "John"
      last_name: "Smith"
      city: "San Francisco"
```

Note: user and user_contacts as two faces of the same medal
use the same uuid id, but if if you want upload data of
new users you can use `id: 'new'`.

And every, every UserWork item, every image have an unique User author, 
so when you add a new user and her/him works, what uuid
you can insert before know user uuid? So we admit
an alternative user_id reference: the email address.

```yaml
data:
  users:
    - id: new
      email: "groucho.marx@example.com"
      name: "Marx, Groucho"
  user_contacts:
    - email: "groucho.marx@example.com"
      first_name: "Groucho"
      last_name: "Marx"
      city: "Hollywood"
  user_works:
    - id: new
      user_id: "groucho.marx@example.com"
      title_en: "Duck Soup Film Still (1933)"
      url_path: "https://upload.wikimedia.org/wikipedia/commons/4/40/Groucho_Marx_in_Duck_Soup_film_still.jpg?utm_source=commons.wikimedia.org&utm_campaign=index&utm_content=original"
      is_monochromatic: true
```

Q.: Can i insert yaml comment ?  
A.: Yes, you can

Q.: To indicate that a work is monochromatic, can i
  insert ✅, [x], 'yes', or 'true'?
A.: Short response: no! insert only true, without "'",
and no synonyms. Omit data, or use value *true*.

Q.: When the name or surname have apostropes i.e.
 O'Neill, Jack, can i write 'O'Neill, Jack'?
A.: No, use instead "O'Neill, Jack"