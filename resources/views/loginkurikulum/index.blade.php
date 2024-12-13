<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E Walas | Kurikulum</title>
    <!-- Tambahkan Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .password__field {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login">
			    <!-- Tambahin logo -->
			    <img src="images/logologin.png" alt="Logo" class="login__logo">
			    <h2>Login Form Kurikulum</h2>
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" class="login__input" placeholder="Username">
				</div>
				<div class="login__field password__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" class="login__input" id="password" placeholder="Password">
					<i class="toggle-password fas fa-eye" id="togglePassword"></i>
				</div>
				<button class="button login__submit">
					<span class="button__text">Log In Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
		</div>
	</div>
</div>

<!-- Tambahkan Script -->
<script>
    // ambil elemen password & ikon toggle
    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    // tambahkan event listener ke ikon toggle
    togglePassword.addEventListener('click', function () {
        // toggle tipe input antara 'password' & 'text'
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // ubah ikon mata
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>
