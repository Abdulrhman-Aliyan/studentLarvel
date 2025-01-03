<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Register</h2>
        <form id="registerForm" method="post" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <span class="input-group-text" id="togglePassword">
                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <div id="passwordHelp" class="form-text">
                    Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.
                </div>
                <div id="passwordError" class="form-text text-danger" style="display: none;">Password does not meet the required criteria.</div>
            </div>
            <div class="mb-3">
                <label for="repeat-password" class="form-label">Repeat Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="repeat-password" name="password_confirmation" required>
                    <span class="input-group-text" id="toggleRepeatPassword">
                        <i class="bi bi-eye" id="toggleRepeatPasswordIcon"></i>
                    </span>
                </div>
                <div id="repeatPasswordError" class="form-text text-danger" style="display: none;">Passwords do not match.</div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="text-center mt-3">
            <p>Have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
    <!-- Ensure the path to Bootstrap JS is correct -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.js"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var repeatPassword = document.getElementById('repeat-password').value;
            var passwordError = document.getElementById('passwordError');
            var repeatPasswordError = document.getElementById('repeatPasswordError');
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (password !== repeatPassword) {
                event.preventDefault();
                repeatPasswordError.style.display = 'block';
            } else {
                repeatPasswordError.style.display = 'none';
            }

            if (!passwordPattern.test(password)) {
                event.preventDefault();
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });

        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            var passwordIcon = document.getElementById('togglePasswordIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        });

        document.getElementById('toggleRepeatPassword').addEventListener('click', function() {
            var repeatPasswordField = document.getElementById('repeat-password');
            var repeatPasswordIcon = document.getElementById('toggleRepeatPasswordIcon');
            if (repeatPasswordField.type === 'password') {
                repeatPasswordField.type = 'text';
                repeatPasswordIcon.classList.remove('bi-eye');
                repeatPasswordIcon.classList.add('bi-eye-slash');
            } else {
                repeatPasswordField.type = 'password';
                repeatPasswordIcon.classList.remove('bi-eye-slash');
                repeatPasswordIcon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>
