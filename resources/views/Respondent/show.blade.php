<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Respondent Details</title>
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
                <a href="{{ route('respondents.index') }}"
                    class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm self-center">Respondents</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow max-w-4xl">
        <h1 class="text-2xl font-bold mb-6">Respondent Details</h1>

        @if ($respondent->defendant_type === 'individual')
            <div class="bg-white p-6 rounded-lg shadow-lg text-gray-800 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                <div><strong>Name:</strong> {{ $respondent->name }}</div>
                <div><strong>Father's Name:</strong> {{ $respondent->father }}</div>
                <div><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($respondent->dob)->format('d-m-Y') }}</div>
                <div><strong>Gender:</strong> {{ $respondent->gender }}</div>
                <div><strong>Address:</strong> {{ $respondent->address }}</div>
                <div><strong>State:</strong> {{ $respondent->state->name ?? 'N/A' }}</div>
                <div><strong>City:</strong> {{ $respondent->city->name ?? 'N/A' }}</div>
                <div><strong>District:</strong> {{ $respondent->district  ?? 'N/A' }}</div>
                <div><strong>Pincode:</strong> {{ $respondent->pincode }}</div>
                <div><strong>Mobile:</strong> {{ $respondent->mobile ?? 'N/A' }}</div>
                <div><strong>Email:</strong> {{ $respondent->email }}</div>

                @if ($respondent->id_proof)
                    <div>
                        <strong>ID Proof:</strong><br />
                        <a href="{{ asset('storage/' . $respondent->id_proof) }}" target="_blank"
                            class="text-blue-600 underline">View Uploaded File</a>
                    </div>
                @else
                    <div><strong>ID Proof:</strong> Not uploaded</div>
                @endif
            </div>

        @elseif ($respondent->defendant_type === 'entity')
            <div class="bg-white p-6 rounded-lg shadow-lg text-gray-800 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                <div><strong>Name of Entity:</strong> {{ $respondent->name }}</div>
                <div><strong>Authorised Representative:</strong> {{ $respondent->father }}</div>
                <div><strong>Date of Incorporation:</strong> {{ \Carbon\Carbon::parse($respondent->dob)->format('d-m-Y') }}</div>
                <div><strong>Address:</strong> {{ $respondent->address }}</div>
                <div><strong>State:</strong> {{ $respondent->state->name ?? 'N/A' }}</div>
                <div><strong>City:</strong> {{ $respondent->city->name ?? 'N/A' }}</div>
                <div><strong>Pincode:</strong> {{ $respondent->pincode }}</div>
                <div><strong>Email:</strong> {{ $respondent->email }}</div>

                @if ($respondent->id_proof)
                    <div>
                        <strong>Incorporation Certificate:</strong><br />
                        <a href="{{ asset('storage/' . $respondent->id_proof) }}" target="_blank"
                            class="text-blue-600 underline">View Uploaded File</a>
                    </div>
                @else
                    <div><strong>Incorporation Certificate:</strong> Not uploaded</div>
                @endif
            </div>
        @else
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4 shadow">Respondent type not specified.</div>
        @endif

        <a href="{{ route('respondents.index') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>

</body>

</html>
