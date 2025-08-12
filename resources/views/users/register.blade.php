<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>User registration</title>
		@include('partials.html_meta')
	</head>
	<body>
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
				<div class="card">
					<div class="card-header">
						<h4>New User registration
							<a href="#" class="btn btn-info btn-sm float-end">[Term n Condition]</a>
            </h4>
            <div class="alert alert-success" role="alert">
              Filling the form and clicking on Submit button, 
              you accept the platform'
              <a href="#" class="">[Term and Condition]</a>
              .<br />
            </div>
					</div>
					<div class="card-body">	
           <form action="{{ route('validateUserForm') }}" method="post">
            @csrf
            
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" aria-describedby="nameHelp" required>
              <small id="nameHelp" class="form-text text-muted">Use Family name, comma, First Name.</small>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label> 
              <input type="email" class="form-control" id="email" name="email" value="{{ old( 'email') }}" aria-describedby="emailHelp" required>
              <small id="emailHelp" class="form-text text-muted">As indicated in out 
                Term and condition your data are shared only under 
                your explicit permission and not to anyone.</small>
            </div>
            <div class="mb-3">
              <label for="email_confirmation" class="form-label">Email rewrite</label> 
              <input type="email" class="form-control" id="email confirmation" name="email confirmation" value="" aria-describedby="emailHelp2" required>
              <small id="emailHelp2" class="form-text text-muted">As important info we ask you to rewrite to avoid refuse.</small>
            </div>
            
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" required>
              <small id="passwordHelp" class="form-text text-muted">Password suggestion are the same: long, long, and long. 5-nonsense-words-but-you-can-remember. And use a password manager.</small>
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Password rewrite</label>
              <input type="password" class="form-control" id="password confirmation" name="password confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrati</button>

          </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('partials.html_footer')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>