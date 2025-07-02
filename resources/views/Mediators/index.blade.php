<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Mediators List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>
<body class="bg-gray-100">

<header class="bg-white shadow-md w-full">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
        </div>

        <nav class="hidden md:flex space-x-4 items-center">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Manage Cases</a>
            <a href="{{ route('appellants.index') }}" class="p-2 rounded-lg {{ request()->routeIs('appellants.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Appellant</a>
            <a href="{{ route('respondents.index') }}" class="p-2 rounded-lg {{ request()->routeIs('respondents.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Respondent</a>
            <a href="{{ route('advocates.index') }}" class="p-2 rounded-lg {{ request()->routeIs('advocates.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Advocates</a>
            <a href="{{ route('mediators.index') }}" class="p-2 rounded-lg {{ request()->routeIs('mediators.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Mediators</a>
            <a href="{{ route('courts.index') }}" class="p-2 rounded-lg {{ request()->routeIs('courts.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Court</a>
            <a href="{{ route('subjects.index') }}" class="p-2 rounded-lg {{ request()->routeIs('subjects.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Subject</a>
            <a href="{{ route('issues.index') }}" class="p-2 rounded-lg {{ request()->routeIs('issues.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Issue</a>
            <a href="{{ route('statutes.index') }}" class="p-2 rounded-lg {{ request()->routeIs('statutes.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Statute</a>
            <a href="{{ route('users.index') }}" class="p-2 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">Users</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm self-center">LOG OUT</button>
            </form>
        </nav>
    </div>
</header>

<main class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Mediators</h1>
        <button onclick="openMediatorModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">
            + Add Mediator
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="mb-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded">
            {{ session('warning') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

     <!-- Loading Spinner (5 Dots) -->
        <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-white z-50 hidden">
            <div class="flex space-x-2">
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.1s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.2s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.3s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.4s]"></div>
            </div>
        </div>

    <div id="datatableContainer" class="opacity-0 invisible transition-opacity duration-500">
        <table id="recentCasesTable" class="min-w-full border mt-4 bg-white rounded shadow  ">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Mobile</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mediators as $mediator)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $mediator->id }}</td>
                        <td class="px-4 py-2 border">{{ $mediator->name }}</td>
                        <td class="px-4 py-2 border">{{ $mediator->mobile ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">{{ $mediator->emailId ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="{{ route('mediators.show', $mediator->id) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">View</a>
                            <a href="{{ route('mediators.edit', $mediator->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                            <form action="{{ route('mediators.destroy', $mediator->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this mediator?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</main>

<!-- Modal -->
<div id="mediatorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 h-screen">
    <div class="bg-white p-6 rounded-lg max-w-md w-full space-y-4">
        <h2 class="text-lg font-semibold">Add New Mediator</h2>
        <form method="POST" action="{{ route('mediators.store') }}">
            @csrf
            <!-- Name -->
            <label class="block mt-2">
            <span class="block mb-1">Name <span class="text-red-500">*</span></span>
            <input type="text" name="name" placeholder="Name" class="w-full p-2 border rounded" required>
            </label>

            <!-- Specialization -->
            <label class="block mt-2">
            <span class="block mb-1">Specialization <span class="text-red-500">*</span></span>
            <input type="text" name="qualification" placeholder="Specialization" class="w-full p-2 border rounded" required>
            </label>

            <!-- Address -->
            <label class="block mt-2">
            <span class="block mb-1">Address <span class="text-red-500">*</span></span>
            <input type="text" name="address" placeholder="Address" class="w-full p-2 border rounded" required>
            </label>

            <!-- Mobile -->
            <label class="block mt-2">
            <span class="block mb-1">Mobile <span class="text-red-500">*</span></span>
            <input type="text" name="mobile" placeholder="Mobile" class="w-full p-2 border rounded" required>
            </label>

            <!-- Email -->
            <label class="block mt-2">
            <span class="block mb-1">Email <span class="text-red-500">*</span></span>
            <input type="email" name="emailId" placeholder="Email" class="w-full p-2 border rounded" required>
            </label>


            <div class="flex justify-end pt-3">
                <button type="button" onclick="closeMediatorModal()" class="px-4 py-2 mr-2 text-gray-600">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script>
    function openMediatorModal() {
        document.getElementById('mediatorModal').classList.remove('hidden');
    }
    function closeMediatorModal() {
        document.getElementById('mediatorModal').classList.add('hidden');
    }
    @if($errors->any())
        openMediatorModal();
    @endif
</script>

@include('components.datatables-scripts')


</body>
</html>
