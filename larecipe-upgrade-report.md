# LaRecipe upgrade report

Written by `php artisan larecipe:upgrade` on 2026-10-24. These changes were applied. Review the diff before you commit it.

## Summary

| | |
| --- | --- |
| Versions | 1.0, dev |
| Docs folder | `resources/docs/` moves to `docs/` |
| Pages converted | 183 |
| Files written | 188 |
| Files removed | 186 |
| Left for you | 30 |
| Validation | 84 errors, 623 warnings |

## 1. Composer and code

Run these, in order:

```bash
composer remove binarytorch/larecipe
```

- The namespace is now `LaRecipe\` (it was `BinaryTorch\LaRecipe\`).
- The `viewLarecipe` gate now receives the page and the set key: `fn ($user, $page = null, $set = null)`, where `$page` has `ref->path`, `ref->version`, `title` and `private`.
- Publish the new config only if you want the full reference: `php artisan vendor:publish --tag=larecipe-config` (this upgrade already wrote a working `config/larecipe.php`).

## 2. Left for you

The `larecipe-upgrade-v2` skill reads `larecipe-upgrade-report.json` and works through this list with you.

- [ ] `docs/1.0/organizations/dashboard.md:6`: Blade in Markdown is not evaluated in v3: <!-- that's a md file not a blade. no @if... or {{ if... }} --> Replace it with a component, an include or plain Markdown (larecipe-upgrade-v2 skill).
- [ ] `resources/docs/1.0/index.md:1`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: # &nbsp;
- [ ] `resources/docs/1.0/index.md:2`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- No title but that is the user manual, plain text and how to -->
- [ ] `resources/docs/1.0/index.md:3`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- absolute links are /resources/docs/1.0/    -->
- [ ] `resources/docs/1.0/index.md:4`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- larecipe links are /{{route}}/{{version}}/ -->
- [ ] `resources/docs/1.0/index.md:5`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- images must be uploaded in same folder of md then url prefixed by ./  -->
- [ ] `resources/docs/1.0/index.md:6`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- that's a md file not a blade. no @if... or {{ if... }} -->
- [ ] `resources/docs/1.0/index.md:8`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- fully qualified address -->
- [ ] `resources/docs/1.0/index.md:35`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: - **Contest Design**
- [ ] `resources/docs/1.0/index.md:43`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: - **Contest Management**
- [ ] `resources/docs/1.0/index.md:125`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: &nbsp;
- [ ] `resources/docs/1.0/index.md:127`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: &nbsp;
- [ ] `resources/docs/1.0/index.md:129`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: &nbsp;
- [ ] `resources/docs/1.0/index.md:131`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: &nbsp;
- [ ] `docs/dev/docs/0188-federation-policy.md:94`: Blade in Markdown is not evaluated in v3: - resources/views/livewire/federation/listed.blade.php — elemento: pulsante "Add New Federation" e pulsanti link "Update", "Remove"  — condizione Blade: direttiva (@if) presente nel template — visibilità: il pulsante viene visualizzato a condizione che sia ($user->isAdmin()); l'autorizzazione viene gestita lato server/Livewire (vedi: <https://github.com/mrai64/yapcp/blob/64600eabe3d669dfe613e7fb92d8c22c25c7b1dc/resources/views/livewire/federation/listed.blade.php>). Replace it with a component, an include or plain Markdown (larecipe-upgrade-v2 skill).
- [ ] `docs/dev/docs/0188-federation-policy.md:96`: Blade in Markdown is not evaluated in v3: - resources/views/livewire/federation/modify.blade.php — elemento: form di modifica + pulsante "Update" — condizione Blade: nessuna direttiva (@if/@can/@role) presente nel template — visibilità: il controllo UI è reso incondizionatamente; l'autorizzazione deve essere gestita lato server/Livewire (vedi: <https://github.com/mrai64/yapcp/blob/64600eabe3d669dfe613e7fb92d8c22c25c7b1dc/resources/views/livewire/federation/modify.blade.php>). Replace it with a component, an include or plain Markdown (larecipe-upgrade-v2 skill).
- [ ] `docs/dev/docs/0188-federation-policy.md:98`: Blade in Markdown is not evaluated in v3: - resources/views/livewire/federation/remove.blade.php — elemento: form di rimozione + pulsante "Confirm" — condizione Blade: nessuna direttiva (@if/@can/@role) presente nel template — visibilità: il controllo UI è reso incondizionatamente; l'autorizzazione deve essere gestita lato server/Livewire (vedi: <https://github.com/mrai64/yapcp/blob/64600eabe3d669dfe613e7fb92d8c22c25c7b1dc/resources/views/livewire/federation/remove.blade.php>). Replace it with a component, an include or plain Markdown (larecipe-upgrade-v2 skill).
- [ ] `resources/docs/dev/index.md:1`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: # &nbsp;
- [ ] `resources/docs/dev/index.md:2`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- No title but that is the tech manual, explain what when who why -->
- [ ] `resources/docs/dev/index.md:3`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- absolute links are /resources/docs/dev/    -->
- [ ] `resources/docs/dev/index.md:4`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- larecipe links are /{{route}}/dev/ -->
- [ ] `resources/docs/dev/index.md:5`: This sidebar line is not a group heading or a link, so it was left out of navigation.json: <!-- images must be uploaded in /storage/app/public/docs/dev/ then url prefixed by /docs/dev/ -->
- [ ] `app/Providers/AppServiceProvider.php:35`: The BinaryTorch\LaRecipe namespace is now LaRecipe\. Replace BinaryTorch\LaRecipe\ with LaRecipe\ and check the class still exists in v3.
- [ ] `resources/views/vendor/larecipe/.DS_Store`: Published v2 views are not used by v3. Replace it with a slot override (NotFound, Logo, Header, Sidebar) or LaRecipe::head(), then delete the folder.
- [ ] `resources/views/vendor/larecipe/partials/404.blade.php`: Published v2 views are not used by v3. Replace it with a slot override (NotFound, Logo, Header, Sidebar) or LaRecipe::head(), then delete the folder.
- [ ] `resources/views/vendor/larecipe/partials/logo.blade original.php`: Published v2 views are not used by v3. Replace it with a slot override (NotFound, Logo, Header, Sidebar) or LaRecipe::head(), then delete the folder.
- [ ] `resources/views/vendor/larecipe/partials/logo.blade yapcp.php`: Published v2 views are not used by v3. Replace it with a slot override (NotFound, Logo, Header, Sidebar) or LaRecipe::head(), then delete the folder.
- [ ] `resources/views/vendor/larecipe/partials/logo.blade.php`: Published v2 views are not used by v3. Replace it with a slot override (NotFound, Logo, Header, Sidebar) or LaRecipe::head(), then delete the folder.
- [ ] `resources/views/vendor/larecipe/partials/nav.blade.php`: Published v2 views are not used by v3. Replace it with a slot override (NotFound, Logo, Header, Sidebar) or LaRecipe::head(), then delete the folder.
- [ ] `resources/views/vendor/larecipe/partials/sidebar.blade.php`: Published v2 views are not used by v3. Replace it with a slot override (NotFound, Logo, Header, Sidebar) or LaRecipe::head(), then delete the folder.

## 3. Files

| Change | File | Why |
| --- | --- | --- |
| write | `docs/1.0/admin/backup/contest1st.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/backup/user.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/backup/userwork.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/country/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation/add.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation/read.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation/remove.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_more/add.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_more/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_more/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_more/remove.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_section/add.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_section/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_section/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/federation_section/remove.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/import/user.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/import/userwork.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/overview.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/timezone/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/admin/user_contact/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/award/add.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/award/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/award/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/award/remove.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/calendar/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/contest/add.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/contest/detail.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/contest/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/jury/add.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/jury/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/jury/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/jury/remove.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/patronages/add.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/patronages/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/patronages/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/patronages/remove.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/section/add1.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/section/add2.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/section/listed.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/section/modify.md` | converted to v3 Markdown |
| write | `docs/1.0/contest_design/section/remove.md` | converted to v3 Markdown |
| write | `docs/1.0/jurors/change.md` | converted to v3 Markdown |
| write | `docs/1.0/jurors/general.md` | converted to v3 Markdown |
| write | `docs/1.0/jurors/in-out.md` | converted to v3 Markdown |
| write | `docs/1.0/jurors/vote.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/add_me_to.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/admit_assignment.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/contest_waiting_revoke.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/contest_work_review.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/dashboard.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/section_awards.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/section_scoreboard.md` | converted to v3 Markdown |
| write | `docs/1.0/organizations/switch_fee_payment_status.md` | converted to v3 Markdown |
| write | `docs/1.0/overview.md` | converted to v3 Markdown |
| write | `docs/1.0/users/add_organization.md` | converted to v3 Markdown |
| write | `docs/1.0/users/contact_infos.md` | converted to v3 Markdown |
| write | `docs/1.0/users/contest_list.md` | converted to v3 Markdown |
| write | `docs/1.0/users/contest_subscribe.md` | converted to v3 Markdown |
| write | `docs/1.0/users/dashboard.md` | converted to v3 Markdown |
| write | `docs/1.0/users/federation_list.md` | converted to v3 Markdown |
| write | `docs/1.0/users/federation_section_list.md` | converted to v3 Markdown |
| write | `docs/1.0/users/personal_gallery.md` | converted to v3 Markdown |
| write | `docs/1.0/users/registration.md` | converted to v3 Markdown |
| write | `docs/1.0/users/work_add.md` | converted to v3 Markdown |
| write | `docs/1.0/users/work_modify.md` | converted to v3 Markdown |
| write | `docs/1.0/users/work_remove.md` | converted to v3 Markdown |
| write | `docs/1.0/welcome.aboard.md` | converted to v3 Markdown |
| write | `docs/1.0/navigation.json` | the v2 sidebar as navigation.json |
| delete | `resources/docs/1.0/index.md` | the sidebar now lives in navigation.json |
| write | `docs/dev/docs/0141-user-login.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0159-user-work-add.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0160-user-work-listed1.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0184-federation-read.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0185-federation-add.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0186-federation-update.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0187-federation-delete.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0188-federation-policy.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0189-federation-section-listed.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0190-federation-section-add.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0192-federation-section-update.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0193-federation-section-delete.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0194-federation-section-policy.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0195-federation-mode-read.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0199-federation-more-policy.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0258-contest-patronage-listed.md` | converted to v3 Markdown |
| write | `docs/dev/docs/0307-contest-detail.md` | converted to v3 Markdown |
| write | `docs/dev/docs/141-user-login.md` | moved |
| write | `docs/dev/feat/0006-admin-user-index.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0016-contest-section-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0020-add-me-to-org.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0036-contest-import.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0076-contest-section-modify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0086-contest-jury-modify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0093-language-translation.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0111-user-role-review.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0114-federation-delete-policy.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0115-federation-delete.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0116-federation-more-crud.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0128-breeze-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0148-federations.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0161-user-work-listed2.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0162-user-work-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0164-user-work-modify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0167-user-work-wnh.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0200-federation-list.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0208-contest-patronage.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0231-federation-more-listed.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0232-federation-more-add.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0233-federation-more-modify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0234-federation-more-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0257-contest-patronage-add.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0261-contest-patronage-modify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0263-contest-patronage-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0265-federation-list-add.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0266-remove-federation-list-modify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0267-remove-federation-list-listed.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0284-contest-jury-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0285-contest-jury-add.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0286-contest-jury-listed.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0288-contest-jury-qualify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0296-contest-award-listed.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0297-contest-award-add-section.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0298-contest-award-modify.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0299-contest-award-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0317-user-work-backup.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0318-user-backup.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0319-user-import.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0344-contest-backup.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0348-user-work-import.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0350-country-listed.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0351-timezone-listed.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0353-federation-mode.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0361-contest-work-add.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0363-user-dashboard.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0366-user-work-validation.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0368-contest-work-review.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0369-user-work-validator.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0375-contest-waiting-remove.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0376-contest-participant.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0385-juror-dashboard.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0386-organization-dashboard.md` | converted to v3 Markdown |
| write | `docs/dev/feat/0387-contest-vote-add.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0107-user-role-seeder-ko.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0142-register-test.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0150-referenced.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0215-federation-section-listed.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0217-federation-section-listed.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0219-federation-section-mono.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0235-federation-mores-referenced-set-typo.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0253-organization-update-not-for-all.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0270-federation.modify.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0279-contest-section-add.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0325-contest-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0326-contest-award-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0327-contest-jury-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0328-contest-section-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0329-contest-waiting-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0330-contest-work-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0331-organization-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/0333-user-work-uuid.md` | converted to v3 Markdown |
| write | `docs/dev/fix/107-user-role-seeder-ko.md` | moved |
| write | `docs/dev/functionality-index.md` | converted to v3 Markdown |
| write | `docs/dev/man/admins.md` | converted to v3 Markdown |
| write | `docs/dev/man/build-a-contest.md` | converted to v3 Markdown |
| write | `docs/dev/man/database.md` | converted to v3 Markdown |
| write | `docs/dev/man/dbdoc.md` | converted to v3 Markdown |
| write | `docs/dev/man/federations.md` | converted to v3 Markdown |
| write | `docs/dev/man/index.md` | converted to v3 Markdown |
| write | `docs/dev/man/jury-works.md` | converted to v3 Markdown |
| write | `docs/dev/man/organizations.md` | converted to v3 Markdown |
| write | `docs/dev/man/run-a-contest.md` | converted to v3 Markdown |
| write | `docs/dev/man/users.md` | converted to v3 Markdown |
| write | `docs/dev/overview.md` | converted to v3 Markdown |
| write | `docs/dev/refactor/0089-regions-lookup-table.md` | converted to v3 Markdown |
| write | `docs/dev/refactor/0129-user-works.md` | converted to v3 Markdown |
| write | `docs/dev/refactor/0133-federation-section-fields.md` | converted to v3 Markdown |
| write | `docs/dev/refactor/0140-big-rebuild.md` | converted to v3 Markdown |
| write | `docs/dev/refactor/0239-contest-patronage.md` | converted to v3 Markdown |
| write | `docs/dev/refactor/0352-user-contact-whatsapp.md` | converted to v3 Markdown |
| write | `docs/dev/refactor/89-regions-lookup-table.md` | moved |
| write | `docs/dev/state-of-art.md` | converted to v3 Markdown |
| write | `docs/dev/template.md` | converted to v3 Markdown |
| write | `docs/dev/welcome.aboard.md` | converted to v3 Markdown |
| write | `docs/dev/wiki/abcde-method.md` | converted to v3 Markdown |
| write | `docs/dev/navigation.json` | the v2 sidebar as navigation.json |
| delete | `resources/docs/dev/index.md` | the sidebar now lives in navigation.json |
| copy | `docs/0 img in storage app public docs.txt` | moved from resources/docs/0 img in storage app public docs.txt |
| delete | `resources/docs/1.0/admin/backup/contest1st.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/backup/user.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/backup/userwork.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/country/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation/add.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation/read.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation/remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_more/add.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_more/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_more/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_more/remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_section/add.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_section/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_section/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/federation_section/remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/import/user.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/import/userwork.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/overview.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/timezone/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/admin/user_contact/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/award/add.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/award/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/award/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/award/remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/calendar/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/contest/add.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/contest/detail.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/contest/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/jury/add.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/jury/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/jury/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/jury/remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/patronages/add.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/patronages/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/patronages/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/patronages/remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/section/add1.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/section/add2.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/section/listed.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/section/modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/contest_design/section/remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/jurors/change.md` | moved to docs/ |
| delete | `resources/docs/1.0/jurors/general.md` | moved to docs/ |
| delete | `resources/docs/1.0/jurors/in-out.md` | moved to docs/ |
| delete | `resources/docs/1.0/jurors/vote.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/add_me_to.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/admit_assignment.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/contest_waiting_revoke.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/contest_work_review.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/dashboard.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/section_awards.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/section_scoreboard.md` | moved to docs/ |
| delete | `resources/docs/1.0/organizations/switch_fee_payment_status.md` | moved to docs/ |
| delete | `resources/docs/1.0/overview.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/add_organization.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/contact_infos.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/contest_list.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/contest_subscribe.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/dashboard.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/federation_list.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/federation_section_list.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/personal_gallery.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/registration.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/work_add.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/work_modify.md` | moved to docs/ |
| delete | `resources/docs/1.0/users/work_remove.md` | moved to docs/ |
| delete | `resources/docs/1.0/welcome.aboard.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0141-user-login.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0159-user-work-add.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0160-user-work-listed1.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0184-federation-read.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0185-federation-add.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0186-federation-update.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0187-federation-delete.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0188-federation-policy.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0189-federation-section-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0190-federation-section-add.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0192-federation-section-update.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0193-federation-section-delete.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0194-federation-section-policy.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0195-federation-mode-read.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0199-federation-more-policy.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0258-contest-patronage-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/0307-contest-detail.md` | moved to docs/ |
| delete | `resources/docs/dev/docs/141-user-login.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0006-admin-user-index.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0016-contest-section-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0020-add-me-to-org.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0036-contest-import.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0076-contest-section-modify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0086-contest-jury-modify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0093-language-translation.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0111-user-role-review.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0114-federation-delete-policy.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0115-federation-delete.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0116-federation-more-crud.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0128-breeze-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0148-federations.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0161-user-work-listed2.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0162-user-work-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0164-user-work-modify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0167-user-work-wnh.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0200-federation-list.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0208-contest-patronage.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0231-federation-more-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0232-federation-more-add.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0233-federation-more-modify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0234-federation-more-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0257-contest-patronage-add.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0261-contest-patronage-modify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0263-contest-patronage-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0265-federation-list-add.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0266-remove-federation-list-modify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0267-remove-federation-list-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0284-contest-jury-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0285-contest-jury-add.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0286-contest-jury-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0288-contest-jury-qualify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0296-contest-award-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0297-contest-award-add-section.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0298-contest-award-modify.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0299-contest-award-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0317-user-work-backup.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0318-user-backup.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0319-user-import.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0344-contest-backup.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0348-user-work-import.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0350-country-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0351-timezone-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0353-federation-mode.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0361-contest-work-add.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0363-user-dashboard.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0366-user-work-validation.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0368-contest-work-review.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0369-user-work-validator.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0375-contest-waiting-remove.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0376-contest-participant.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0385-juror-dashboard.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0386-organization-dashboard.md` | moved to docs/ |
| delete | `resources/docs/dev/feat/0387-contest-vote-add.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0107-user-role-seeder-ko.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0142-register-test.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0150-referenced.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0215-federation-section-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0217-federation-section-listed.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0219-federation-section-mono.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0235-federation-mores-referenced-set-typo.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0253-organization-update-not-for-all.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0270-federation.modify.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0279-contest-section-add.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0325-contest-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0326-contest-award-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0327-contest-jury-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0328-contest-section-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0329-contest-waiting-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0330-contest-work-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0331-organization-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/0333-user-work-uuid.md` | moved to docs/ |
| delete | `resources/docs/dev/fix/107-user-role-seeder-ko.md` | moved to docs/ |
| delete | `resources/docs/dev/functionality-index.md` | moved to docs/ |
| delete | `resources/docs/dev/man/admins.md` | moved to docs/ |
| delete | `resources/docs/dev/man/build-a-contest.md` | moved to docs/ |
| delete | `resources/docs/dev/man/database.md` | moved to docs/ |
| delete | `resources/docs/dev/man/dbdoc.md` | moved to docs/ |
| delete | `resources/docs/dev/man/federations.md` | moved to docs/ |
| delete | `resources/docs/dev/man/index.md` | moved to docs/ |
| delete | `resources/docs/dev/man/jury-works.md` | moved to docs/ |
| delete | `resources/docs/dev/man/organizations.md` | moved to docs/ |
| delete | `resources/docs/dev/man/run-a-contest.md` | moved to docs/ |
| delete | `resources/docs/dev/man/users.md` | moved to docs/ |
| delete | `resources/docs/dev/overview.md` | moved to docs/ |
| delete | `resources/docs/dev/refactor/0089-regions-lookup-table.md` | moved to docs/ |
| delete | `resources/docs/dev/refactor/0129-user-works.md` | moved to docs/ |
| delete | `resources/docs/dev/refactor/0133-federation-section-fields.md` | moved to docs/ |
| delete | `resources/docs/dev/refactor/0140-big-rebuild.md` | moved to docs/ |
| delete | `resources/docs/dev/refactor/0239-contest-patronage.md` | moved to docs/ |
| delete | `resources/docs/dev/refactor/0352-user-contact-whatsapp.md` | moved to docs/ |
| delete | `resources/docs/dev/refactor/89-regions-lookup-table.md` | moved to docs/ |
| delete | `resources/docs/dev/state-of-art.md` | moved to docs/ |
| delete | `resources/docs/dev/template.md` | moved to docs/ |
| delete | `resources/docs/dev/welcome.aboard.md` | moved to docs/ |
| delete | `resources/docs/dev/wiki/abcde-method.md` | moved to docs/ |
| delete | `resources/docs/0 img in storage app public docs.txt` | moved to docs/ |
| write | `docs/larecipe.json` | the set manifest |
| write | `config/larecipe.php` | the LaRecipe 3 config (the v2 file is kept as config/larecipe.v2.php.bak) |

## 4. What changed

- `config/larecipe.php`: The docs keep their route prefix (/docs) and middleware (web).
- `config/larecipe.php`: Access mode is "auth". v2 settings.auth was true, so every page needs a signed-in reader.
- `docs/larecipe.json`: Versions (1.0, dev), the landing page, the favicon, the primary color (as theme.accent) and the description moved to larecipe.json.
- `docs/1.0/admin/overview.md`: 2 links became relative .md links.
- `docs/1.0/contest_design/award/add.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/award/listed.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/award/modify.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/award/remove.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/calendar/modify.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/contest/add.md`: 5 links became relative .md links.
- `docs/1.0/contest_design/contest/detail.md`: 5 links became relative .md links.
- `docs/1.0/contest_design/contest/modify.md`: 5 links became relative .md links.
- `docs/1.0/contest_design/jury/add.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/jury/listed.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/jury/modify.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/jury/remove.md`: 4 links became relative .md links.
- `docs/1.0/contest_design/patronages/add.md`: 3 links became relative .md links.
- `docs/1.0/contest_design/patronages/listed.md`: 3 links became relative .md links.
- `docs/1.0/contest_design/patronages/modify.md`: 3 links became relative .md links.
- `docs/1.0/contest_design/patronages/remove.md`: 3 links became relative .md links.
- `docs/1.0/contest_design/section/add1.md`: 6 links became relative .md links.
- `docs/1.0/contest_design/section/add2.md`: 7 links became relative .md links.
- `docs/1.0/contest_design/section/listed.md`: 11 links became relative .md links.
- `docs/1.0/contest_design/section/modify.md`: 6 links became relative .md links.
- `docs/1.0/contest_design/section/remove.md`: 5 links became relative .md links.
- `docs/1.0/jurors/general.md`: 1 link became a relative .md link.
- `docs/1.0/overview.md`: 4 links became relative .md links.
- `docs/1.0/users/contact_infos.md:3`: Removed the hand-written table of contents. v3 builds one from the headings.
- `docs/1.0/users/dashboard.md`: 4 links became relative .md links.
- `docs/1.0/users/personal_gallery.md`: 7 links became relative .md links.
- `docs/1.0/users/registration.md`: 1 link became a relative .md link.
- `docs/1.0/users/registration.md:3`: Removed the hand-written table of contents. v3 builds one from the headings.
- `docs/1.0/welcome.aboard.md`: 1 link became a relative .md link.
- `docs/1.0/welcome.aboard.md:3`: The opening paragraph became the page description, shown under the title.
- `resources/docs/1.0/index.md`: The sidebar became navigation.json (67 entries).
- `docs/dev/docs/0141-user-login.md`: 2 links became relative .md links.
- `docs/dev/docs/0159-user-work-add.md`: 2 links became relative .md links.
- `docs/dev/docs/0160-user-work-listed1.md`: 2 links became relative .md links.
- `docs/dev/feat/0020-add-me-to-org.md`: 2 links became relative .md links.
- `docs/dev/feat/0093-language-translation.md`: 2 links became relative .md links.
- `docs/dev/feat/0111-user-role-review.md`: 2 links became relative .md links.
- `docs/dev/feat/0114-federation-delete-policy.md`: 2 links became relative .md links.
- `docs/dev/feat/0115-federation-delete.md`: 4 links became relative .md links.
- `docs/dev/feat/0116-federation-more-crud.md`: 2 links became relative .md links.
- `docs/dev/feat/0128-breeze-remove.md`: 2 links became relative .md links.
- `docs/dev/feat/0148-federations.md`: 2 links became relative .md links.
- `docs/dev/feat/0161-user-work-listed2.md`: 2 links became relative .md links.
- `docs/dev/feat/0162-user-work-remove.md`: 2 links became relative .md links.
- `docs/dev/feat/0164-user-work-modify.md`: 2 links became relative .md links.
- `docs/dev/feat/0167-user-work-wnh.md`: 2 links became relative .md links.
- `docs/dev/feat/0200-federation-list.md`: 2 links became relative .md links.
- `docs/dev/feat/0208-contest-patronage.md`: 2 links became relative .md links.
- `docs/dev/fix/0107-user-role-seeder-ko.md`: 2 links became relative .md links.
- `docs/dev/fix/0142-register-test.md`: 2 links became relative .md links.
- `docs/dev/fix/0150-referenced.md`: 2 links became relative .md links.
- `docs/dev/fix/0219-federation-section-mono.md`: 2 links became relative .md links.
- `docs/dev/fix/0235-federation-mores-referenced-set-typo.md`: 2 links became relative .md links.
- `docs/dev/fix/0253-organization-update-not-for-all.md`: 2 links became relative .md links.
- `docs/dev/functionality-index.md`: 2 links became relative .md links.
- `docs/dev/man/database.md`: 1 link became a relative .md link.
- `docs/dev/man/index.md`: 7 links became relative .md links.
- `docs/dev/man/index.md:3`: The opening paragraph became the page description, shown under the title.
- `docs/dev/man/users.md:3`: The opening paragraph became the page description, shown under the title.
- `docs/dev/overview.md`: 3 links became relative .md links.
- `docs/dev/refactor/0089-regions-lookup-table.md`: 2 links became relative .md links.
- `docs/dev/refactor/0129-user-works.md`: 2 links became relative .md links.
- `docs/dev/refactor/0133-federation-section-fields.md`: 2 links became relative .md links.
- `docs/dev/refactor/0140-big-rebuild.md`: 2 links became relative .md links.
- `docs/dev/refactor/0239-contest-patronage.md`: 2 links became relative .md links.
- `docs/dev/refactor/0352-user-contact-whatsapp.md`: 2 links became relative .md links.
- `docs/dev/state-of-art.md`: 2 links became relative .md links.
- `docs/dev/state-of-art.md:3`: The opening paragraph became the page description, shown under the title.
- `resources/docs/dev/index.md`: The sidebar became navigation.json (19 entries).
- `docs`: The docs move from resources/docs/ to docs/.

## 5. Dropped on purpose

- `config/larecipe.php`: cache: rendered pages are always cached by content hash in v3. Run php artisan larecipe:optimize on deploy (it runs with php artisan optimize).
- `config/larecipe.php`: search.engines.algolia: Algolia DocSearch is gone. Search is built in and works offline. Remove the Algolia keys from your .env.
- `config/larecipe.php`: ui.code_theme: code blocks follow the page theme, light and dark.
- `config/larecipe.php`: ui.colors.secondary: v3 themes have one accent color. Fine-tune colors in a theme.css listed under assets.css in larecipe.json.
- `config/larecipe.php`: ui.fa_v4_shims: Font Awesome is gone; v3 uses one icon set (Lucide).
- `config/larecipe.php`: ui.theme_order: there are no stacked theme packages in v3.
- `config/larecipe.php`: ui.show_side_bar: the sidebar is part of every page. Set layout: wide or layout: full in a page's frontmatter for more room.
- `config/larecipe.php`: seo.author, seo.keywords, seo.og: pages describe themselves through frontmatter (title, description), canonical URLs and JSON-LD. Give every page a description in its frontmatter.
- `config/larecipe.php`: blade-parser: v3 does not pre-process HTML with regular expressions.

## 6. Validation

183 pages checked: 84 errors, 623 warnings.

| Level | Rule | Page | Message |
| --- | --- | --- | --- |
| warning | `frontmatter.description.missing` | `1.0/admin/backup/contest1st.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/backup/user.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/backup/userwork.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/country/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation/add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation/read.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation/remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_more/add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_more/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_more/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_more/remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_section/add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_section/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_section/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/federation_section/remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/import/user.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/import/userwork.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/overview.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/admin/overview.md` | Link to federation/read.md: there is no page at "admin/federation/read". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/admin/overview.md` | Link to federation/add.md: there is no page at "admin/federation/add". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/admin/timezone/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/admin/user_contact/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/award/add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/award/add.md` | Link to listed.md: there is no page at "contest_design/award/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/add.md` | Link to add.md: there is no page at "contest_design/award/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/add.md` | Link to modify.md: there is no page at "contest_design/award/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/add.md` | Link to remove.md: there is no page at "contest_design/award/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/award/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/award/listed.md` | Link to listed.md: there is no page at "contest_design/award/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/listed.md` | Link to add.md: there is no page at "contest_design/award/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/listed.md` | Link to modify.md: there is no page at "contest_design/award/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/listed.md` | Link to remove.md: there is no page at "contest_design/award/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/award/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/award/modify.md` | Link to listed.md: there is no page at "contest_design/award/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/modify.md` | Link to add.md: there is no page at "contest_design/award/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/modify.md` | Link to modify.md: there is no page at "contest_design/award/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/modify.md` | Link to remove.md: there is no page at "contest_design/award/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/award/remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/award/remove.md` | Link to listed.md: there is no page at "contest_design/award/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/remove.md` | Link to add.md: there is no page at "contest_design/award/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/remove.md` | Link to modify.md: there is no page at "contest_design/award/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/award/remove.md` | Link to remove.md: there is no page at "contest_design/award/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/calendar/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/calendar/modify.md` | Link to ../contest/add.md: there is no page at "contest_design/contest/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/calendar/modify.md` | Link to modify.md: there is no page at "contest_design/calendar/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/calendar/modify.md` | Link to ../contest/weblink.md: there is no page at "contest_design/contest/weblink". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/calendar/modify.md` | Link to ../contest/detail.md: there is no page at "contest_design/contest/detail". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/contest/add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/contest/add.md` | Link to add.md: there is no page at "contest_design/contest/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/add.md` | Link to modify.md: there is no page at "contest_design/contest/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/add.md` | Link to ../calendar/modify.md: there is no page at "contest_design/calendar/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/add.md` | Link to weblink.md: there is no page at "contest_design/contest/weblink". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/add.md` | Link to detail.md: there is no page at "contest_design/contest/detail". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/contest/detail.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/contest/detail.md` | Link to add.md: there is no page at "contest_design/contest/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/detail.md` | Link to modify.md: there is no page at "contest_design/contest/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/detail.md` | Link to ../calendar/modify.md: there is no page at "contest_design/calendar/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/detail.md` | Link to weblink.md: there is no page at "contest_design/contest/weblink". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/detail.md` | Link to detail.md: there is no page at "contest_design/contest/detail". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/contest/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/contest/modify.md` | Link to add.md: there is no page at "contest_design/contest/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/modify.md` | Link to modify.md: there is no page at "contest_design/contest/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/modify.md` | Link to ../calendar/modify.md: there is no page at "contest_design/calendar/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/modify.md` | Link to weblink.md: there is no page at "contest_design/contest/weblink". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/contest/modify.md` | Link to detail.md: there is no page at "contest_design/contest/detail". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/jury/add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/jury/add.md` | Link to listed.md: there is no page at "contest_design/jury/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/add.md` | Link to add.md: there is no page at "contest_design/jury/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/add.md` | Link to modify.md: there is no page at "contest_design/jury/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/add.md` | Link to remove.md: there is no page at "contest_design/jury/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/jury/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/jury/listed.md` | Link to listed.md: there is no page at "contest_design/jury/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/listed.md` | Link to add.md: there is no page at "contest_design/jury/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/listed.md` | Link to modify.md: there is no page at "contest_design/jury/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/listed.md` | Link to remove.md: there is no page at "contest_design/jury/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/jury/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/jury/modify.md` | Link to listed.md: there is no page at "contest_design/jury/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/modify.md` | Link to add.md: there is no page at "contest_design/jury/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/modify.md` | Link to modify.md: there is no page at "contest_design/jury/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/modify.md` | Link to remove.md: there is no page at "contest_design/jury/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/jury/remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/jury/remove.md` | Link to listed.md: there is no page at "contest_design/jury/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/remove.md` | Link to add.md: there is no page at "contest_design/jury/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/remove.md` | Link to modify.md: there is no page at "contest_design/jury/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/jury/remove.md` | Link to remove.md: there is no page at "contest_design/jury/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/patronages/add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/patronages/add.md` | Link to add.md: there is no page at "contest_design/patronages/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/add.md` | Link to modify.md: there is no page at "contest_design/patronages/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/add.md` | Link to remove.md: there is no page at "contest_design/patronages/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/patronages/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/patronages/listed.md` | Link to add.md: there is no page at "contest_design/patronages/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/listed.md` | Link to modify.md: there is no page at "contest_design/patronages/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/listed.md` | Link to remove.md: there is no page at "contest_design/patronages/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/patronages/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/patronages/modify.md` | Link to add.md: there is no page at "contest_design/patronages/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/modify.md` | Link to modify.md: there is no page at "contest_design/patronages/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/modify.md` | Link to remove.md: there is no page at "contest_design/patronages/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/patronages/remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/patronages/remove.md` | Link to add.md: there is no page at "contest_design/patronages/add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/remove.md` | Link to modify.md: there is no page at "contest_design/patronages/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/patronages/remove.md` | Link to add.md: there is no page at "contest_design/patronages/add". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/section/add1.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/section/add1.md` | Link to listed.md: there is no page at "contest_design/section/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add1.md` | Link to add1.md: there is no page at "contest_design/section/add1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add1.md` | Link to add2.md: there is no page at "contest_design/section/add2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add1.md` | Link to modify1.md: there is no page at "contest_design/section/modify1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add1.md` | Link to modify2.md: there is no page at "contest_design/section/modify2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add1.md` | Link to remove.md: there is no page at "contest_design/section/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/section/add2.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/section/add2.md` | Link to listed.md: there is no page at "contest_design/section/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add2.md` | Link to add1.md: there is no page at "contest_design/section/add1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add2.md` | Link to add2.md: there is no page at "contest_design/section/add2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add2.md` | Link to modify1.md: there is no page at "contest_design/section/modify1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add2.md` | Link to modify2.md: there is no page at "contest_design/section/modify2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add2.md` | Link to remove.md: there is no page at "contest_design/section/remove". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/add2.md` | Link to ../patronages/add.md: there is no page at "contest_design/patronages/add". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/section/listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to listed.md: there is no page at "contest_design/section/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to add1.md: there is no page at "contest_design/section/add1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to add2.md: there is no page at "contest_design/section/add2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify1.md: there is no page at "contest_design/section/modify1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify2.md: there is no page at "contest_design/section/modify2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to remove.md: there is no page at "contest_design/section/remove". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to add1.md: there is no page at "contest_design/section/add1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to add2.md: there is no page at "contest_design/section/add2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify1.md: there is no page at "contest_design/section/modify1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify2.md: there is no page at "contest_design/section/modify2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/listed.md` | Link to remove.md: there is no page at "contest_design/section/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/section/modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/section/modify.md` | Link to listed.md: there is no page at "contest_design/section/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/modify.md` | Link to add1.md: there is no page at "contest_design/section/add1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/modify.md` | Link to add2.md: there is no page at "contest_design/section/add2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/modify.md` | Link to modify.md: there is no page at "contest_design/section/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/modify.md` | Link to remove.md: there is no page at "contest_design/section/remove". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/modify.md` | Link to add2.md: there is no page at "contest_design/section/add2". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/contest_design/section/remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/contest_design/section/remove.md` | Link to listed.md: there is no page at "contest_design/section/listed". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/remove.md` | Link to add1.md: there is no page at "contest_design/section/add1". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/remove.md` | Link to add2.md: there is no page at "contest_design/section/add2". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/remove.md` | Link to modify.md: there is no page at "contest_design/section/modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/contest_design/section/remove.md` | Link to remove.md: there is no page at "contest_design/section/remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/jurors/change.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/jurors/general.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/jurors/general.md` | Link to ../overview.md: there is no page at "overview". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/jurors/in-out.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/jurors/vote.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/add_me_to.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/admit_assignment.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/contest_waiting_revoke.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/contest_work_review.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/dashboard.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/section_awards.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/section_scoreboard.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/organizations/switch_fee_payment_status.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/overview.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/overview.md` | Link to index.md: there is no page at "index". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/overview.md` | Link to users/registration.md: there is no page at "users/registration". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/overview.md` | Link to users/dashboard.md: there is no page at "users/dashboard". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/users/add_organization.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/users/contact_infos.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/users/contest_list.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/users/contest_subscribe.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/users/dashboard.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/users/dashboard.md` | Link to contact_infos.md: there is no page at "users/contact_infos". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/dashboard.md` | Link to personal_gallery.md: there is no page at "users/personal_gallery". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/dashboard.md` | Link to add_organization.md: there is no page at "users/add_organization". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/dashboard.md` | Link to ../organizations/add_me_to.md: there is no page at "organizations/add_me_to". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/dashboard.md` | Link to #personal-contact-info: there is no such anchor on this page. Link to an existing heading, or remove the anchor. |
| warning | `frontmatter.description.missing` | `1.0/users/federation_list.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/users/federation_section_list.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/users/personal_gallery.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/users/personal_gallery.md` | Link to work_add.md: there is no page at "users/work_add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/personal_gallery.md` | Link to work_modify.md: there is no page at "users/work_modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/personal_gallery.md` | Link to work_remove.md: there is no page at "users/work_remove". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/personal_gallery.md` | Link to work_add.md: there is no page at "users/work_add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/personal_gallery.md` | Link to work_add.md: there is no page at "users/work_add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/personal_gallery.md` | Link to work_modify.md: there is no page at "users/work_modify". Fix the link, or write the page it points to. |
| warning | `links.broken` | `1.0/users/personal_gallery.md` | Link to work_remove.md: there is no page at "users/work_remove". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/users/registration.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/users/registration.md` | Link to dashboard.md: there is no page at "users/dashboard". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `1.0/users/work_add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `1.0/users/work_modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `1.0/users/work_modify.md` | Link to #the-upload-form: there is no such anchor on this page. Link to an existing heading, or remove the anchor. |
| warning | `frontmatter.description.missing` | `1.0/users/work_remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0141-user-login.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/docs/0141-user-login.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/docs/0141-user-login.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/docs/0159-user-work-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/docs/0159-user-work-add.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/docs/0159-user-work-add.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/docs/0160-user-work-listed1.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/docs/0160-user-work-listed1.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/docs/0160-user-work-listed1.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/docs/0184-federation-read.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0185-federation-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0186-federation-update.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0187-federation-delete.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0188-federation-policy.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0189-federation-section-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0190-federation-section-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0192-federation-section-update.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0193-federation-section-delete.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0194-federation-section-policy.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0195-federation-mode-read.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0199-federation-more-policy.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/docs/0258-contest-patronage-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/docs/0258-contest-patronage-listed.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/docs/0258-contest-patronage-listed.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/docs/0258-contest-patronage-listed.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/docs/0258-contest-patronage-listed.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/docs/0307-contest-detail.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/docs/0307-contest-detail.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/docs/0307-contest-detail.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/docs/0307-contest-detail.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/docs/0307-contest-detail.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/docs/141-user-login.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/docs/141-user-login.md` | Link to 0141-user-login.md: there is no page at "docs/0141-user-login". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0006-admin-user-index.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0006-admin-user-index.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0006-admin-user-index.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0006-admin-user-index.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0006-admin-user-index.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0016-contest-section-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0016-contest-section-remove.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0016-contest-section-remove.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0016-contest-section-remove.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0016-contest-section-remove.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0020-add-me-to-org.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0020-add-me-to-org.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0020-add-me-to-org.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0036-contest-import.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0036-contest-import.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0036-contest-import.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0036-contest-import.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0036-contest-import.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0076-contest-section-modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0076-contest-section-modify.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0076-contest-section-modify.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0076-contest-section-modify.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0076-contest-section-modify.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0086-contest-jury-modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0086-contest-jury-modify.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0086-contest-jury-modify.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0086-contest-jury-modify.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0086-contest-jury-modify.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0093-language-translation.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0093-language-translation.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0093-language-translation.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0111-user-role-review.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0111-user-role-review.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0111-user-role-review.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0114-federation-delete-policy.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0114-federation-delete-policy.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0114-federation-delete-policy.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0115-federation-delete.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/index.md: there is no page at "dev". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/docs/0185-federation-add.md: there is no page at "dev/docs/0185-federation-add". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/docs/0184-federation-read.md: there is no page at "dev/docs/0184-federation-read". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/docs/0186-federation-update.md: there is no page at "dev/docs/0186-federation-update". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0116-federation-more-crud.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0116-federation-more-crud.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0116-federation-more-crud.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0128-breeze-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0128-breeze-remove.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0128-breeze-remove.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0148-federations.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0148-federations.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0148-federations.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0161-user-work-listed2.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0161-user-work-listed2.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0161-user-work-listed2.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0162-user-work-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0162-user-work-remove.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0162-user-work-remove.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0164-user-work-modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0164-user-work-modify.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0164-user-work-modify.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0167-user-work-wnh.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0167-user-work-wnh.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0167-user-work-wnh.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0200-federation-list.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0200-federation-list.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0200-federation-list.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0208-contest-patronage.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0208-contest-patronage.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/feat/0208-contest-patronage.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/feat/0231-federation-more-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/feat/0232-federation-more-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/feat/0233-federation-more-modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/feat/0234-federation-more-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/feat/0257-contest-patronage-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0257-contest-patronage-add.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0257-contest-patronage-add.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0257-contest-patronage-add.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0257-contest-patronage-add.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0261-contest-patronage-modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0261-contest-patronage-modify.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0261-contest-patronage-modify.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0261-contest-patronage-modify.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0261-contest-patronage-modify.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0263-contest-patronage-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0263-contest-patronage-remove.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0263-contest-patronage-remove.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0263-contest-patronage-remove.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0263-contest-patronage-remove.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0265-federation-list-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0265-federation-list-add.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0265-federation-list-add.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0265-federation-list-add.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0265-federation-list-add.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0266-remove-federation-list-modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0266-remove-federation-list-modify.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0266-remove-federation-list-modify.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0266-remove-federation-list-modify.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0266-remove-federation-list-modify.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0267-remove-federation-list-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/feat/0284-contest-jury-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0284-contest-jury-remove.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0284-contest-jury-remove.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0284-contest-jury-remove.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0284-contest-jury-remove.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0285-contest-jury-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0285-contest-jury-add.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0285-contest-jury-add.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0285-contest-jury-add.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0285-contest-jury-add.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0286-contest-jury-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0286-contest-jury-listed.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0286-contest-jury-listed.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0286-contest-jury-listed.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0286-contest-jury-listed.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0288-contest-jury-qualify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0288-contest-jury-qualify.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0288-contest-jury-qualify.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0288-contest-jury-qualify.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0288-contest-jury-qualify.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0296-contest-award-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0296-contest-award-listed.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0296-contest-award-listed.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0296-contest-award-listed.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0296-contest-award-listed.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0297-contest-award-add-section.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0297-contest-award-add-section.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0297-contest-award-add-section.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0297-contest-award-add-section.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0297-contest-award-add-section.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0298-contest-award-modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0298-contest-award-modify.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0298-contest-award-modify.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0298-contest-award-modify.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0298-contest-award-modify.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0299-contest-award-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0299-contest-award-remove.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0299-contest-award-remove.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0299-contest-award-remove.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0299-contest-award-remove.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0317-user-work-backup.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0317-user-work-backup.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0317-user-work-backup.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0317-user-work-backup.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0317-user-work-backup.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0318-user-backup.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0318-user-backup.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0318-user-backup.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0318-user-backup.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0318-user-backup.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0319-user-import.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0319-user-import.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0319-user-import.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0319-user-import.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0319-user-import.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0344-contest-backup.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0344-contest-backup.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0344-contest-backup.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0344-contest-backup.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0344-contest-backup.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0348-user-work-import.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0348-user-work-import.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0348-user-work-import.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0348-user-work-import.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0348-user-work-import.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0350-country-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0350-country-listed.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0350-country-listed.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0350-country-listed.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0350-country-listed.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0351-timezone-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0351-timezone-listed.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0351-timezone-listed.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0351-timezone-listed.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0351-timezone-listed.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0353-federation-mode.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0353-federation-mode.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0353-federation-mode.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0353-federation-mode.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0353-federation-mode.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0361-contest-work-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0361-contest-work-add.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0361-contest-work-add.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0361-contest-work-add.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0361-contest-work-add.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0363-user-dashboard.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0363-user-dashboard.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0363-user-dashboard.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0363-user-dashboard.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0363-user-dashboard.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0366-user-work-validation.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0366-user-work-validation.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0366-user-work-validation.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0366-user-work-validation.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0366-user-work-validation.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0368-contest-work-review.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0368-contest-work-review.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0368-contest-work-review.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0368-contest-work-review.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0368-contest-work-review.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0369-user-work-validator.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0369-user-work-validator.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0369-user-work-validator.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0369-user-work-validator.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0369-user-work-validator.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0375-contest-waiting-remove.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0375-contest-waiting-remove.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0375-contest-waiting-remove.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0375-contest-waiting-remove.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0375-contest-waiting-remove.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0376-contest-participant.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0376-contest-participant.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0376-contest-participant.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0376-contest-participant.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0376-contest-participant.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0385-juror-dashboard.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0385-juror-dashboard.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0385-juror-dashboard.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0385-juror-dashboard.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0385-juror-dashboard.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0386-organization-dashboard.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0386-organization-dashboard.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0386-organization-dashboard.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0386-organization-dashboard.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0386-organization-dashboard.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/feat/0387-contest-vote-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/feat/0387-contest-vote-add.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/feat/0387-contest-vote-add.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/feat/0387-contest-vote-add.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/feat/0387-contest-vote-add.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0107-user-role-seeder-ko.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0107-user-role-seeder-ko.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/fix/0107-user-role-seeder-ko.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/fix/0142-register-test.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0142-register-test.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/fix/0142-register-test.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/fix/0150-referenced.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0150-referenced.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/fix/0150-referenced.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/fix/0215-federation-section-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/fix/0217-federation-section-listed.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/fix/0219-federation-section-mono.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0219-federation-section-mono.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/fix/0219-federation-section-mono.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/fix/0235-federation-mores-referenced-set-typo.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0235-federation-mores-referenced-set-typo.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/fix/0235-federation-mores-referenced-set-typo.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/fix/0253-organization-update-not-for-all.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to #-dettaglio-dei-file-modificati: there is no such anchor on this page. Use #dettaglio-dei-file-modificati. |
| warning | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0270-federation.modify.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/fix/0279-contest-section-add.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0279-contest-section-add.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0279-contest-section-add.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0279-contest-section-add.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0279-contest-section-add.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0325-contest-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0325-contest-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0325-contest-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0325-contest-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0325-contest-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0326-contest-award-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0326-contest-award-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0326-contest-award-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0326-contest-award-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0326-contest-award-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0327-contest-jury-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0327-contest-jury-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0327-contest-jury-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0327-contest-jury-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0327-contest-jury-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0328-contest-section-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0328-contest-section-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0328-contest-section-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0328-contest-section-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0328-contest-section-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0329-contest-waiting-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0329-contest-waiting-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0329-contest-waiting-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0329-contest-waiting-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0329-contest-waiting-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0330-contest-work-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0330-contest-work-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0330-contest-work-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0330-contest-work-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0330-contest-work-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0331-organization-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0331-organization-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0331-organization-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0331-organization-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0331-organization-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/0333-user-work-uuid.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/0333-user-work-uuid.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/fix/0333-user-work-uuid.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/fix/0333-user-work-uuid.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/fix/0333-user-work-uuid.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/fix/107-user-role-seeder-ko.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/fix/107-user-role-seeder-ko.md` | Link to ./0107-user-role-seeder-ko.md: there is no page at "fix/0107-user-role-seeder-ko". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/functionality-index.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/functionality-index.md` | Link to dev/README.md: there is no page at "dev/README". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/functionality-index.md` | Link to dev/functionality-index.md: there is no page at "dev/functionality-index". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/man/admins.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/man/build-a-contest.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/man/database.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/man/database.md` | Link to ../dev/man/dbdoc.md: there is no page at "dev/man/dbdoc". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/man/dbdoc.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-cache: there is no such anchor on this page. Use #tabella-cache. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-cache_locks: there is no such anchor on this page. Use #tabella-cache-locks. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_awards: there is no such anchor on this page. Use #tabella-contest-awards. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_juries: there is no such anchor on this page. Use #tabella-contest-juries. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_participants: there is no such anchor on this page. Use #tabella-contest-participants. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_patronages: there is no such anchor on this page. Use #tabella-contest-patronages. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_sections: there is no such anchor on this page. Use #tabella-contest-sections. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_votes: there is no such anchor on this page. Use #tabella-contest-votes. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_waitings: there is no such anchor on this page. Use #tabella-contest-waitings. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contest_works: there is no such anchor on this page. Use #tabella-contest-works. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contests: there is no such anchor on this page. Use #tabella-contests. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-contests_vote_rule_sets: there is no such anchor on this page. Use #tabella-contests-vote-rule-sets. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-countries: there is no such anchor on this page. Use #tabella-countries. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-failed_jobs: there is no such anchor on this page. Use #tabella-failed-jobs. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-federation_mores: there is no such anchor on this page. Use #tabella-federation-mores. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-federation_mores_referenced_tables: there is no such anchor on this page. Use #tabella-federation-mores-referenced-tables. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-federation_sections: there is no such anchor on this page. Use #tabella-federation-sections. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-federations: there is no such anchor on this page. Use #tabella-federations. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-job_batches: there is no such anchor on this page. Use #tabella-job-batches. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-jobs: there is no such anchor on this page. Use #tabella-jobs. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-lang_lists: there is no such anchor on this page. Use #tabella-lang-lists. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-migrations: there is no such anchor on this page. Use #tabella-migrations. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-organizations: there is no such anchor on this page. Use #tabella-organizations. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-password_reset_tokens: there is no such anchor on this page. Use #tabella-password-reset-tokens. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-personal_access_tokens: there is no such anchor on this page. Use #tabella-personal-access-tokens. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-sessions: there is no such anchor on this page. Use #tabella-sessions. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-timezones_region_sets: there is no such anchor on this page. Use #tabella-timezones-region-sets. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-timezones: there is no such anchor on this page. Use #tabella-timezones. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_contact_mores: there is no such anchor on this page. Use #tabella-user-contact-mores. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_contacts: there is no such anchor on this page. Use #tabella-user-contacts. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_roles: there is no such anchor on this page. Use #tabella-user-roles. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_roles_context_sets: there is no such anchor on this page. Use #tabella-user-roles-context-sets. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_roles_role_contexts: there is no such anchor on this page. Use #tabella-user-roles-role-contexts. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_roles_role_sets: there is no such anchor on this page. Use #tabella-user-roles-role-sets. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_work_mores: there is no such anchor on this page. Use #tabella-user-work-mores. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_work_validations: there is no such anchor on this page. Use #tabella-user-work-validations. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-user_works: there is no such anchor on this page. Use #tabella-user-works. |
| warning | `links.broken` | `dev/man/dbdoc.md` | Link to #-tabella-users: there is no such anchor on this page. Use #tabella-users. |
| warning | `frontmatter.description.missing` | `dev/man/federations.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/man/index.md` | Link to ../dev/man/users.md: there is no page at "dev/man/users". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/man/index.md` | Link to admins.md: there is no page at "admins". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/man/index.md` | Link to federations.md: there is no page at "federations". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/man/index.md` | Link to organizations.md: there is no page at "organizations". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/man/index.md` | Link to build-a-contest.md: there is no page at "build-a-contest". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/man/index.md` | Link to run-a-contest.md: there is no page at "run-a-contest". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/man/index.md` | Link to jury-works.md: there is no page at "jury-works". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/man/jury-works.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/man/organizations.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/man/run-a-contest.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `frontmatter.description.missing` | `dev/overview.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/overview.md` | Link to dev/wiki/abcde-method.md: there is no page at "dev/wiki/abcde-method". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/overview.md` | Link to dev/feat/0100-agreements.md: there is no page at "dev/feat/0100-agreements". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/overview.md` | Link to dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/refactor/0089-regions-lookup-table.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/refactor/0089-regions-lookup-table.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0089-regions-lookup-table.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/refactor/0129-user-works.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/refactor/0129-user-works.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0129-user-works.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/refactor/0133-federation-section-fields.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/refactor/0133-federation-section-fields.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0133-federation-section-fields.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/refactor/0140-big-rebuild.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/refactor/0140-big-rebuild.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0140-big-rebuild.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/refactor/0239-contest-patronage.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to #%EF%B8%8F-modifiche-al-database-e-naming-convention: there is no such anchor on this page. Use #modifiche-al-database-e-naming-convention. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to #-file-rinominati-e-modificati: there is no such anchor on this page. Use #file-rinominati-e-modificati. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to #-test-e-verifiche: there is no such anchor on this page. Use #test-e-verifiche. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/refactor/0352-user-contact-whatsapp.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to ../dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to ../dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to #-modifiche-applicative: there is no such anchor on this page. Use #modifiche-applicative. |
| warning | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/refactor/89-regions-lookup-table.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/refactor/89-regions-lookup-table.md` | Link to ./0089-regions-lookup-table.md: there is no page at "refactor/0089-regions-lookup-table". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/state-of-art.md` | Link to dev/state-of-art.md: there is no page at "dev/state-of-art". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/state-of-art.md` | Link to dev/template.md: there is no page at "dev/template". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/template.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/template.md` | Link to #-logica-tecnica: there is no such anchor on this page. Use #logica-tecnica. |
| warning | `links.broken` | `dev/template.md` | Link to #%EF%B8%8F-modifiche-al-database: there is no such anchor on this page. Use #modifiche-al-database. |
| warning | `links.broken` | `dev/template.md` | Link to #%EF%B8%8F-pre-merge-check: there is no such anchor on this page. Use #pre-merge-check. |
| warning | `links.broken` | `dev/template.md` | Link to #-note-per-il-deploy: there is no such anchor on this page. Use #note-per-il-deploy. |
| warning | `frontmatter.description.missing` | `dev/welcome.aboard.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| warning | `links.broken` | `dev/welcome.aboard.md` | Link to /resources/docs/dev/welcome.aboard.md: there is no page at "resources/docs/dev/welcome.aboard". Fix the link, or write the page it points to. |
| warning | `links.broken` | `dev/welcome.aboard.md` | Link to /resources/docs/1.0/welcome.aboard.md: there is no page at "resources/docs/1.0/welcome.aboard". Fix the link, or write the page it points to. |
| warning | `frontmatter.description.missing` | `dev/wiki/abcde-method.md` | Pages without a description get weaker llms.txt entries and search snippets. Add a one-sentence description to the frontmatter. |
| error | `links.broken` | `1.0/contest_design/calendar/modify.md` | Link to ../contest/weblink.md: there is no page contest_design/contest/weblink in version 1.0. |
| error | `links.broken` | `1.0/contest_design/contest/add.md` | Link to weblink.md: there is no page contest_design/contest/weblink in version 1.0. |
| error | `links.broken` | `1.0/contest_design/contest/detail.md` | Link to weblink.md: there is no page contest_design/contest/weblink in version 1.0. |
| error | `links.broken` | `1.0/contest_design/contest/modify.md` | Link to weblink.md: there is no page contest_design/contest/weblink in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/add1.md` | Link to modify1.md: there is no page contest_design/section/modify1 in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/add1.md` | Link to modify2.md: there is no page contest_design/section/modify2 in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/add2.md` | Link to modify1.md: there is no page contest_design/section/modify1 in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/add2.md` | Link to modify2.md: there is no page contest_design/section/modify2 in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify1.md: there is no page contest_design/section/modify1 in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify2.md: there is no page contest_design/section/modify2 in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify1.md: there is no page contest_design/section/modify1 in version 1.0. |
| error | `links.broken` | `1.0/contest_design/section/listed.md` | Link to modify2.md: there is no page contest_design/section/modify2 in version 1.0. |
| error | `links.broken` | `1.0/overview.md` | Link to index.md: there is no page index in version 1.0. |
| error | `links.broken` | `dev/docs/0141-user-login.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/docs/0141-user-login.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/docs/0159-user-work-add.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/docs/0159-user-work-add.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/docs/0160-user-work-listed1.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/docs/0160-user-work-listed1.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0020-add-me-to-org.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0020-add-me-to-org.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0093-language-translation.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0093-language-translation.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0111-user-role-review.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0111-user-role-review.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0114-federation-delete-policy.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0114-federation-delete-policy.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/index.md: there is no page dev in version dev. |
| error | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/docs/0185-federation-add.md: there is no page dev/docs/0185-federation-add in version dev. |
| error | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/docs/0184-federation-read.md: there is no page dev/docs/0184-federation-read in version dev. |
| error | `links.broken` | `dev/feat/0115-federation-delete.md` | Link to ../dev/docs/0186-federation-update.md: there is no page dev/docs/0186-federation-update in version dev. |
| error | `links.broken` | `dev/feat/0116-federation-more-crud.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0116-federation-more-crud.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0128-breeze-remove.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0128-breeze-remove.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0148-federations.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0148-federations.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0161-user-work-listed2.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0161-user-work-listed2.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0162-user-work-remove.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0162-user-work-remove.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0164-user-work-modify.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0164-user-work-modify.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0167-user-work-wnh.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0167-user-work-wnh.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0200-federation-list.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0200-federation-list.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/feat/0208-contest-patronage.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/feat/0208-contest-patronage.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/fix/0107-user-role-seeder-ko.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/fix/0107-user-role-seeder-ko.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/fix/0142-register-test.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/fix/0142-register-test.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/fix/0150-referenced.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/fix/0150-referenced.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/fix/0219-federation-section-mono.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/fix/0219-federation-section-mono.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/fix/0235-federation-mores-referenced-set-typo.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/fix/0235-federation-mores-referenced-set-typo.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/fix/0253-organization-update-not-for-all.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/functionality-index.md` | Link to dev/README.md: there is no page dev/README in version dev. |
| error | `links.broken` | `dev/functionality-index.md` | Link to dev/functionality-index.md: there is no page dev/functionality-index in version dev. |
| error | `links.broken` | `dev/man/database.md` | Link to ../dev/man/dbdoc.md: there is no page dev/man/dbdoc in version dev. |
| error | `links.broken` | `dev/man/index.md` | Link to ../dev/man/users.md: there is no page dev/man/users in version dev. |
| error | `links.broken` | `dev/overview.md` | Link to dev/wiki/abcde-method.md: there is no page dev/wiki/abcde-method in version dev. |
| error | `links.broken` | `dev/overview.md` | Link to dev/feat/0100-agreements.md: there is no page dev/feat/0100-agreements in version dev. |
| error | `links.broken` | `dev/overview.md` | Link to dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/refactor/0089-regions-lookup-table.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/refactor/0089-regions-lookup-table.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/refactor/0129-user-works.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/refactor/0129-user-works.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/refactor/0133-federation-section-fields.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/refactor/0133-federation-section-fields.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/refactor/0140-big-rebuild.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/refactor/0140-big-rebuild.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/refactor/0239-contest-patronage.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to ../dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/refactor/0352-user-contact-whatsapp.md` | Link to ../dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/state-of-art.md` | Link to dev/state-of-art.md: there is no page dev/state-of-art in version dev. |
| error | `links.broken` | `dev/state-of-art.md` | Link to dev/template.md: there is no page dev/template in version dev. |
| error | `links.broken` | `dev/welcome.aboard.md` | Link to /resources/docs/dev/welcome.aboard.md: there is no page resources/docs/dev/welcome.aboard in version dev. |
| error | `links.broken` | `dev/welcome.aboard.md` | Link to /resources/docs/1.0/welcome.aboard.md: there is no page resources/docs/1.0/welcome.aboard in version dev. |
