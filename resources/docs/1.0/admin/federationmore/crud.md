# Admin | Federation More fields | List Add Modify Remove

- [What are](#common-fields-vs-federation-more-fields)
- [List](#list)
- [Add](#add)
- [Modify](#modify)
- [Remove](#remove)

---

## Common fields vs Federation more fields

All the contest platform i approach in there years are
dedicated to a specific contest photo typology.
Maybe generic contest, with or without federation
sponsorship, and every contest had a list of field fixed.
Then my approach is slighty different, i think to a
set of _common fields_ which are common to all
the contest, and a set of _federation required fields_
i.e. the federation card id that may be different for
PSA than FIAP than IAAP and so on.

So, as programme i can't add a column for every,
every federation che user_contacts table. Better way
(in my mind) use a child table when federation required
fields are stored. So, i.e. FIAF (italian federation)
ask for 2 fields in user_contacts and one in user_works.
FiAP had a card Id named personal number, which is
different from card id by PSA.

The field definition is the role of federation_mores table.

## List

Federation more fields are listed if present.

## Add

Choice the federation from federation list,
then change link and in the federation modify page the link
to list the federation fields already in.

![add 1](/docs/admin/federationmore/add_1_it.png)

Use the Add button then choice / insert carefully the data required:

![add 2](/docs/admin/federationmore/add_2_it.png)

- referenced table  
  where the data must be stored
- field name  
  as indicated, use a camelCase format
- form label used to
- rules() value  
  that the most difficult value, u must learn
  about [laravel validation rules](https://laravel.com/docs/master/validation)
- default value  
  means _what i use when no fields are inserted for user / work?_
- suggestion words

All data must be inserted in lang=en then translated (like messages)
in all lang used by platform.

## Modify

The fields are the same, with a check:
if the federation-more-field is used in any of related table
you can't change related table and field name, only remaining form fields.

![modify ok](/docs/admin/federationmore/modify_ok_it.png)

## Remove

Form field are all readonly.
Check: if the federation-more-field is used in any of related table
you can't remove the record.

![remove ok](/docs/admin/federationmore/remove_ok_it.png)
