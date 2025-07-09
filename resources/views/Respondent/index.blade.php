<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Respondent List</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>
<body class="bg-gray-100">

  <!-- HEADER -->
  <header class="bg-white shadow-md w-full">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
      <img src="{{ asset('images/logonew.png') }}" alt="Logo" class="h-12">
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

  <!-- CONTENT -->
  <main class="container mx-auto px-4 py-6">
    <h1 class="text-xl font-bold mb-4">Respondent List</h1>

    <!-- LOADING SPINNER -->
    <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-white z-50">
      <div class="flex space-x-2">
        @for($i=0; $i<5; $i++)
          <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce"
               style="animation-delay: {{ 0.1 * $i }}s"></div>
        @endfor
      </div>
    </div>

    <!-- TABLE -->
    <div id="datatableContainer" class="opacity-0 invisible transition-opacity duration-500">
      <table id="respondentsTable" class="min-w-full bg-white border rounded shadow">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border hidden">Mediation ID</th>
            <th class="px-4 py-2 border">Type</th>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">Father’s / Rep</th>
            <th class="px-4 py-2 border">DOB / Incorp Date</th>
            <th class="px-4 py-2 border">State</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($respondents as $r)
          <tr>
            {{-- Mediation ID --}}
            <td class="px-4 py-2 border hidden">{{ $r->mediation_id }}</td>

            {{-- Type Badge --}}
            <td class="px-4 py-2 border">
              <span class="px-2 py-1 rounded text-xs font-semibold
                {{ $r->defendant_type === 'individual'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-purple-100 text-purple-800' }}">
                {{ ucfirst($r->defendant_type ?? 'N/A') }}
              </span>
            </td>

            {{-- Name --}}
            <td class="px-4 py-2 border">{{ $r->name ?? 'N/A' }}</td>

            {{-- Father’s / Rep --}}
            <td class="px-4 py-2 border">{{ $r->father ?? 'N/A' }}</td>

            {{-- DOB / Incorp Date --}}
            <td class="px-4 py-2 border">
              @if($r->dob)
                {{ \Carbon\Carbon::parse($r->dob)->format('d-m-Y') }}
              @else
                N/A
              @endif
            </td>

            {{-- State --}}
            <td class="px-4 py-2 border">
              {{ optional($r->complainantState)->name ?? 'N/A' }}
            </td>

            {{-- Email --}}
            <td class="px-4 py-2 border">{{ $r->email ?? 'N/A' }}</td>

            {{-- Actions --}}
            <td class="px-4 py-2 border">
              <div class="flex space-x-3">
                <a href="{{ route('respondents.show', $r->id) }}"
                   class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                  View
                </a>
                <a href="{{ route('respondents.edit', $r->id) }}"
                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                  Edit
                </a>
                <form action="{{ route('respondents.destroy', $r->id) }}"
                      method="POST" onsubmit="return confirm('Are you sure you want to delete this respondent?');">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                    Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>

  <!-- SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
    $(function(){
      $('#respondentsTable').DataTable({
        order: [[ 0, 'desc' ]],
        pageLength: 20,
        dom: '<"flex flex-col md:flex-row justify-between items-center mb-4 gap-2"lf>t<"flex justify-between items-center mt-4"ip>',
        initComplete() {
          $('#loadingSpinner').hide();
          $('#datatableContainer')
            .removeClass('opacity-0 invisible')
            .addClass('opacity-100 visible');
        }
      });
    });
  </script>
</body>
</html>
