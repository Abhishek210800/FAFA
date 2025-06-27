<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $status }} Cases</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <div>
                <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
            </div>

            <nav class="hidden md:flex space-x-4 items-center">
                <!-- Always show Dashboard  -->
                <a href="{{ route('dashboard') }}"
                class="p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-red-700 text-white' : 'hover:bg-red-700 hover:text-white' }}">
                    Dashboard
                </a>

                @php
                    $status = request()->route('status');
                @endphp

                <!-- Conditionally show the other cases links -->
                @if ($status === 'pending')
                    <a href="{{ route('cases.filter', ['status' => 'resolved']) }}"
                    class="p-2 rounded-lg hover:bg-green-700 hover:text-white">
                        Resolved Cases
                    </a>
                    <a href="{{ route('cases.filter', ['status' => 'upcoming']) }}"
                    class="p-2 rounded-lg hover:bg-green-700 hover:text-white">
                        Upcoming Cases
                    </a>
                @elseif ($status === 'resolved')
                    <a href="{{ route('cases.filter', ['status' => 'pending']) }}"
                    class="p-2 rounded-lg hover:bg-green-700 hover:text-white">
                        Pending Cases
                    </a>
                    <a href="{{ route('cases.filter', ['status' => 'upcoming']) }}"
                    class="p-2 rounded-lg hover:bg-green-700 hover:text-white">
                        Upcoming Cases
                    </a>
                @elseif ($status === 'upcoming')
                    <a href="{{ route('cases.filter', ['status' => 'pending']) }}"
                    class="p-2 rounded-lg hover:bg-green-700 hover:text-white">
                        Pending Cases
                    </a>
                    <a href="{{ route('cases.filter', ['status' => 'resolved']) }}"
                    class="p-2 rounded-lg hover:bg-green-700 hover:text-white">
                        Resolved Cases
                    </a>
                @endif
            </nav>

        </div>
    </header>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-white z-50 hidden">
        <div class="flex space-x-2">
            @for($i = 0; $i < 5; $i++)
                <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce" style="animation-delay: {{ $i * 0.1 }}s;"></div>
            @endfor
        </div>
    </div>

    <main class="container mx-auto px-4 py-6">
        <h1 class="text-xl font-bold mb-4 capitalize">{{ $status }} Cases</h1>

        @if($cases->count())
            <div id="datatableContainer" class="opacity-0 invisible transition-opacity duration-500">
                <table id="recentCasesTable" class="min-w-full bg-white border rounded shadow">
                    <thead class="bg-gray-200">
                      <tr>
                          <th class="px-4 py-2 border">Case Number</th>
                          <th class="px-4 py-2 border">Complainant</th>
                          <th class="px-4 py-2 border">Defendant</th>
                          <th class="px-4 py-2 border">Complainant Advocate</th>
                          <th class="px-4 py-2 border">Defandant Advocate</th>
                          <th class="px-4 py-2 border">Mediator</th>
                          <th class="px-4 py-2 border">Status</th>
                          <th class="px-4 py-2 border text-center">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($cases as $case)
                          <tr>
                              <td class="px-4 py-2 border">{{ $case->case_number }}</td>
                              <td class="px-4 py-2 border">{{ $case->complainant_name }}</td>
                              <td class="px-4 py-2 border">{{ $case->defendant_name }}</td>
                              <td class="px-4 py-2 border">{{ $case->complainantAdvocate->name ?? '-' }}</td>
                              <td class="px-4 py-2 border">{{ $case->defendantAdvocate->name ?? '-' }}</td>
                              <td class="px-4 py-2 border">{{ $case->mediator->name ?? '-' }}</td>

                              <td class="px-4 py-2 border">{{ $case->status }}</td>
                              <td class="px-4 py-2 border text-center">
                                  <a href="{{ route('cases.show', $case->id) }}"
                                     class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                      View
                                  </a>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>

                </table>
            </div>
        @else
            <div class="text-center text-gray-500 py-8">No cases found.</div>
        @endif
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            const tableElement = $('#recentCasesTable');
            const spinner = $('#loadingSpinner');
            const container = $('#datatableContainer');

            tableElement.DataTable({
                order: [[0, 'desc']],
                pageLength: 20,
                dom: '<"flex flex-col md:flex-row justify-between items-center mb-4 gap-2"lf>t<"flex justify-between items-center mt-4"ip>',
                initComplete: function () {
                    spinner.hide();
                    container.removeClass('opacity-0 invisible').addClass('opacity-100 visible');
                }
            });
        });
    </script>
</body>
</html>
