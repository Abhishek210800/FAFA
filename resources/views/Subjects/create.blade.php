<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add New Subject</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
            </div>

            <nav class="hidden md:flex space-x-4 items-center">
                <a href="{{ route('dashboard') }}" class="text-black hover:text-blue-500">Manage Cases</a>
                <a href="{{ route('subjects.index') }}" class="text-black hover:text-blue-500">Subjects</a>
                <!-- Add more nav items as needed -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm self-center"
                        type="submit">LOG OUT</button>
                </form>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow">
        <h1 class="text-xl font-bold mb-4">Add New Subject</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('subjects.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="p-3 border border-gray-300 rounded-lg w-full" required>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                <a href="{{ route('subjects.index') }}"
                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>

</body>

</html>
