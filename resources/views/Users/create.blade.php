<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-white shadow-md w-full">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
        <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
        <nav class="hidden md:flex space-x-4 items-center">
            <a href="{{ route('dashboard') }}" class="text-black hover:text-blue-500">Manage Cases</a>
            <a href="{{ route('users.index') }}" class="text-black hover:text-blue-500">Users</a>
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm self-center">LOG OUT</button>
        </nav>
    </div>
</header>

<!-- Main Content -->
<main class="container mx-auto px-4 py-6 flex-grow">
    <h1 class="text-xl font-bold mb-4">Add New User</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="bg-white p-6 rounded-lg shadow-lg space-y-6">

            <div>
                <label class="block text-gray-700 font-semibold text-sm">Role ID</label>
                <input type="number" name="role_id" value="{{ old('role_id') }}" 
                       class="p-3 border border-gray-300 rounded-lg w-full" required />
            </div>

            <div>
                <label class="block text-gray-700 font-semibold text-sm">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="p-3 border border-gray-300 rounded-lg w-full" required />
            </div>

            <div>
                <label class="block text-gray-700 font-semibold text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="p-3 border border-gray-300 rounded-lg w-full" required />
            </div>

            <div>
                <label class="block text-gray-700 font-semibold text-sm">Password</label>
                <input type="password" name="password" 
                       class="p-3 border border-gray-300 rounded-lg w-full" required />
            </div>

            <div class="flex justify-end space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
                <a href="{{ route('users.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
            </div>
        </div>
    </form>
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white text-center py-4">
    © 2025 Fast and Fair Arbitration. All rights reserved.
</footer>

</body>
</html>
