<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register Page</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
	<div class="row justify-content-center mt-5">
		<div class="col-lg-4">
			<div class="card">
				<div class="card-header">
					<h1 class="card-title">Register</h1>
				</div>
				<div class="card-body">
<!-- This section would typically handle server-side errors, similar to your original login page.
     For a client-side HTML example, it's omitted here. If integrating with a backend,
     you would add your error display logic here. -->
     <form action="{{ route('register') }}" method="POST">
     	@csrf
     	<div class="mb-3">
     		<label for="name" class="form-label">Name</label>
     		<input type="text" name="name" class="form-control" id="name" placeholder="Your Full Name" required>
     	</div>
     	<div class="mb-3">
     		<label for="email" class="form-label">Email address</label>
     		<input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
     	</div>
     	<div class="mb-3">
     		<label for="password" class="form-label">Password</label>
     		<input type="password" name="password" class="form-control" id="password" required>
     	</div>
     	<div class="mb-3">
     		<div class="d-grid">
     			<button class="btn btn-primary">Register</button>
     		</div>
     	</div>
     </form>
 </div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
