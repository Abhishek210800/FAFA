<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Complainant Details</title>
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
                <a href="{{ route('dashboard') }}"
                    class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Manage Cases</a>
                <a href="{{ route('appellants.index') }}"
                    class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Appellants</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow max-w-4xl">
        <h1 class="text-2xl font-bold mb-6">Complainant Details</h1>

        @if ($appellant->complainant_type === 'individual')
            <div class="bg-white p-6 rounded-lg shadow-lg text-gray-800 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                <div><strong>Name:</strong> {{ $appellant->name }}</div>
                <div><strong>Father's Name:</strong> {{ $appellant->father }}</div>
                <div><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($appellant->dob)->format('d-m-Y') }}</div>
                <div><strong>Gender:</strong> {{ $appellant->gender }}</div>
                <div><strong>Address:</strong> {{ $appellant->address }}</div>
                <div><strong>State:</strong> {{ $appellant->state->name ?? 'N/A' }}</div>
                <div><strong>City:</strong> {{ $appellant->city->name ?? 'N/A' }}</div>
                <div><strong>District:</strong> {{ $appellant->district  ?? 'N/A' }}</div>
                <div><strong>Pincode:</strong> {{ $appellant->pincode ?? 'N/A' }}</div>
                <div><strong>Mobile:</strong> {{ $appellant->mobile ?? 'N/A' }}</div>
                <div><strong>Email:</strong> {{ $appellant->email ?? 'N/A' }}</div>

                @if ($appellant->id_proof)
                    <div>
                        <strong>ID Proof:</strong><br />
                        <a href="{{ asset('storage/' . $appellant->id_proof) }}" target="_blank"
                            class="text-blue-600 underline">View Uploaded File</a>
                    </div>
                @else
                    <div><strong>ID Proof:</strong> Not uploaded</div>
                @endif
            </div>

        @elseif ($appellant->complainant_type === 'entity')
            <div class="bg-white p-6 rounded-lg shadow-lg text-gray-800 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                <div><strong>Name of Entity:</strong> {{ $appellant->name }}</div>
                <div><strong>Authorised Representative:</strong> {{ $appellant->father }}</div>
                <div><strong>Date of Incorporation:</strong> {{ \Carbon\Carbon::parse($appellant->dob)->format('d-m-Y') }}</div>
                <div><strong>Address:</strong> {{ $appellant->address }}</div>
                <div><strong>State:</strong> {{ $appellant->state->name ?? 'N/A' }}</div>
                <div><strong>City:</strong> {{ $appellant->city->name ?? 'N/A' }}</div>
                <div><strong>Pincode:</strong> {{ $appellant->pincode }}</div>
                <div><strong>Email:</strong> {{ $appellant->email }}</div>

                @if ($appellant->id_proof)
                    <div>
                        <strong>Incorporation Certificate:</strong><br />
                        <a href="{{ asset('storage/' . $appellant->id_proof) }}" target="_blank"
                            class="text-blue-600 underline">View Uploaded File</a>
                    </div>
                @else
                    <div><strong>Incorporation Certificate:</strong> Not uploaded</div>
                @endif
            </div>
        @else
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4 shadow">Complainant type not specified.</div>
        @endif

        <a href="{{ route('appellants.index') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>

</body>

</html>
