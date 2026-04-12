# 🛡️ Checklist Controllo Accessi (11-04-2026 21:30)

> Automatically generated doc.  
> Questo file è generato automaticamente. Usalo per tracciare la messa in sicurezza delle rotte.

| ✅ | Uri | Name | Metodi | Middleware | Gruppo |
| :--- | :--- | :--- | :--- | :--- | :--- |
| [x] | `/` |`Nessun Nome` |  `GET, HEAD` | `web` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [x] | `credits` |`Nessun Nome` |  `GET, HEAD` | `web` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [x] | `verify-email/{id}/{hash}` |`verification.verify` |  `GET, HEAD` | `web, auth, signed, throttle:6,1` | `[x] Guest` `[x] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `federation/listed` |`federation.list` |  `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `federation/section/list/{federation}` |`federation-section.list` |  `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/listed` |`organization.list` |  `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/profile` |`user.profile` |  `GET, HEAD` | `web, auth` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/dashboard` |`user.dashboard` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contact/listed` |`user-contact-listed` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contact/modify` |`user-contact-modify` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contact/modify1/{uid?}` |`user-contact-modify1` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contact/modify2/{uid?}` |`user-contact-modify2` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contact/modify3/{uid?}` |`user-contact-modify3` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contact/modify4/{uid?}` |`user-contact-modify4` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contact/modify5/{fid}/{uid?}` |`user-contact-modify5` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `admin/federation/add` |`federation.add` |  `GET, HEAD` | `web, auth, verified, can:create,App\Models\Federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `admin/federation/store` |`federation.store` |  `POST` | `web, auth, verified, can:create,App\Models\Federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `admin/federation/modify/{federation}` |`federation.modify` |  `GET, HEAD` | `web, auth, verified, can:update,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `admin/federation/remove/{federation}` |`federation.delete` |  `GET, HEAD` | `web, auth, verified, can:delete,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `admin/federation/remove/{federation}` |`Nessun Nome` |  `DELETE` | `web, auth, livewire, can:delete,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `admin/federation/section/add/{federation}` |`federation-section.add` |  `GET, HEAD` | `web, auth, verified, can:create,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `admin/federation/section/modify/{federation-section}` |`federation-section.modify` |  `GET, HEAD` | `web, auth, verified, can:update,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `federation/section/remove/{federation-section}` |`federation-section.delete` |  `GET, HEAD` | `web, auth, verified, can:delete,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `federation/section/remove/{federation-section}` |`Nessun Nome` |  `DELETE` | `web, auth, verified, can:delete,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/add` |`organization.add` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/modify/{organization}` |`organization.modify` |  `GET, HEAD` | `web, auth, verified, can:update,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/remove/{organization}` |`organization.delete` |  `GET, HEAD` | `web, auth, verified, can:delete,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/remove/{organization}` |`Nessun Nome` |  `DELETE` | `web, auth, verified, can:delete,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/dashboard/{organization}` |`organization.dashboard` |  `GET, HEAD` | `web, auth, verified, can:update,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `dashboard/role` |`user-role-list` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `dashboard/role/federation/add` |`add-user-role-federation` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `dashboard/role/organization/add` |`add-user-role-organization` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/work/list` |`photo-box-list` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/work/add` |`photo-box-add` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/work/modify/{wid}` |`photo-box-modify` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/work/remove/{wid}` |`delete-photo-box` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/work/remove/{wid}` |`Nessun Nome` |  `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/listed` |`contest-list` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/add/{oid}` |`contest-add` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/modify/{cid}` |`modify-contest` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/section/add/{cid}` |`contest-section-add` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/section/modify/{sid}` |`modify-contest-section` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/section/remove/{sid}` |`remove-contest-section` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/section/remove/{sid}` |`Nessun Nome` |  `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/jury/add/{sid}` |`contest-jury-add` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/award/add/{cid}` |`contest-award-add` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contest/subscribe/{cid}` |`participate-contest` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contest/subscribe/{cid}/work/{wid}` |`add-work-contest` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `user/contest/subscribe/remove/{pid}` |`remove-work-contest` |  `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/{cid}` |`contest-live-dashboard` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/participants/listed/{cid}` |`public-participant-list` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/participants/modify/{cid}` |`modify-participant-list` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/pre-jury/section-list/{cid}` |`organization-contest-list` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/pre-jury/section-review/{sid}` |`organization-contest-section-list` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/pre-jury/warn/{wid}` |`organization-contest-warn-email` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/pre-jury/pass/{wid}` |`organization-contest-pass-next` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `juror/section-board/{sid}` |`contest-jury-board` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `juror/vote/{sid}` |`contest-jury-vote` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `juror/vote/{sid}` |`Nessun Nome` |  `POST` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `juror/review-vote/{vid}` |`contest-jury-vote-mod` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/admit/before-final/{sid}` |`contest-before-final-jury` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/contest/admit/set-admit/{sid}` |`organization-contest-admit` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/award-assign/section/{sid}` |`organization-award-section-assign` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/award-assign/contest/{cid}` |`organization-award-contest-assign` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/award-assign/jury-minute/{cid}` |`organization-award-minute-draft` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `organization/reports/works-participant/{cid}` |`organization-reports-works-participant` |  `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/export/FIAF1/{cid}/{fid}` |`contest-report-fiaf1` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
| [ ] | `contest/export/FIAF2/{cid}/{fid}` |`contest-report-fiaf2` |  `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro`  |
