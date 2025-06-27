<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Statute</title>
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
                <a href="{{ route('statutes.index') }}" class="text-black hover:text-blue-500">Statutes</a>
                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm self-center">LOG OUT</button>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow">
        <h1 class="text-xl font-bold mb-4">Edit Statute</h1>

        <form action="{{ route('statutes.update', $statute->AG_StatuteCode) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white p-6 rounded-lg shadow-lg space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold text-sm">Statute Code</label>
                    <input type="text" name="AG_StatuteCode" value="{{ old('AG_StatuteCode', $statute->AG_StatuteCode) }}" 
                        class="p-3 border border-gray-300 rounded-lg w-full" readonly />
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold text-sm">Act Name</label>
                    <input type="text" name="Act_Name" value="{{ old('Act_Name', $statute->Act_Name) }}" 
                        class="p-3 border border-gray-300 rounded-lg w-full" required />
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold text-sm">Count Code</label>
                    <input type="text" name="Count_code" value="{{ old('Count_code', $statute->Count_code) }}" 
                        class="p-3 border border-gray-300 rounded-lg w-full" />
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                    <a href="{{ route('statutes.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
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
