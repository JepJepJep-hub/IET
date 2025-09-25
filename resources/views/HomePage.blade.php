<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IET Register</title>
    <link rel="icon" href="{{ asset('WebsiteLogo.png') }}" type="image/x-icon">
    @vite(['resources/js/app.js'])
</head>
<body>
    
    @auth
        {{-- User is logged in - show dashboard or redirect --}}
        <script>
            window.location.href = "{{ url('/dashboard') }}";
        </script>
    @else
<div id="Register" class="container mt-5" style="max-width: 400px;">
        <h2 class="text-center mb-4">Register</h2>
        {{-- Error checker for registration --}}
        @if($errors->has('name'))
            <script>
                alert("{{ $errors->first('name') }}");
            </script>
        @endif

        @if(session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif

        <form action="/register" method="POST" class="card p-4 shadow-sm">
            @csrf
            <input type="hidden" name="form_type" value="register">

            <div class="mb-3">
                <input name="name" type="text" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input name="password" type="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="text-center mt-3">
            <a href="javascript:void(0);" onclick="showSection('Login')" class="text-decoration-none">
                Already have an account? <strong>Login</strong>
            </a>
        </div>
</div>

    <div id="Login" class="container mt-5" style="display:none; max-width: 400px;">
        <h2 class="text-center mb-4">Login</h2>

        {{-- Error checker for login --}}
        @if($errors->any() && (session('form_type') === 'login' || !session('form_type')))
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST" class="card p-4 shadow-sm">
            @csrf
            <input type="hidden" name="form_type" value="login">
            <div class="mb-3">
                <input name="name" type="text" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input name="password" type="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="javascript:void(0);" onclick="showSection('Register')" class="text-decoration-none">
                Don't have an account? <strong>Register</strong>
            </a>
        </div>
    </div>
    @endauth

    <script>
        function showSection(section) {
            document.getElementById('Register').style.display = 'none';
            document.getElementById('Login').style.display = 'none';
            document.getElementById(section).style.display = 'block';
        }

        // Show login form if there were login errors
        @if($errors->any() && session('form_type') === 'login')
            showSection('Login');
        @endif
    </script>
</body>
</html>