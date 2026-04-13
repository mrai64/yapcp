# 🛡️ Checklist Controllo Accessi (13-04-2026 14:20)

> Automatically generated doc.  
> Questo file è generato automaticamente. Usalo per tracciare la messa in sicurezza delle rotte.


| ✅ | Uri | Name | Metodi | Middleware | Gruppo |
| :--- | :--- | :--- | :--- | :--- | :--- |
| [ ] | `//` | `welcome.aboard` | `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/add` | `federation.add` | `GET, HEAD` | `web, auth, verified, can:create,App\Models\Federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/modify/{federation}` | `federation.modify` | `GET, HEAD` | `web, auth, verified, can:update,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/remove/{federation}` | `federation.delete` | `GET, HEAD` | `web, auth, verified, can:delete,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/remove/{federation}` | `Nessun Nome` | `DELETE` | `web, auth, livewire, can:delete,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/section/add/{federation}` | `federation-section.add` | `GET, HEAD` | `web, auth, verified, can:create,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/section/modify/{federation-section}` | `federation-section.modify` | `GET, HEAD` | `web, auth, verified, can:update,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/section/remove/{federation-section}` | `federation-section.delete` | `GET, HEAD` | `web, auth, verified, can:delete,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/section/remove/{federation-section}` | `Nessun Nome` | `DELETE` | `web, auth, verified, can:delete,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/admin/federation/store` | `federation.store` | `POST` | `web, auth, verified, can:create,App\Models\Federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/export/FIAF1/{cid}/{fid}` | `contest-report-fiaf1` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/export/FIAF2/{cid}/{fid}` | `contest-report-fiaf2` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/listed` | `contest.list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/{cid}` | `contest.dashboard` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/credits` | `credits.notice` | `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/federation/listed` | `federation.list` | `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/federation/section/list/{federation}` | `federation-section.list` | `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/juror/review-vote/{vid}` | `contest-jury-vote-mod` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/juror/section-board/{sid}` | `contest-jury-board` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/juror/vote/{sid}` | `contest-jury-vote` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/juror/vote/{sid}` | `Nessun Nome` | `POST` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/award-assign/contest/{cid}` | `organization-award-contest-assign` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/award-assign/jury-minute/{cid}` | `organization-award-minute-draft` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/award-assign/section/{sid}` | `organization-award-section-assign` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/add/{oid}` | `organization.contest.add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/admit/before-final/{sid}` | `contest-before-final-jury` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/admit/set-admit/{sid}` | `organization-contest-admit` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/award/add/{cid}` | `organization.contest-award.add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/jury/add/{sid}` | `organization.contest-jury.add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/modify/{cid}` | `organization.contest.modify` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/participants/listed/{cid}` | `public-participant-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/participants/modify/{cid}` | `modify-participant-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/pass/{wid}` | `organization-contest-pass-next` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/section-list/{cid}` | `organization-contest.list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/section-review/{sid}` | `organization-contest-section-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/warn/{wid}` | `organization-contest-warn-email` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/section/add/{cid}` | `organization.contest-section.add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/section/modify/{sid}` | `organization.contest-section.modify` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/section/remove/{sid}` | `organization.contest-section.remove` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/section/remove/{sid}` | `Nessun Nome` | `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/dashboard/{organization}` | `organization.dashboard` | `GET, HEAD` | `web, auth, verified, can:update,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/listed` | `organization.list` | `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/reports/works-participant/{cid}` | `organization-reports-works-participant` | `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/listed` | `user-contact.list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify1/{uid?}` | `user-contact.modify1` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify2/{uid?}` | `user-contact.modify2` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify3/{uid?}` | `user-contact.modify3` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify4/{uid?}` | `user-contact.modify4` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify5/{fid}/{uid?}` | `user-contact.modify5` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contest/subscribe/remove/{pid}` | `user.contest.remove-work` | `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contest/subscribe/{cid}` | `user.contest.participate` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contest/subscribe/{cid}/work/{wid}` | `user.contest.add-work` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/dashboard` | `user.dashboard` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/dashboard/role` | `user-role.list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/dashboard/role/federation/add` | `user-role.add.federation` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/dashboard/role/organization/add` | `user-role.add.organization` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/organization/add` | `user.organization.add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/organization/modify/{organization}` | `user.organization.modify` | `GET, HEAD` | `web, auth, verified, can:update,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/organization/remove/{organization}` | `user.organization.delete` | `GET, HEAD` | `web, auth, verified, can:delete,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/organization/remove/{organization}` | `Nessun Nome` | `DELETE` | `web, auth, verified, can:delete,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/profile` | `user.profile` | `GET, HEAD` | `web, auth` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/add` | `photo-box-add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/list` | `photo-box-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/modify/{wid}` | `photo-box-modify` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/remove/{wid}` | `delete-photo-box` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/remove/{wid}` | `Nessun Nome` | `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/verify-email/{id}/{hash}` | `verification.verify` | `GET, HEAD` | `web, auth, signed, throttle:6,1` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
