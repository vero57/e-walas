<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E Walas | Admin</title>
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
<<<<<<< HEAD
	<div class="screen">
		<div class="screen__content">
			<form class="login">
			    <!-- Tambahin logo -->
			    <img src="images/logologin.png" alt="Logo" class="login__logo">
			    <h2>Login Form Admin</h2>
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
=======
    <!-- Tampilkan pesan error -->
    @if (session('error'))
        <div class="alert alert-danger" id="alertError">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tampilkan pesan success -->
    @if (session('success'))
        <div class="alert alert-success" id="alertSuccess">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="screen">
        <div class="screen__content">
            <form class="login" action="{{ route('login.store') }}" method="POST">
                @csrf
                <img src="{{ asset('images/logologin.png') }}" alt="Logo" class="login__logo">
                <h2>Login Form Admin</h2>
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" name="nama" class="login__input" placeholder="Nama" required>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="password" class="login__input" placeholder="Password" required>
                </div>
                <button type="submit" class="button login__submit">
                    <span class="button__text">Log In Now</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan Font Awesome untuk ikon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- JavaScript untuk menghilangkan pesan setelah 2 detik dengan animasi -->
<script>
    window.onload = function() {
        // Cek jika ada pesan error
        var errorAlert = document.getElementById('alertError');
        var successAlert = document.getElementById('alertSuccess');

        // Jika ada pesan error, sembunyikan setelah 2 detik dengan animasi
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                setTimeout(function() {
                    errorAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                }, 500); // Durasi animasi
            }, 2000); // Tunda selama 2 detik sebelum animasi
        }

        // Jika ada pesan success, sembunyikan setelah 2 detik dengan animasi
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                setTimeout(function() {
                    successAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                }, 500); // Durasi animasi
            }, 2000); // Tunda selama 2 detik sebelum animasi
        }
    };
>>>>>>> 3877b07841faac6b38244a0064e591a62836087e
</script>
</body>
</html>
