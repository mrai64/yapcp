<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.html_meta')
  <title>🇮🇹 Benvenuti 🇬🇧 Welcome to yapcp</title>
</head>
<body>
  <div class="container pt-5">
    <div class="row">
      <div class="col-12">
        <a href="/yapcp" target="_blank" class="fs-3" rel="noopener noreferrer"> yapcp ?</a>
        @auth 
        <form action="{{ route('logout') }}" method="post" class="m-0">
          @csrf 
          <button
            type="submit"
            class="btn btn-secondary float-end"
            >Logout
          </button>
        </form>
        @else
        <a href="{{ route('loginForm') }}" class="btn btn-secondary float-end">Login</a>
        @endauth
      </div>
    </div>
    <div class="row">
      <div class="col-2">&nbsp;</div>
      <div class="col-7">
        <h4>New to platform?</h4>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="{{ route('addUserForm') }}"
        role="button"
        >Register me</a>
        <hr>
        <h4>And for registered users</h4>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="#"
        role="button"
        >Check Open Salons to participate</a>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="#"
        role="button"
        >Check the status of the contests I participate in</a>
        <hr>
        <h4>And for Salon organizer</h4>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="#"
        role="button"
        >Build a new Salon</a>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="#"
        role="button"
        >Manage our Salon</a>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="#"
        role="button"
        >Jury work</a>
        <hr>
        <h4>And for Nat/Intl Photographic Organization</h4>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="#"
        role="button"
        >Contact us</a>
        <a
        name=""
        id=""
        class="btn btn-primary"
        href="#"
        role="button"
        >Check Salons under your patronage</a>
      </div>
    </div>
  </div>
  @include('partials.html_footer')
</body>
</html>