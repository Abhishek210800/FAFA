<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statutes List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logonew2.png') }}" alt="Logo" class="h-12">
            </div>

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

    <!-- Statutes Table -->
    <main class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Statutes</h1>
            <a href="{{ route('statutes.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">
                + Add Statutes
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Loading Spinner (5 Dots) -->
        <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-white z-50 ">
            <div class="flex space-x-2">
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.1s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.2s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.3s]"></div>
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce [animation-delay:0.4s]"></div>
            </div>
        </div>

    <div id="datatableContainer" class="opacity-0 invisible transition-opacity duration-500">
        <table id="recentCasesTable" class="min-w-full border mt-4 ">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">Statute Code</th>
                    <th class="px-4 py-2 border">Act Name</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statutes as $statute)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $statute->AG_StatuteCode }}</td>
                        <td class="px-4 py-2 border">{{ $statute->Act_Name }}</td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="{{ route('statutes.show', $statute->AG_StatuteCode) }}"
                               class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">View</a>
                            <a href="{{ route('statutes.edit', $statute->AG_StatuteCode) }}"
                               class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                            <form action="{{ route('statutes.destroy', $statute->AG_StatuteCode) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    @include('components.datatables-scripts')

</body>
</html>
