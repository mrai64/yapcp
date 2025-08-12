<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.html_meta')
  <title>Your home page </title>
</head>
<body>
  <p>Homepage for User</p>
	<div class="container pt-5">
    <div class="row">
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
        <ul>
          <li>Name: {{ $youAre['name'] }}</li>
          <li>Assigned id: {{ $youAre['id'] }}</li>
          <li>Country code: {{ $youAre['country_iso3'] }}</li>
          <li>Last Update record: {{ $youAre['updated_at'] }}</li>
        </ul>
        <p>All ok or you wanna change something?</p>
      </div>
    </div>
  </div>
  @include('partials.html_footer')
</body>
</html>