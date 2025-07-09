<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Respondent Details</title>
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
                    class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm">Manage Cases</a>
                <a href="{{ route('respondents.index') }}"
                    class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm">Respondents</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-6 flex-grow max-w-4xl">
        <h1 class="text-2xl font-bold mb-6">Edit Respondent Details</h1>

        <form action="{{ route('respondents.update', $respondent->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" name="defendant_type" value="{{ $respondent->defendant_type }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @if ($respondent->defendant_type === 'individual')
                    <div>
                        <label class="font-semibold">Name</label>
                        <input type="text" name="name" value="{{ old('name', $respondent->name) }}" class="w-full mt-1 p-2 border rounded" required>
                    </div>

                    <div>
                        <label class="font-semibold">Father's Name</label>
                        <input type="text" name="father" value="{{ old('father', $respondent->father) }}" class="w-full mt-1 p-2 border rounded">
                    </div>

                    <div>
                        <label class="font-semibold">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', $respondent->dob) }}" class="w-full mt-1 p-2 border rounded">
                    </div>

                    <div>
                        <label class="font-semibold">Gender</label>
                        <select name="gender" class="w-full mt-1 p-2 border rounded">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender', $respondent->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $respondent->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $respondent->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                @elseif ($respondent->defendant_type === 'entity')
                    <div>
                        <label class="font-semibold">Name of Entity</label>
                        <input type="text" name="name" value="{{ old('name', $respondent->name) }}" class="w-full mt-1 p-2 border rounded" required>
                    </div>

                    <div>
                        <label class="font-semibold">Authorised Representative</label>
                        <input type="text" name="father" value="{{ old('father', $respondent->father) }}" class="w-full mt-1 p-2 border rounded">
                    </div>

                    <div>
                        <label class="font-semibold">Date of Incorporation</label>
                        <input type="date" name="dob" value="{{ old('dob', $respondent->dob) }}" class="w-full mt-1 p-2 border rounded">
                    </div>
                @endif

                <div class="md:col-span-2">
                    <label class="font-semibold">Address</label>
                    <textarea name="address" rows="2" class="w-full mt-1 p-2 border rounded">{{ old('address', $respondent->address) }}</textarea>
                </div>

                <div>
                    <label class="font-semibold">State</label>
                    <select name="state_id" class="w-full mt-1 p-2 border rounded">
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}" {{ old('state_id', $respondent->state_id) == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold">City</label>
                    <select name="city_id" class="w-full mt-1 p-2 border rounded">
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $respondent->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                

                <div>
                    <label class="font-semibold">Pincode</label>
                    <input type="text" name="pincode" value="{{ old('pincode', $respondent->pincode) }}" class="w-full mt-1 p-2 border rounded">
                </div>

                

                <div>
                    <label class="font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $respondent->email) }}" class="w-full mt-1 p-2 border rounded">
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold">
                        {{ $respondent->defendant_type === 'entity' ? 'Incorporation Certificate' : 'ID Proof' }}
                    </label>
                    @if ($respondent->id_proof)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $respondent->id_proof) }}" target="_blank" class="text-blue-600 underline">View Current File</a>
                        </div>
                    @endif
                    <input type="file" name="id_proof" class="w-full mt-1 p-2 border rounded">
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('respondents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Update</button>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4 mt-10">
        © 2025 Fast and Fair Arbitration. All rights reserved.
    </footer>
</body>

</html>
