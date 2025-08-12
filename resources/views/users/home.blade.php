<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.html_meta')
  <title>Your home page </title>
</head>
<body>
  <div class="container pt-5">
    <div class="row">
      <div class="col-12">
        <span class="fs-3">Yapcp</span>
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
      <div class="col-md-12">
        @if (session('success'))
				<div class="alert alert-success">
          {{ session('success') }}
				</div> 
				@endif
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div> 
        @endif
        <h1>{{ $youAre['name'] }} Personal data</h1>
        <p>Homepage for User</p>
        <ul>
          <li>Name: {{ $youAre['name'] }}</li>
          <li>Country code: {{ $youAre['country_iso3'] }}</li>
          <li><small>Last Update record: {{ $youAre['updated_at'] }}</small><br>
          </li>
          <li>Assigned id: {{ $youAre['id'] }}<br>
            <small>That code is only for internal use.</small>
          </li>
        </ul>
        <h2>as Participant</h2>
        <ul>
          <li>Status of Salons</li>
          <li>Apply for a Contest</li>
          <li>Works depot</li>
        </ul>
        <h2>as Organizer</h2>
        <ul>
          <li>Status of Salons</li>
          <li>New Salon</li>
        </ul>
        <h2>as Juror</h2>
        <ul>
          <li>Make your choice</li>
        </ul>
        <h2>as National/International Photo Organization</h2>
        <ul>
          <li>Salon inspection</li>
        </ul>
      </div>
    </div>
  </div>
  @include('partials.html_footer')
</body>
</html>