<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appellant List</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>
<body class="bg-gray-100">

    <!-- Custom Header -->
    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
            </div>

            <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <nav class="hidden md:flex space-x-4 items-center">
            <a href="{{ route('dashboard') }}"
                class="p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Manage Cases
            </a>
            <a href="{{ route('appellants.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('appellants.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Appellant
            </a>
            <a href="{{ route('respondents.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('respondents.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Respondent
            </a>
            <a href="{{ route('advocates.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('advocates.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Advocates
            </a>
            <a href="{{ route('mediators.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('mediators.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Mediators
            </a>
            <a href="{{ route('courts.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('courts.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Court
            </a>
            <a href="{{ route('subjects.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('subjects.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Subject
            </a>
            <a href="{{ route('issues.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('issues.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Issue
            </a>
            <a href="{{ route('statutes.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('statutes.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Statute
            </a>
            <a href="{{ route('users.index') }}"
                class="p-2 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700 hover:text-white' }}">
                Users
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm self-center">
                    LOG OUT
                </button>
            </form>
        </nav>
        </div>
    </header>

    <!-- Page Content -->
    <main class="container mx-auto px-4 py-6">
        <h1 class="text-xl font-bold mb-4">Appellant List</h1>

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
            <table id="recentCasesTable" class="min-w-full bg-white border mt-4 rounded shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Father Name</th>
                        <th class="px-4 py-2 border">Gender</th>
                        <th class="px-4 py-2 border">Mobile</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appellants as $appellant)
                    <tr>
                        <td class="px-4 py-2 border">{{ $appellant->id }}</td>
                        <td class="px-4 py-2 border">{{ $appellant->name }}</td>
                        <td class="px-4 py-2 border">{{ $appellant->father }}</td>
                        <td class="px-4 py-2 border">{{ $appellant->gender }}</td>
                        <td class="px-4 py-2 border">{{ $appellant->mobile }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex space-x-3">
                                <a href="{{ route('appellants.show', $appellant->id) }}" 
                                   class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">View</a>
                                <a href="{{ route('appellants.edit', $appellant->id) }}"
                                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                                <form action="{{ route('appellants.destroy', $appellant->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this appellant?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    @include('components.datatables-scripts')

</body>
</html>
