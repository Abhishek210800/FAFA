<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fast and Fair Arbitration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>

<body class="bg-gray-100">

    <!-- Mobile & Tablet Navbar -->
    <div class="md:hidden bg-gray-200 p-4 flex justify-between items-center">
        <img src="{{ asset('images/logoupdated.png') }}" alt="Company Logo" class="w-36 h-auto" />
        <button id="menuBtn" class="text-black focus:outline-none text-2xl">☰</button>
    </div>

    <!-- Dropdown Menu for Mobile & Tablet -->
    <div id="mobileMenu" class="hidden md:hidden bg-blue-900 text-white p-4 space-y-2">
        <a href="{{ route('cases.index') }}" class="block p-2 hover:bg-blue-700">📂 Manage Cases</a>
        <a href="{{ route('appellants.index') }}" class="block p-2 hover:bg-blue-700">👨‍⚖ Appellant</a>
        <a href="{{ route('respondents.index') }}" class="block p-2 hover:bg-blue-700">⚖ Respondent</a>
        <a href="{{ route('advocates.index') }}" class="block p-2 hover:bg-blue-700">⚖ Advocates</a>
        <a href="{{ route('mediators.index') }}" class="block p-2 hover:bg-blue-700">⚖ Mediator</a>
        <a href="{{ route('courts.index') }}" class="block p-2 hover:bg-blue-700">🏛 Court</a>
        <a href="{{ route('subjects.index') }}" class="block p-2 hover:bg-blue-700">📜 Subject</a>
        <a href="{{ route('issues.index') }}" class="block p-2 hover:bg-blue-700">📑 Issue</a>
        <a href="{{ route('statutes.index') }}" class="block p-2 hover:bg-blue-700">📖 Statute</a>
        <a href="{{ route('users.index') }}" class="block p-2 hover:bg-blue-700">👥 Users</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left p-2 bg-red-600 hover:bg-red-700">🚪 LOG OUT</button>
        </form>
    </div>

                <!-- Sidebar for Desktop -->
                <style>
                    .sidebar {
                        scrollbar-width: none;       /* Firefox */
                        -ms-overflow-style: none;    /* Internet Explorer 10+ */
                        }

                        .sidebar::-webkit-scrollbar {
                        display: none;               /* Chrome, Safari */
                        }                    
                </style>
                <aside class="sidebar hidden md:block md:w-64 bg-gray-200 text-black flex-col p-4 fixed h-full overflow-y-auto">
                <img src="{{ asset('images/logoupdated.png') }}" alt="Company Logo" class="mb-6 w-full" />
                <nav class="flex flex-col space-y-4">
                    <a href="{{ route('dashboard') }}" class="p-2 bg-blue-700 text-white rounded-lg">📂 Manage Cases</a>
                    <a href="{{ route('appellants.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">👨‍⚖ Appellant</a>
                    <a href="{{ route('respondents.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">⚖ Respondent</a>
                    <a href="{{ route('advocates.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">⚖ Advocates</a>
                    <a href="{{ route('mediators.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">⚖ Mediators</a>
                    <a href="{{ route('courts.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">🏛 Court</a>
                    <a href="{{ route('subjects.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">📜 Subject</a>
                    <a href="{{ route('issues.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">📑 Issue</a>
                    <a href="{{ route('statutes.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">📖 Statute</a>
                    <a href="{{ route('users.index') }}" class="p-2 hover:bg-blue-700 hover:text-white rounded-lg">👥 Users</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 bg-red-600 text-white hover:bg-red-700 rounded-lg">🚪 LOG OUT</button>
                    </form>
                </nav>
            </aside>

    <!-- Main Content -->
    <div class="md:ml-64 p-6">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <input id="customSearch" type="text" placeholder="Search cases..." class="p-2 border rounded-lg w-1/3" />
            <div class="relative inline-block text-left">
                <div class="relative">
                    <button class="relative">
                        🔔 Notifications
                        @if($unreadMessages->count())
                            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1 rounded-full">{{ $unreadMessages->count() }}</span>
                        @endif
                    </button>

                    @if($unreadMessages->count())
                        <div class="absolute right-0 bg-white border shadow-lg mt-2 w-72 z-50 p-3">
                            <h5 class="font-bold">New Messages</h5>
                            <ul>
                                @foreach($unreadMessages as $msg)
                                    <li class="text-sm border-b py-1">
                                        <strong>{{ $msg->name }}</strong>: {{ Str::limit($msg->message, 30) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <button id="userDropdownBtn" class="ml-4 inline-flex justify-center items-center text-gray-700 font-medium focus:outline-none">
                    👤 {{ Auth::user()?->name ?? 'Guest' }}
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Stats Section -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <a href="{{ route('cases.filter', 'pending') }}">
                    <div class="bg-white p-4 rounded-lg shadow hover:bg-blue-100 cursor-pointer">
                        <h2 class="text-lg font-semibold">📑 Pending Cases</h2>
                        <p class="text-2xl font-bold">{{ $pendingCases }}</p>
                    </div>
                </a>
                <a href="{{ route('cases.filter', 'resolved') }}">
                    <div class="bg-white p-4 rounded-lg shadow hover:bg-blue-100 cursor-pointer">
                        <h2 class="text-lg font-semibold">✅ Resolved Cases</h2>
                        <p class="text-2xl font-bold">{{ $resolvedCases }}</p>
                    </div>
                </a>
                <a href="{{ route('cases.filter', 'upcoming') }}">
                    <div class="bg-white p-4 rounded-lg shadow hover:bg-blue-100 cursor-pointer">
                        <h2 class="text-lg font-semibold">📅 Upcoming Hearings</h2>
                        <p class="text-2xl font-bold">{{ $upcomingHearings }}</p>
                    </div>
                </a>
            </section>


        <!-- Recent Cases Table -->
        <section class="mt-6" x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)">
            @if (session('success'))
                <div
                    x-show="show"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert"
                >
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            


            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">📂 Recent Cases</h2>
                <a href="{{ route('register.new') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200">
                    + Add Cases
                </a>
            </div>

            <div class="bg-white p-4 rounded-lg shadow overflow-x-auto">
                <table id="recentCasesTable" class="w-full min-w-[600px]">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="p-2">Case Number</th>
                            <th class="p-2">Complainant</th>
                            <th class="p-2">Defendant</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCases as $case)
                            <tr class="border-t">
                                <td class="p-2">{{ $case->case_number }}</td>
                                <td class="p-2">{{ $case->complainant_name }}</td>
                                <td class="p-2">{{ $case->defendant_name }}</td>
                                @php
                                    $isPastDate = \Carbon\Carbon::parse($case->reference_date)->lt(now());
                                @endphp
                                <td
                                    class="p-2
                                    @if($case->status == 'Closed') text-red-500
                                    @elseif($case->status == 'Active' && $isPastDate) text-green-500
                                    @else text-green-500 @endif"
                                >
                                    @if($case->status == 'Closed')
                                        Closed
                                    @else
                                        Active
                                    @endif
                                </td>
                               <td>
                                    <div class="flex flex-row space-x-2">
                                        <a href="{{ route('mediation.edit', $case->id) }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-center">
                                            Edit
                                        </a>
                                        <form action="{{ route('mediation.destroy', $case->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-center">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-4">No recent cases found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <button id="chatbotToggle" class="fixed bottom-5 right-5 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg">
        💬 Ask 
    </button>

    @include('components.chatbot-form')


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        // Initialize DataTable
        $(document).ready(function () {
            const table = $('#recentCasesTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 5
            });

            // Custom search input linked to DataTable
            $('#customSearch').on('keyup', function () {
                table.search(this.value).draw();
            });
        });


        // Toggle Mobile Menu
        document.getElementById('menuBtn').addEventListener('click', function () {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });

        // Toggle User Dropdown
        const btn = document.getElementById('userDropdownBtn');
        const dropdown = document.getElementById('userDropdown');

        document.addEventListener('click', e => {
            const isBtn = btn.contains(e.target);
            const isDropdown = dropdown.contains(e.target);

            if (isBtn) dropdown.classList.toggle('hidden');
            else if (!isDropdown) dropdown.classList.add('hidden');
        });

    </script>

    <script>
    $(document).on('click', '.update-case-btn', function () {
        const caseId = $(this).data('id');

        // Example: Get updated values from input fields
        const caseNumber = $(#case_number_${caseId}).val();
        const complainant = $(#complainant_${caseId}).val();
        const defendant = $(#defendant_${caseId}).val();
        const status = $(#status_${caseId}).val();

        $.ajax({
            url: /cases/${caseId}, // Laravel resource route
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                case_number: caseNumber,
                complainant_name: complainant,
                defendant_name: defendant,
                status: status
            },
            success: function (response) {
                alert('Case updated successfully!');
                location.reload(); // Optional: refresh to reflect changes
            },
            error: function (xhr) {
                alert('Update failed!');
                console.error(xhr.responseText);
            }
        });
    });
</script>

<!-- Ajax code for delete case  -->
<script>
    function deleteMediation(id) {
        if (!confirm('Are you sure?')) return;

        fetch(`/mediations/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                alert('Deleted successfully');
                location.reload(); // or remove the row from DOM
            } else {
                alert('Failed to delete');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }
</script>

</body>
</html>