<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Advocate</title>
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
                <a href="{{ route('appellants.index') }}" class="text-black hover:text-blue-500">Appellant</a>
                <a href="{{ route('respondents.index') }}" class="text-black hover:text-blue-500">Respondent</a>
                <a href="{{ route('advocates.index') }}" class="text-black hover:text-blue-500">Advocates</a>
                <a href="{{ route('mediators.index') }}" class="text-black hover:text-blue-500">Mediator</a>
                <a href="{{ route('courts.index') }}" class="text-black hover:text-blue-500">Court</a>
                <a href="{{ route('subjects.index') }}" class="text-black hover:text-blue-500">Subject</a>
                <a href="{{ route('issues.index') }}" class="text-black hover:text-blue-500">Issue</a>
                <a href="{{ route('statutes.index') }}" class="text-black hover:text-blue-500">Statute</a>
                <a href="{{ route('users.index') }}" class="text-black hover:text-blue-500">Users</a>
                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm self-center">LOG OUT</button>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow">
        <h1 class="text-xl font-bold mb-4">Edit Advocate</h1>

        <form action="{{ route('advocates.update', $advocate->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white p-6 rounded-lg shadow-lg space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Name</label>
                        <input type="text" name="name" value="{{ old('name', $advocate->name) }}" class="p-3 border border-gray-300 rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Bar Number</label>
                        <input type="text" name="bar_number" value="{{ old('bar_number', $advocate->bar_number) }}" class="p-3 border border-gray-300 rounded-lg w-full">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Email</label>
                        <input type="email" name="emailId" value="{{ old('emailId', $advocate->emailId) }}" class="p-3 border border-gray-300 rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Mobile</label>
                        <input type="text" name="mobile" value="{{ old('mobile', $advocate->mobile) }}" class="p-3 border border-gray-300 rounded-lg w-full">
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                    <a href="{{ route('advocates.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
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
