<!-- Your login page at resources/views/pages/admin/login.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
</head>

<body>

    <h2>Admin Login</h2>

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div style="margin-top: 1rem;">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        @if ($errors->any())
            <div style="color: red; margin-top: 1rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" style="margin-top: 1rem;">
            Login
        </button>
    </form>

</body>

</html>
