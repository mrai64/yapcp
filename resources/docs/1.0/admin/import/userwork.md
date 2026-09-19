# Import UserContact + UserWork + UserWorkMore | Admin
<!-- absolute links are /resources/docs/1.0/    -->
<!-- larecipe links are /{{route}}/{{version}}/ -->
<!-- images must be uploaded in /storage/app/public/docs/1.0/ then url prefixed by /docs/1.0/ -->

- [Import skeleton EN](https://yapcp.test/samples/user_work_skeleton_en.yaml)
- [Import skeleton IT](https://yapcp.test/samples/user_work_skeleton_it.yaml)

---

## A backup is *something you ‘should have done earlier’* – so do it.  

So, after write a backup sometimes we need to import old data.  
Choose the function, choose the file, start the process.

## One more thing? 

When in platform a new contest is designed, maybe done a facility import some data from previous contest 

> <!-- avoid insert in larecipe index -->
<!-- when inserted in image folder can't download correctly despite of /docs/ address -->
- [YAML User Work Import sample file EN](https://yapcp.test/samples/user_work_skeleton_en.yaml)
- [YAML User Work Import sample file IT](https://yapcp.test/samples/user_work_skeleton_it.yaml)

1. Only member of admin group can use import facility,
  due the potential risk to lock the platform
1. Even as admin group, the skeleton file is fulled
  of instructions, in form of yaml comments
1. to edit a yaml file don't use LibreOffice or any wordprecessing program,
  instead use a text-only editor from windows Notepad to notepad++
  and similar. Spaces indentation is a fundament of yaml grammar,
  *not, not, NOT replace* initial spaces with tabs, don't.
1. check that every item is rightly indented. At last is easy compile
  but it's also easy insert errors.
1. *"No null"* - facultative fields are facultative, if you wanna skip a value
  leave the row, instead of use "fieldname: null".
