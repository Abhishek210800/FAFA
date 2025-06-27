<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Court</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
            <nav class="hidden md:flex space-x-4 items-center">
                <a href="{{ route('dashboard') }}" class="text-black hover:text-blue-500">Manage Cases</a>
                <a href="{{ route('courts.index') }}" class="text-black hover:text-blue-500">Courts</a>
                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">LOG OUT</button>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 flex-grow">
        <h1 class="text-xl font-bold mb-4">Edit Court</h1>

        <form action="{{ route('courts.update', str_pad($court->AG_Courtcode, 3, '0', STR_PAD_LEFT)) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label for="Court_Name" class="block font-semibold text-gray-700">Court Name</label>
        <input type="text" id="Court_Name" name="Court_Name" 
            value="{{ old('Court_Name', $court->Court_Name) }}" 
            class="w-full border p-2 rounded" required>
        @error('Court_Name')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="Count_code" class="block font-semibold text-gray-700">Count Code</label>
        <input type="text" id="Count_code" name="Count_code" 
            value="{{ old('Count_code', $court->Count_code) }}" 
            class="w-full border p-2 rounded">
        @error('Count_code')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Update Court
    </button>
</form>

    </main>

    <footer class="bg-gray-800 text-white text-center py-4">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>

</body>
</html>