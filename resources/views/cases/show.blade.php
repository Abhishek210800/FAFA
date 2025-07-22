<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Case Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-white shadow-md w-full">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
      <div class="flex items-center space-x-2">
        <img src="{{ asset('images/logonew2.png') }}" alt="Logo" class="h-12">
      </div>
      <nav class="hidden md:flex space-x-4 items-center">
        <a href="{{ route('dashboard') }}"
           class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm">
          Dashboard
        </a>
        <a href="{{ url()->previous() }}"
           class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-900 text-sm">
          Go Back
        </a>
      </nav>
    </div>
  </header>

  <div class="max-w-7xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Case Details</h1>

        {{-- Basic Details --}}
        <div class="bg-white rounded shadow mb-6">
        <div class="bg-blue-600 text-white px-4 py-2 rounded-t">
            <h2 class="font-semibold">Basic Details</h2>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div><strong>Court:</strong> {{ $case->court->Court_Name ?? 'N/A' }}</div>
            <div><strong>Name of Judge:</strong> {{ $case->judge->Judge_Name ?? 'N/A' }}</div>
            <div><strong>Case Number:</strong> {{ $case->case_number }}</div>
            <div><strong>Date Of Reference Order:</strong> {{ $case->reference_date }}</div>
            <div><strong>Date of First Mediation:</strong> {{ $case->mediation_date }}</div>

            {{-- Order File --}}
            <div>
            <strong>Order File:</strong>
            @if($case->order_file)
                <a href="{{ asset('storage/'.$case->order_file) }}"
                class="text-blue-600 underline" target="_blank">View Current File</a>
                <button onclick="summarizeOrderFile({{ $case->id }})"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 mt-2">
                Summarize Order
                </button>
            @else
                <span class="text-gray-500">Not uploaded</span>
            @endif
            </div>

            {{-- Case File --}}
            <div>
            <strong>Case File:</strong>
            @if($case->case_file)
                <a href="{{ asset('storage/'.$case->case_file) }}"
                class="text-blue-600 underline" target="_blank">View Current File</a>
                <button onclick="summarizeCaseFile({{ $case->id }})"
                        class="bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700 mt-2">
                Summarize Case
                </button>
            @else
                <span class="text-gray-500">Not uploaded</span>
            @endif
            </div>
        </div>
        </div>

        {{-- Complainant Details --}}
            <div class="bg-white rounded shadow mb-6">
                <div class="bg-green-600 text-white px-4 py-2 rounded-t">
                    <h2 class="font-semibold">Complainant/Petitioner/Appellant Details</h2>
                </div>
               @if ($case->complainant && $case->complainant->complainant_type === 'individual')

                  <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><strong>Name:</strong> {{ $case->complainant->name }}</div>
                    <div><strong>Father's Name:</strong> {{ $case->complainant->father }}</div>
                    <div><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($case->complainant->dob)->format('d-m-Y') }}</div>
                    <div><strong>Gender:</strong> {{ $case->complainant->gender }}</div>
                    <div><strong>Address:</strong> {{ $case->complainant->address }}</div>
                    <div><strong>State:</strong> {{  ucfirst(strtolower($case->complainant->state->name ?? 'N/A')) }}</div>
                    <div><strong>City:</strong> {{ $case->complainant->city->name ?? 'N/A' }}</div>
                    <div><strong>District:</strong> {{ $case->complainant->district  ?? 'N/A' }}</div>
                    <div><strong>Pincode:</strong> {{ $case->complainant->pincode ?? 'N/A' }}</div>
                    <div><strong>Mobile:</strong> {{ $case->complainant->mobile ?? 'N/A' }}</div>
                    <div><strong>Email:</strong> {{ $case->complainant->email ?? 'N/A' }}</div>

                    @if ($case->complainant->id_proof)
                        <div>
                            <strong>ID Proof:</strong><br />
                            <a href="{{ asset('storage/' . $case->complainant->id_proof) }}" target="_blank"
                                class="text-blue-600 underline">View Uploaded File</a>
                        </div>
                      @else
                          <div><strong>ID Proof:</strong> Not uploaded</div>
                      @endif
                  </div>

                @elseif ($case->complainant && $case->complainant->complainant_type === 'entity')

                    <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div><strong>Name of Entity:</strong> {{ $case->complainant->name }}</div>
                        <div><strong>Authorised Representative:</strong> {{ $case->complainant->father }}</div>
                        <div><strong>Date of Incorporation:</strong> {{ \Carbon\Carbon::parse($case->complainant->dob)->format('d-m-Y') }}</div>
                        <div><strong>Address:</strong> {{  $case->complainant->address }}</div>
                        <div><strong>State:</strong> {{  ucfirst(strtolower($case->complainant->state->name ?? 'N/A')) }}</div>
                        <div><strong>City:</strong> {{ $case->complainant->city->name ?? 'N/A' }}</div>
                        <div><strong>Pincode:</strong> {{ $case->complainant->pincode ?? 'N/A' }}</div>
                        <div><strong>Email:</strong> {{ $case->complainant->email ?? 'N/A' }}</div>

                        @if ($case->complainant->id_proof)
                            <div>
                                <strong>Incorporation Certificate:</strong><br />
                                <a href="{{ asset('storage/' . $case->complainant->id_proof) }}" target="_blank"
                                    class="text-blue-600 underline">View Uploaded File</a>
                            </div>
                        @else
                            <div><strong>Incorporation Certificate:</strong> Not uploaded</div>
                        @endif
                    </div>
                @else
                    <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4 shadow">Complainant type not specified.</div>
                @endif
            </div>

            {{-- Defendant Details --}}
            <div class="bg-white rounded shadow mb-6">
                <div class="bg-red-600 text-white px-4 py-2 rounded-t">
                    <h2 class="font-semibold">Defendant/Respondent Details</h2>
                </div>
              @if ($case->defendant && $case->defendant->defendant_type === 'individual')

            <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><strong>Name:</strong> {{ $case->defendant->name }}</div>
                <div><strong>Father's Name:</strong> {{ $case->defendant->father }}</div>
                <div><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($case->defendant->dob)->format('d-m-Y') }}</div>
                <div><strong>Gender:</strong> {{ $case->defendant->gender }}</div>
                <div><strong>Address:</strong> {{ $case->defendant->address }}</div>
                <div><strong>State:</strong> {{  ucfirst(strtolower($case->complainant->state->name ?? 'N/A')) }}</div>
                <div><strong>City:</strong> {{ $case->defendant->city->name ?? 'N/A' }}</div>
                <div><strong>District:</strong> {{ $case->defendant->district  ?? 'N/A' }}</div>
                <div><strong>Pincode:</strong> {{ $case->defendant->pincode }}</div>
                <div><strong>Mobile:</strong> {{ $case->defendant->mobile ?? 'N/A' }}</div>
                <div><strong>Email:</strong> {{ $case->defendant->email }}</div>

                @if ($case->defandant->id_proof)
                    <div>
                        <strong>ID Proof:</strong><br />
                        <a href="{{ asset('storage/' . $case->defandant->id_proof) }}" target="_blank"
                            class="text-blue-600 underline">View Uploaded File</a>
                    </div>
                @else
                    <div><strong>ID Proof:</strong> Not uploaded</div>
                @endif
            </div>

        @elseif ($case->defendant && $case->defendant->defendant_type === 'entity')
            <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><strong>Name of Entity:</strong> {{ $case->defendant->name }}</div>
                <div><strong>Authorised Representative:</strong> {{ $case->defendant->father }}</div>
                <div><strong>Date of Incorporation:</strong> {{ \Carbon\Carbon::parse($case->defendant->dob)->format('d-m-Y') }}</div>
                <div><strong>Address:</strong> {{ $case->defendant->address }}</div>
                <div><strong>State:</strong> {{  ucfirst(strtolower($case->complainant->state->name ?? 'N/A')) }}</div>
                <div><strong>City:</strong> {{ $case->defendant->city->name ?? 'N/A' }}</div>
                <div><strong>Pincode:</strong> {{ $case->defendant->pincode }}</div>
                <div><strong>Email:</strong> {{ $case->defendant->email }}</div>

                @if ($case->defandant->id_proof)
                    <div>
                        <strong>Incorporation Certificate:</strong><br />
                        <a href="{{ asset('storage/' . $case->defandant->id_proof) }}" target="_blank"
                            class="text-blue-600 underline">View Uploaded File</a>
                    </div>
                @else
                    <div><strong>Incorporation Certificate:</strong> Not uploaded</div>
                @endif
            </div>
        @else
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4 shadow">Respondent type not specified.</div>
        @endif
            </div>

            {{-- Advocate & Mediator --}}
            <div class="bg-white rounded shadow mb-6">
                <div class="bg-purple-600 text-white px-4 py-2 rounded-t">
                    <h2 class="font-semibold">Assigned Mediator and Advocates</h2>
                </div>
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>Complainant Advocate:</strong> {{ $case->complainantAdvocate->name ?? 'N/A' }}</div>
                    <div><strong>Defendant Advocate:</strong> {{ $case->defendantAdvocate->name ?? 'N/A' }}</div>
                    <div><strong>Mediator:</strong> {{ $case->mediator->name ?? 'N/A' }}</div>
                </div>
            </div>

            {{-- Classification --}}
            <div class="bg-white rounded shadow mb-6">
                <div class="bg-yellow-600 text-white px-4 py-2 rounded-t">
                    <h2 class="font-semibold">Case Classification</h2>
                </div>
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>Subject:</strong> {{ $case->subject->name ?? 'N/A' }}</div>
                    <div><strong>Issue:</strong> {{ $case->issue->IssueName ?? 'N/A' }}</div>
                    <div><strong>Statute:</strong> {{ $case->statute->Act_Name ?? 'N/A' }}</div>
                    <div><strong>Status:</strong> {{ $case->status }}</div>
                </div>
            </div> 
            <div class="text-center">
                <a href="{{ url()->previous() }}"
                  class="bg-gray-700 text-white px-4 py-2 rounded">
                  Go Back
                </a>
            </div>           
    </div>
    

        <!-- Modal -->
        <div id="summaryModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
          <div class="bg-white rounded-lg p-6 w-full max-w-3xl shadow-xl relative">
            <h2 id="summaryTitle" class="text-xl font-bold mb-4">Summary</h2>

            <div id="loader" class="flex justify-center items-center py-6 hidden">
              <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v8H4z"></path>
              </svg>
              <span class="ml-2 text-indigo-600 font-medium text-sm">Generating summary...</span>
            </div>

            <div id="summaryContent"
                class="max-h-96 overflow-y-auto text-sm text-gray-700 whitespace-pre-line"></div>

            <button onclick="closeSummaryModal()"
                    class="absolute top-2 right-2 text-gray-700 hover:text-red-600 font-bold text-xl">
              &times;
            </button>
          </div>
        </div>

<script>
  function summarizeOrderFile(caseId) {
    openModal("Order File Summary");
    fetchSummary(`/cases/${caseId}/summarize-order`);
  }

  function summarizeCaseFile(caseId) {
    openModal("Case File Summary");
    fetchSummary(`/cases/${caseId}/summarize-case`);
  }

  function openModal(title) {
    document.getElementById('summaryTitle').innerText = title;
    document.getElementById('summaryContent').innerHTML = '';
    document.getElementById('loader').classList.remove('hidden');
    document.getElementById('summaryModal').classList.remove('hidden');
  }

  function closeSummaryModal() {
    document.getElementById('summaryModal').classList.add('hidden');
  }

  function fetchSummary(url) {
    fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      document.getElementById('loader').classList.add('hidden');
      let html = '';

      if (data.dates?.length) {
        html += `<h3 class="font-semibold text-gray-800 mb-1">📅 Key Dates</h3><ul class="list-disc list-inside mb-4">`;
        data.dates.forEach(date => html += `<li>${date}</li>`);
        html += `</ul>`;
      }

      if (data.facts?.length) {
        html += `<h3 class="font-semibold text-gray-800 mb-1">📌 Key Facts</h3><ul class="list-disc list-inside mb-4">`;
        data.facts.forEach(fact => html += `<li>${fact}</li>`);
        html += `</ul>`;
      }

      if (data.summary) {
        html += `<h3 class="font-semibold text-gray-800 mb-1">📝 Summary</h3><p>${data.summary}</p>`;
      }

      if (!html) {
        html = `<p class="text-red-600">⚠️ No structured summary returned.</p>`;
      }

      document.getElementById('summaryContent').innerHTML = html;
    })
    .catch(() => {
      document.getElementById('loader').classList.add('hidden');
      document.getElementById('summaryContent').innerHTML =
        `<p class="text-red-600">⚠️ Something went wrong.</p>`;
    });
  }
</script>
</body>
</html>
