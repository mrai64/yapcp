# Docs: Registrazione e login utente

> **Branch:** `docs/0141-user-login`  
> **Stato:** Chiuso
> **priorità:** A  
> **id assegnato:** 2026-07-14.01  
> **Titolo e urgenza:** (A) docs: Participant User / login and other things  
> **Project/issue link:** [#141](https://github.com/mrai64/yapcp/issues/141)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Per risolvere un debito (c'è la funzione ma non è documentata),
serve verificare la presenza e se mancano crearli, dei test per
gli utenti di registrazione alla piattaforma e login. Tecnicamente
fanno parte dello starter pack jetstream, quindi già "fatti bene".  

- AuthenticationTest
- PasswordConfirmationTest
- PasswordUpdateTest
- RegistrationTest
- SplashScreenOnTest
- UpdatePasswordTest

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- nessuna modifica prevista alla base dati già presente

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire i test  
  `./vendor/bin/pest tests/Feature/m001/i0141/`