<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow p-4" style="width: 350px;">
            <h3 class="text-center mb-3">Register</h3>
			<form id="register-form">
				<div class="mb-3">
				    <label for="username" class="form-label">Usename</label>
					<input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
				</div>
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
				</div>
				<div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
				<button type="submit" class="btn btn-primary w-100">Register</button>
			</form>
			<p class="mt-3 text-center">
                 have an account? <a href="<?= base_url('auth/login_view') ?>">Login</a>
            </p>

        <div id="message" class="alert mt-3 d-none"></div>
	</div>
</div>


<script>
document.getElementById("register-form").addEventListener("submit", function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    
    fetch("<?= base_url('auth/register') ?>", {
        method: "POST",
        body: formData
    }).then(response => response.json())
      .then(data => alert(date.message),
	  		setTimeout(() => {
                    window.location.href = "<?= base_url('auth/login_view') ?>"
                }, 1500)
	);
});
</script>
</body>
</html>
