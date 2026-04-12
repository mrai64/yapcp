# 🛡️ Checklist Controllo Accessi (11-04-2026 22:16)

> Automatically generated doc.  
> Questo file è generato automaticamente. Usalo per tracciare la messa in sicurezza delle rotte.


| ✅ | Uri | Name | Metodi | Middleware | Gruppo |
| :--- | :--- | :--- | :--- | :--- | :--- |
| [x] | `/` | `Nessun Nome` | `GET, HEAD` | `web` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/admin/federation/add` | `federation.add` | `GET, HEAD` | `web, auth, verified, can:create,App\Models\Federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [x] | `/admin/federation/modify/{federation}` | `federation.modify` | `GET, HEAD` | `web, auth, verified, can:update,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [x] | `/admin/federation/remove/{federation}` | `federation.delete` | `GET, HEAD` | `web, auth, verified, can:delete,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [x] | `/admin/federation/remove/{federation}` | `Nessun Nome` | `DELETE` | `web, auth, livewire, can:delete,federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [x] | `/admin/federation/section/add/{federation}` | `federation-section.add` | `GET, HEAD` | `web, auth, verified, can:create,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [x] | `/admin/federation/section/modify/{federation-section}` | `federation-section.modify` | `GET, HEAD` | `web, auth, verified, can:update,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [x] | `/admin/federation/store` | `federation.store` | `POST` | `web, auth, verified, can:create,App\Models\Federation` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [ ] | `/contest/add/{oid}` | `contest-add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/award/add/{cid}` | `contest-award-add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/export/FIAF1/{cid}/{fid}` | `contest-report-fiaf1` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/export/FIAF2/{cid}/{fid}` | `contest-report-fiaf2` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/jury/add/{sid}` | `contest-jury-add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/listed` | `contest-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/modify/{cid}` | `modify-contest` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/section/add/{cid}` | `contest-section-add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/section/modify/{sid}` | `modify-contest-section` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/section/remove/{sid}` | `remove-contest-section` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/contest/section/remove/{sid}` | `Nessun Nome` | `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/credits` | `Nessun Nome` | `GET, HEAD` | `web` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/user/dashboard/role` | `user-role-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[x] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/user/dashboard/role/federation/add` | `add-user-role-federation` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[x] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/user/dashboard/role/organization/add` | `add-user-role-organization` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[x] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/federation/listed` | `federation.list` | `GET, HEAD` | `web` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/federation/section/list/{federation}` | `federation-section.list` | `GET, HEAD` | `web` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/federation/section/remove/{federation-section}` | `federation-section.delete` | `GET, HEAD` | `web, auth, verified, can:delete,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [x] | `/federation/section/remove/{federation-section}` | `Nessun Nome` | `DELETE` | `web, auth, verified, can:delete,App\Models\FederationSection` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[x] Admin` |
| [ ] | `/juror/review-vote/{vid}` | `contest-jury-vote-mod` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/juror/section-board/{sid}` | `contest-jury-board` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/juror/vote/{sid}` | `contest-jury-vote` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/juror/vote/{sid}` | `Nessun Nome` | `POST` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/add` | `organization.add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/award-assign/contest/{cid}` | `organization-award-contest-assign` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/award-assign/jury-minute/{cid}` | `organization-award-minute-draft` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/award-assign/section/{sid}` | `organization-award-section-assign` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/admit/before-final/{sid}` | `contest-before-final-jury` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/admit/set-admit/{sid}` | `organization-contest-admit` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/participants/listed/{cid}` | `public-participant-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/participants/modify/{cid}` | `modify-participant-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/pass/{wid}` | `organization-contest-pass-next` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/section-list/{cid}` | `organization-contest-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/section-review/{sid}` | `organization-contest-section-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/pre-jury/warn/{wid}` | `organization-contest-warn-email` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/contest/{cid}` | `contest-live-dashboard` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/dashboard/{organization}` | `organization.dashboard` | `GET, HEAD` | `web, auth, verified, can:update,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/organization/listed` | `organization.list` | `GET, HEAD` | `web` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/modify/{organization}` | `organization.modify` | `GET, HEAD` | `web, auth, verified, can:update,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/remove/{organization}` | `organization.delete` | `GET, HEAD` | `web, auth, verified, can:delete,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/remove/{organization}` | `Nessun Nome` | `DELETE` | `web, auth, verified, can:delete,organization` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/organization/reports/works-participant/{cid}` | `organization-reports-works-participant` | `GET, HEAD` | `web` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/listed` | `user-contact-listed` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify` | `user-contact-modify` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify1/{uid?}` | `user-contact-modify1` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify2/{uid?}` | `user-contact-modify2` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify3/{uid?}` | `user-contact-modify3` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify4/{uid?}` | `user-contact-modify4` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contact/modify5/{fid}/{uid?}` | `user-contact-modify5` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contest/subscribe/remove/{pid}` | `remove-work-contest` | `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contest/subscribe/{cid}` | `participate-contest` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/contest/subscribe/{cid}/work/{wid}` | `add-work-contest` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/user/dashboard` | `user.dashboard` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[x] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/user/profile` | `user.profile` | `GET, HEAD` | `web, auth` | `[ ] Guest` `[x] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/add` | `photo-box-add` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/list` | `photo-box-list` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/modify/{wid}` | `photo-box-modify` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/remove/{wid}` | `delete-photo-box` | `GET, HEAD` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [ ] | `/user/work/remove/{wid}` | `Nessun Nome` | `DELETE` | `web, auth, verified` | `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |
| [x] | `/verify-email/{id}/{hash}` | `verification.verify` | `GET, HEAD` | `web, auth, signed, throttle:6,1` | `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |

---
