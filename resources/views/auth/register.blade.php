<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">
<div class="card p-4 shadow" style="width: 400px;">
    <h3 class="text-center">Register</h3>
    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
            </select>
        </div>
        <button class="btn btn-success w-100">Register</button>
        <p class="text-center mt-3">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </p>
    </form>
</div>
</body>
</html>
