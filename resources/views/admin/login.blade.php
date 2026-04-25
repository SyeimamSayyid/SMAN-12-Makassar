<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

    <h2 class="text-2xl font-bold text-center mb-6 text-blue-600">
        Admin Login
    </h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-2">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded-lg px-4 py-2 focus:outline-blue-500"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-sm mb-2">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-4 py-2 focus:outline-blue-500"
                   required>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Login
        </button>
    </form>

</div>

</body>
</html>
