# The Federation More fields list
<!-- absolute links are /resources/docs/1.0/    -->
<!-- larecipe links are /{{route}}/{{version}}/ -->
<!-- images must be uploaded in /storage/app/public/docs/1.0/ then url prefixed by /docs/1.0/ -->

- [Generality](#generality)
- [List for admin](#list-for-admin)

---

## Generality

There is a set of personal information data that are common to every,
every Photographic Salon / Contest. And every Federation that sponsor
giving a Patronage to a Contest, ask organization for adding "one more field(s)"
to contest registration form.
I.e. italian fed FIAF ask for *FIAF card number*, and also for italian partecipants
an italian tax id named *codice fiscale*; FIAP ask for *FP | FIAP Personal Id*.

&nbsp;

So for that reason we introduced a very technical table to manage these
type of datas. FederationMore is: a table of form fields. So in that model we need
to write: *field id*, *label*, *suggestion* phrase, a *default value* and a string that in
Laravel is named as a *rule validation* string.

At this moment we apply the "more fields" exclusively to 2 tables: `user_contacts`
and to `user_works`. As indicated, `user_`
But new fields can be added for other tables.
Every record, every bit inserted in that table must be approved by dev community
and checked for the destination table CRUD.

&nbsp;

The federation list w/ link to federation more fields list page
![_](/docs/federation_mores/read_img01.png)

&nbsp;

A federation with no *one more field*
![_](/docs/federation_mores/read_img02.png)

&nbsp;

A federation with some *mode fields*
![_](/docs/federation_mores/read_img03.png)

&nbsp;

![_](/docs/federation_mores/read_img04.png)

---

## List for Admin

When a user ask to change / restore a own `user_contact_mores`
and/or `user_work_mores` record, that can be done using a yaml file
importer. To compile the text file in rightest way,
admin user can be able to learn how these "federation more fields"
are coded.  
In case you need to remember or check a value...

Reach your personal dashboard, then / or your
Admin dashboard and click on 'Fed More' Index link.

&nbsp;

![__](/docs/admin/federationmore/listed_img01.png)

&nbsp;

![__](/docs/admin/federationmore/listed_img02.png)

&nbsp;

The index cover all the *federation more* fields definition 
registered on the platform, ordered by federation id,
referenced table, field label. Then are reported also field_name,
the default value used *INSTEAD of*, a suggest - synopsis,
and a technical but readable set of rules used to validate
the field value.

&nbsp;
