<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fast and Fair Arbitration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>

<body class="bg-gray-100">

<!-- Header -->

<header class="bg-white shadow-md w-full">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
					<img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
        </div>

        <!-- Mobile Menu Button -->
        <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-4 items-center">
            <a href="{{ route('dashboard') }}" class="text-black hover:text-blue-500">Manage Cases</a>

						<a href="{{ route('appellants.index') }}" class="text-black hover:text-blue-500">Appellant</a>
						<a href="{{ route('respondents.index') }}" class="text-black hover:text-blue-500">Respondent</a>
            <a href="#" class="text-black hover:text-blue-500">Advocates</a>
            <a href="#" class="text-black hover:text-blue-500">Mediator</a>
            <a href="#" class="text-black hover:text-blue-500">Court</a>
            <a href="#" class="text-black hover:text-blue-500">Subject</a>
            <a href="#" class="text-black hover:text-blue-500">Issue</a>
            <a href="#" class="text-black hover:text-blue-500">Statute</a>
            <a href="#" class="text-black hover:text-blue-500">Users</a>
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm self-center">LOG OUT</button>
        </nav>
    </div>
</header>



<!-- Remove body padding as it's no longer needed -->
<style>
    body {
        padding-top: 0;
    }
</style>
<main class="container mx-auto px-4 py-6">
    <h1 class="text-xl font-bold mb-4">Edit Appellant</h1>

    <form action="{{ route('appellants.update', $appellant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Accordion Container -->
        <div class="bg-gradient-to-b from-gray-50 to-gray-100 border border-gray-300 rounded-lg shadow-lg mb-6">
            

            <!-- Accordion Content -->
            <fieldset id="complainant-accordion-content" class="p-6 bg-white space-y-8 rounded-b-lg shadow-sm transition-all duration-500">
                <!-- First Row -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Name</label>
                        <input type="text" name="name" value="{{ old('name', $appellant->name) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Father's Name</label>
                        <input type="text" name="father" value="{{ old('father', $appellant->father) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', $appellant->dob) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Gender</label>
                        <select name="gender" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $appellant->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $appellant->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $appellant->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Address</label>
                        <input type="text" name="address" value="{{ old('address', $appellant->address) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">City</label>
                        <select name="city_id" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $appellant->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">District</label>
                        <input type="text" name="district" value="{{ old('district', $appellant->district) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">State</label>
                        <select name="state_id" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id', $appellant->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Pincode</label>
                        <input type="text" name="pincode" value="{{ old('pincode', $appellant->pincode) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                </div>

                <!-- Third Row -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Mobile</label>
                        <input type="tel" name="mobile" pattern="[0-9]{10}" value="{{ old('mobile', $appellant->mobile) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm">Email</label>
                        <input type="email" name="email" value="{{ old('email', $appellant->email) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                    </div>
                </div>

                <!-- File Upload -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold text-sm">Upload ID Proof</label>
                    <input type="file" name="id_proof" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update</button>
                    <a href="{{ route('appellants.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</a>
                </div>
            </fieldset>
        </div>
    </form>
</main>
</form>
	<!-- Footer -->
			<footer class="bg-gray-800 text-white text-center py-4 mt-6">
				© 2025 Fast and Fair Arbitration. All rights reserved.
			</footer>

<script>
    function toggleComplainantAccordion() {
        const content = document.getElementById("complainant-accordion-content");
        const icon = document.getElementById("complainant-accordion-icon");
        content.classList.toggle("hidden");
        icon.style.transform = content.classList.contains("hidden") ? "rotate(180deg)" : "rotate(0deg)";
    }
</script>
</body>

</html>