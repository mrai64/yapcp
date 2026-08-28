# The Federation More fields list
<!-- absolute links are /resources/docs/1.0/    -->
<!-- larecipe links are /{{route}}/{{version}}/ -->
<!-- images must be uploaded in /storage/app/public/docs/1.0/ then url prefixed by /docs/1.0/ -->

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
type of datas. FederationMore is: a table of form fields. So we need
to indicate id, label, suggestion phrase, a default value and a string that in
Laravel is named as a *rule validation* string.

At this moment we apply the "more fields" to 2tables: user_contacts
and to user_works. But new fields can be added for other tables.
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
