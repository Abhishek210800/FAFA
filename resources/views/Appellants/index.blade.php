<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appellant List</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>
<body class="bg-gray-100">

  <!-- HEADER -->
  <header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
      <img src="{{ asset('images/logonew2.png') }}" alt="Logo" class="h-12">
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
  <main class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Appellant List</h1>

    <!-- SPINNER -->
    <div id="loadingSpinner"
         class="fixed inset-0 flex items-center justify-center bg-white z-50">
      <div class="flex space-x-2">
        @for($i=0; $i<5; $i++)
          <div class="w-3 h-3 bg-blue-500 rounded-full animate-bounce"
               style="animation-delay: {{ 0.1 * $i }}s"></div>
        @endfor
      </div>
    </div>

    <!-- TABLE -->
    <div id="datatableContainer" class="opacity-0 transition-opacity duration-500">
      <table id="appellantsTable" class="min-w-full bg-white border rounded shadow">
        <thead class="bg-gray-200">
          <tr>
            <!-- Mediation ID (hidden) -->
            <th class="px-3 py-2 border hidden">Mediation&nbsp;ID</th>

            <th class="px-3 py-2 border">Type</th>
            <th class="px-3 py-2 border">Entity/Individual Name</th>
            <th class="px-3 py-2 border">Father’s / Rep Name</th>
            <th class="px-3 py-2 border">DOB / Incorp Date</th>
            <!-- <th class="px-3 py-2 border">Gender</th> -->
            <!-- <th class="px-3 py-2 border">Address</th> -->
            <th class="px-3 py-2 border">State</th>
            <!-- <th class="px-3 py-2 border">City</th> -->
            <!-- <th class="px-3 py-2 border">District</th> -->
            <!-- <th class="px-3 py-2 border">Pincode</th> -->
            <!-- <th class="px-3 py-2 border">Mobile</th> -->
            <th class="px-3 py-2 border">Email</th>
            <!-- <th class="px-3 py-2 border">ID Proof / Certificate</th> -->
            <th class="px-3 py-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($appellants as $a)
            <tr>
              {{-- Mediation ID --}}
              <td class="px-3 py-2 border hidden">{{ $a->mediation_id }}</td>

              {{-- Type --}}
              <td class="px-3 py-2 border">
                <span class="px-2 py-1 rounded text-xs font-semibold
                  {{ $a->complainant_type==='individual'
                      ? 'bg-green-100 text-green-800'
                      : 'bg-purple-100 text-purple-800' }}">
                  {{ ucfirst($a->complainant_type) }}
                </span>
              </td>

              {{-- Ind/Entity Name --}}
              <td class="px-3 py-2 border">{{ $a->name ?? 'N/A' }}</td>

              {{-- Father’s / Rep Name --}}
              <td class="px-3 py-2 border">{{ $a->father ?? 'N/A' }}</td>

              {{-- DOB / Incorp Date --}}
              <td class="px-3 py-2 border">
                @if($a->dob)
                  {{ \Carbon\Carbon::parse($a->dob)->format('d-m-Y') }}
                @else N/A @endif
              </td>

              {{-- Gender --}}
              <!-- <td class="px-3 py-2 border">
                {{ $a->complainant_type==='individual'
                   ? ($a->gender ?? 'N/A')
                   : 'N/A' }}
              </td> -->

              {{-- Address --}}
              <!-- <td class="px-3 py-2 border">{{ Str::limit($a->address,30) ?? 'N/A' }}</td> -->

              {{-- State via relation --}}
              <td class="px-3 py-2 border">
                {{ optional($a->complainantState)->name ?? 'N/A' }}
              </td>

              {{-- City via relation --}}
              <!-- <td class="px-3 py-2 border">
                {{ optional($a->complainantCity)->name ?? 'N/A' }}
              </td> -->

              {{-- District --}}
              <!-- <td class="px-3 py-2 border">
                {{ $a->complainant_type==='individual'
                   ? ($a->district ?? 'N/A')
                   : 'N/A' }}
              </td> -->

              {{-- Pincode --}}
              <!-- <td class="px-3 py-2 border">{{ $a->pincode ?? 'N/A' }}</td> -->

              {{-- Mobile --}}
              <!-- <td class="px-3 py-2 border">
                {{ $a->complainant_type==='individual'
                   ? ($a->mobile ?? 'N/A')
                   : 'N/A' }}
              </td> -->

              {{-- Email --}}
              <td class="px-3 py-2 border">{{ $a->email ?? 'N/A' }}</td>

              {{-- ID Proof / Certificate --}}
              <!-- <td class="px-3 py-2 border">{{ $a->id_proof ?? 'N/A' }}</td> -->

              {{-- Actions --}}
              <td class="px-3 py-2 border">
                <div class="flex space-x-2">
                  <a href="{{ route('appellants.show', $a->id) }}"
                     class="px-2 py-1 bg-green-500 text-white rounded">View</a>
                  <a href="{{ route('appellants.edit', $a->id) }}"
                     class="px-2 py-1 bg-blue-500 text-white rounded">Edit</a>
                  <form action="{{ route('appellants.destroy', $a->id) }}"
                        method="POST" onsubmit="return confirm('Delete?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
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
      $('#appellantsTable').DataTable({
        order: [[ 0, 'desc' ]],       // sort by hidden Mediation ID
        pageLength: 20,
        dom: '<"flex flex-col md:flex-row justify-between items-center mb-4 gap-2"lf>t<"flex justify-between items-center mt-4"ip>',
        initComplete() {
          $('#loadingSpinner').hide();
          $('#datatableContainer').removeClass('opacity-0');
        }
      });
    });
  </script>
</body>
</html>
