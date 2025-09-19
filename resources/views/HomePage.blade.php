<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IET Register</title>
    <link rel="icon" href="{{ asset('WebsiteLogo.png') }}" type="image/x-icon">
</head>
<body>
    <div id="Register">
        <h2>Register</h2>
        <form action="/register" method="POST">
            @csrf
            <input name ="name" type="text" placeholder="Username">
            <input name ="password" type="password" placeholder="Password">
            <button type="submit">Submit</button>
        </form>
    <a href="javascript:void(0);" onclick="showSection('Login')">Login</a>
        <a href="{{ url('/dashboard') }}">Go to Dashboard</a>
    </div>

    <div id="Login" style="display:none;">
        <h2>Login</h2>
        <form action="/login" method="POST">
            @csrf
            <input name ="name" type="text" placeholder="Username">
            <input name ="password" type="password" placeholder="Password">
            <button type="submit">Submit</button>
    </form>
    <a href="javascript:void(0);" onclick="showSection('Register')">Register</a>

    <script>
    function showSection(section) {
    document.getElementById('Register').style.display = 'none';
    document.getElementById('Login').style.display = 'none';
    document.getElementById(section).style.display = 'block';
    }
    </script>



</body>
</html>