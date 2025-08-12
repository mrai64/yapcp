<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login </title>
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
						<h4>Login registration
							<a href="#" class="btn btn-info btn-sm float-end">[Term n Condition]</a>
            </h4>
					</div>
					<div class="card-body">	
           <form action="{{ route('login') }}" method="post">
            @csrf
            
            <div class="mb-3">
              <label for="email" class="form-label">Email</label> 
              <input type="email" class="form-control" id="email" name="email" value="{{ old( 'email') }}" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>

          </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('partials.html_footer')
	</body>
</html>