<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Advocate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Add New Advocate</h1>

        <!-- Flash success message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('advocates.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border px-4 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Bar Number</label>
                <input type="text" name="bar_number"  class="w-full border px-4 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Mobile</label>
                <input type="text" name="mobile" value="{{ old('mobile') }}" class="w-full border px-4 py-2 rounded" required>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="emailId" value="{{ old('emailId') }}" class="w-full border px-4 py-2 rounded" required>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('advocates.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
