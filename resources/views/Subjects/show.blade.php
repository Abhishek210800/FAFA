<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Subject Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12" />
            </div>

            <nav class="hidden md:flex space-x-4 items-center">
                <a href="{{ route('dashboard') }}" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Manage Cases</a>
                <a href="{{ route('subjects.index') }}" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Subjects</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow ">
        <h1 class="text-2xl font-bold mb-6">Subject Details</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg text-gray-800 space-y-2 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-semibold">Subject ID:</span> {{ $subject->subject_id ?? 'N/A' }}
            </div>
            <div>
                <span class="font-semibold">Name:</span> {{ $subject->name ?? 'N/A' }}
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('subjects.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Back
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>

</body>

</html>
