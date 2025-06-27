<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Court</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
            <nav class="hidden md:flex space-x-4 items-center">
                <a href="{{ route('dashboard') }}" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Manage Cases</a>
                <a href="{{ route('courts.index') }}" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Courts</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 flex-grow">
        <h1 class="text-xl font-bold mb-4">Court Details</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            <div>
                <span class="font-semibold text-gray-700">AG Court Code:</span>
                <span class="ml-2">{{ $court->AG_Courtcode  }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Court Name:</span>
                <span class="ml-2">{{ $court->Court_Name }}</span>
            </div>
            <div>
                <span class="font-semibold text-gray-700">Count Code:</span>
                <span class="ml-2">{{ $court->Count_code }}</span>
            </div>

            <div class="mt-4">
                <a href="{{ route('courts.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>

</body>
</html>
