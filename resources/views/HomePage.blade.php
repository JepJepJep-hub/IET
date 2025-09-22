<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IET Register</title>
    <link rel="icon" href="{{ asset('WebsiteLogo.png') }}" type="image/x-icon">
</head>
<body>
    
    @auth
        {{-- User is logged in - show dashboard or redirect --}}
        <script>
            window.location.href = "{{ url('/dashboard') }}";
        </script>
    @else
        {{-- User is not logged in - show register/login forms --}}
        <div id="Register">
            <h2>Register</h2>
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
            
            <form action="/register" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="register">
                <input name="name" type="text" placeholder="Username" required>
                <input name="password" type="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <a href="javascript:void(0);" onclick="showSection('Login')">Already have an account? Login</a>
        </div>


        <div id="Login" style="display:none;">
            <h2>Login</h2>
            {{-- Error checker for login --}}
            @if($errors->any() && (session('form_type') === 'login' || !session('form_type')))
                <div style="color:red;">
                    {{ $errors->first() }}
                </div>
            @endif
           
            <form action="/login" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="login">
                <input name="name" type="text" placeholder="Username" required>
                <input name="password" type="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <a href="javascript:void(0);" onclick="showSection('Register')">Don't have an account? Register</a>
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