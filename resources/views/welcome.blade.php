<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.html_meta')
  <title>🇮🇹 Benvenuti 🇬🇧 Welcome to yapcp</title>
</head>
<body>
  <h1><a href="/yapcp" target="_blank" rel="noopener noreferrer">❓ yapcp ?</a></h1>
  <br>
  <a
    name=""
    id=""
    class="btn btn-primary"
    href="{{ route('addUserForm') }}"
    role="button"
    >Register as new user' platform</a
  >
  <br>
  <h2>Sono nuovo e Partecipo a concorso</h2>
  <h2>Sono registrato e Partecipo a concorso</h2>
  <h2>Nuovo concorso</h2>
  <h2>Gestione concorso</h2>
  <h2>Controllo concorso</h2>
  @include('partials.html_footer')
</body>
</html>