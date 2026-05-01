# 🛡️ Checklist Controllo Accessi (11-04-2026 17:58)

> Automatically generated doc.  
> Questo file è generato automaticamente. Usalo per tracciare la messa in sicurezza delle rotte.

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `//` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `\Illuminate\Routing\ViewController` |
| **Middleware** | `web` |

### Verifiche di Sicurezza
- [x] **Target Accesso:** `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [x] Test di accesso (Autorizzato/Negato)

---

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/credits` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `\Illuminate\Routing\ViewController` |
| **Middleware** | `web` |

### Verifiche di Sicurezza
- [x] **Target Accesso:** `[x] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `verification.verify`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/verify-email/{id}/{hash}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Http\Controllers\Auth\VerifyEmailController` |
| **Middleware** | `web, auth, signed, throttle:6,1` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation.list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/federation/listed` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Http\Controllers\FederationController@index` |
| **Middleware** | `web` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation-section.list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/federation/section/list/{federation}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Federation\Section\Listed` |
| **Middleware** | `web` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization.list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/listed` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Listed` |
| **Middleware** | `web` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user.profile`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/profile` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `\Illuminate\Routing\ViewController` |
| **Middleware** | `web, auth` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user.dashboard`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/dashboard` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `\Illuminate\Routing\ViewController` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-contact-listed`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contact/listed` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Contact\Listed` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-contact-modify`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contact/modify` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Contact\Modify1YouAre` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-contact-modify1`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contact/modify1/{uid?}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Contact\Modify1YouAre` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-contact-modify2`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contact/modify2/{uid?}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Contact\Modify2PostAddress` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-contact-modify3`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contact/modify3/{uid?}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Contact\Modify3Phones` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-contact-modify4`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contact/modify4/{uid?}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Contact\Modify4Socials` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-contact-modify5`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contact/modify5/{fid}/{uid?}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Contact\Modify5Feds` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation.add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/admin/federation/add` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Http\Controllers\FederationController@create` |
| **Middleware** | `web, auth, verified, can:create,App\Models\Federation` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation.store`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/admin/federation/store` |
| **Metodo** | `POST` |
| **Controller** | `App\Http\Controllers\FederationController@store` |
| **Middleware** | `web, auth, verified, can:create,App\Models\Federation` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation.modify`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/admin/federation/modify/{federation}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Federation\Modify` |
| **Middleware** | `web, auth, verified, can:update,federation` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation.delete`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/admin/federation/remove/{federation}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Federation\Remove` |
| **Middleware** | `web, auth, verified, can:delete,federation` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/admin/federation/remove/{federation}` |
| **Metodo** | `DELETE` |
| **Controller** | `App\Livewire\Federation\Remove` |
| **Middleware** | `web, auth, livewire, can:delete,federation` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation-section.add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/admin/federation/section/add/{federation}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Federation\Section\Add` |
| **Middleware** | `web, auth, verified, can:create,App\Models\FederationSection` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation-section.modify`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/admin/federation/section/modify/{federation-section}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Federation\Section\Modify` |
| **Middleware** | `web, auth, verified, can:update,App\Models\FederationSection` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `federation-section.delete`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/federation/section/remove/{federation-section}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Federation\Section\Remove` |
| **Middleware** | `web, auth, verified, can:delete,App\Models\FederationSection` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/federation/section/remove/{federation-section}` |
| **Metodo** | `DELETE` |
| **Controller** | `App\Livewire\Federation\Section\Remove` |
| **Middleware** | `web, auth, verified, can:delete,App\Models\FederationSection` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization.add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/add` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization.modify`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/modify/{organization}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Modify` |
| **Middleware** | `web, auth, verified, can:update,organization` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization.delete`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/remove/{organization}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Remove` |
| **Middleware** | `web, auth, verified, can:delete,organization` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/remove/{organization}` |
| **Metodo** | `DELETE` |
| **Controller** | `App\Livewire\Organization\Remove` |
| **Middleware** | `web, auth, verified, can:delete,organization` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization.dashboard`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/dashboard/{organization}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Dashboard` |
| **Middleware** | `web, auth, verified, can:update,organization` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `user-role-list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/dashboard/role` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Role\Listed` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `add-user-role-federation`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/dashboard/role/federation/add` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Role\Federation\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `add-user-role-organization`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/dashboard/role/organization/add` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Role\Organization\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `photo-box-list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/work/list` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Work\Listed` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `photo-box-add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/work/add` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Work\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `photo-box-modify`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/work/modify/{wid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Work\Modify` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `delete-photo-box`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/work/remove/{wid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\User\Work\Remove` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/work/remove/{wid}` |
| **Metodo** | `DELETE` |
| **Controller** | `App\Livewire\User\Work\Remove` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/listed` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Listed` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/add/{oid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `modify-contest`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/modify/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Modify` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-section-add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/section/add/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Section\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `modify-contest-section`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/section/modify/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Section\Modify` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `remove-contest-section`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/section/remove/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Section\Remove` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/section/remove/{sid}` |
| **Metodo** | `DELETE` |
| **Controller** | `App\Livewire\Contest\Section\Remove` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-jury-add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/jury/add/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Jury\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-award-add`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/award/add/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Award\Add` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `participate-contest`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contest/subscribe/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Subscribe` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `add-work-contest`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contest/subscribe/{cid}/work/{wid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Subscribe` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `remove-work-contest`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/user/contest/subscribe/remove/{pid}` |
| **Metodo** | `DELETE` |
| **Controller** | `App\Livewire\Contest\Subscribe\Remove` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-live-dashboard`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\ContestPanel` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `public-participant-list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/participants/listed/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Participants\Listed` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `modify-participant-list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/participants/modify/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Contest\Participants\Modify` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-contest-list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/pre-jury/section-list/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\PreJury\SectionListed` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-contest-section-list`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/pre-jury/section-review/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\PreJury\SectionReview` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-contest-warn-email`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/pre-jury/warn/{wid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\PreJury\WarnEmail` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-contest-pass-next`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/pre-jury/pass/{wid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\PreJury\PassNext` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-jury-board`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/juror/section-board/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Juror\SectionBoard` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-jury-vote`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/juror/vote/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Juror\Vote` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `Nessun Nome`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/juror/vote/{sid}` |
| **Metodo** | `POST` |
| **Controller** | `App\Livewire\Juror\Vote` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-jury-vote-mod`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/juror/review-vote/{vid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Juror\ReviewVote` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-before-final-jury`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/admit/before-final/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Admit\BeforeFinal` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-contest-admit`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/contest/admit/set-admit/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Admit\SetAdmit` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-award-section-assign`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/award-assign/section/{sid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Award\SectionAssign` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-award-contest-assign`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/award-assign/contest/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Award\ContestAssign` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-award-minute-draft`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/award-assign/jury-minute/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Http\Controllers\Contest\JuryMinuteDraft@buildMinute` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `organization-reports-works-participant`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/organization/reports/works-participant/{cid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Livewire\Organization\Reports\WorksParticipant` |
| **Middleware** | `web` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-report-fiaf1`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/export/FIAF1/{cid}/{fid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Http\Controllers\Contest\Report\Fiaf1ParticipantsController@exportFiaf1Participants` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

## Route: `contest-report-fiaf2`
| Proprietà | Dettaglio |
| :--- | :--- |
| **URI** | `/contest/export/FIAF2/{cid}/{fid}` |
| **Metodo** | `GET, HEAD` |
| **Controller** | `App\Http\Controllers\Contest\Report\Fiaf2WorksController@exportFiaf2Works` |
| **Middleware** | `web, auth, verified` |

### Verifiche di Sicurezza
- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` 
- [ ] Middleware corretti applicati
- [ ] Test di accesso (Autorizzato/Negato)

---

