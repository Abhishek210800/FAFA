<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Appellant Details</title>
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
                <a href="{{ route('appellants.index') }}" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Appellants</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-4 flex-grow max-w-4xl">
        <h1 class="text-2xl font-bold mb-6">Appellant Details</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg text-gray-800 space-y-2 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
            <div><strong>Name:</strong> {{ $appellant->name }}</div>
            <div><strong>Father's Name:</strong> {{ $appellant->father }}</div>
            <div><strong>Date of Birth:</strong> {{ $appellant->dob }}</div>
            <div><strong>Gender:</strong> {{ $appellant->gender }}</div>
            <div><strong>Address:</strong> {{ $appellant->address }}</div>
            <div><strong>City:</strong> {{ $appellant->city->name ?? 'N/A' }}</div>
            <div><strong>District:</strong> {{ $appellant->district }}</div>
            <div><strong>State:</strong> {{ $appellant->state->name ?? 'N/A' }}</div>
            <div><strong>Pincode:</strong> {{ $appellant->pincode }}</div>
            <div><strong>Mobile:</strong> {{ $appellant->mobile }}</div>
            <div><strong>Email:</strong> {{ $appellant->email }}</div>
        

        @if($appellant->id_proof)
            <div class="mb-4">
                <strong>ID Proof:</strong><br />
                <a href="{{ asset('uploads/id_proofs/' . $appellant->id_proof) }}" target="_blank"
                    class="text-blue-600 underline">View Uploaded File</a>
            </div>
        @endif

        </div>

        <a href="{{ route('appellants.index') }}"
             class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>

</body>

</html>
