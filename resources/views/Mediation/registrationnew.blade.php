<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <title>Mediation Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fira Sans', sans-serif;
            background-color: #EDF3FF;
            font-size: 15px;
        }
        .small-btn {
            font-size: 12px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
	

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
<form method="POST" action="{{ route('mediation.store') }}" enctype="multipart/form-data">
					@csrf
					@if ($errors->any())
						<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4">
								<ul class="list-disc pl-5">
										@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
										@endforeach
								</ul>
						</div>
				@endif


<!-- Remove body padding as it's no longer needed -->
<style>
    body {
        padding-top: 0;
    }
</style>

<!-- Mobile Dropdown Menu -->
<div id="mobile-menu" class="hidden md:hidden bg-white border-t shadow-md w-full absolute left-0 top-0 z-40">
    <ul class="flex flex-col space-y-2 p-4">
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Manage Cases</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Appellant</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Respondent</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Advocates</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Mediator (Retired Judge)</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Court</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Subject</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Issue</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Statute</a></li>
        <li><a href="#" class="text-gray-600 hover:text-blue-500">Users</a></li>
        <li>
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm w-full">LOG OUT</button>
        </li>
    </ul>
</div>

<!-- JavaScript for Mobile Menu -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("menu-toggle").addEventListener("click", function () {
            let mobileMenu = document.getElementById("mobile-menu");
            mobileMenu.classList.toggle("hidden");
        });
    });
</script>

  
<!-- Header Ends-->

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-6">
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-700 mb-2 text-center">Mediation Registration</h2>
			<p class="text-sm text-gray-600 text-center mb-6">Fill the form below for mediation registration.</p>
            <form id="your-form-id" onsubmit="validateForm(event)">

              <!-- Basic Details Starts -->

			
				<!-- Basic Details Accordion -->
									<div class="bg-gradient-to-b from-gray-50 to-gray-100 border border-gray-300 rounded-lg shadow-lg mb-6">
										<!-- Accordion Header -->
										<div class="flex justify-between items-center p-4 bg-[#017AFF] text-white rounded-t-lg cursor-pointer" onclick="toggleAccordion()">
											<legend class="text-md font-bold tracking-wide">Basic Details</legend>
											<span id="accordion-icon" class="transform transition-transform duration-300">&#9660;</span>
										</div>

										<!-- Accordion Content -->
										<fieldset id="accordion-content" class="p-6 bg-white space-y-8 rounded-b-lg shadow-sm transition-all duration-500">

											<!-- First Row: 3 Columns -->
											<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
												<!-- Court Dropdown -->
												<div>
													<label class="block text-gray-700 font-semibold text-sm">Court<span class="text-red-500">*</span></label>
													<select id="court_select" name="court_id" required class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" >
														<option value="">Select Court</option>
														@foreach ($courts as $court)
															<option value="{{ $court->AG_Courtcode }}" {{ old('court_id') == $court->AG_Courtcode ? 'selected' : '' }}>
																{{ $court->Court_Name }}
															</option>
														@endforeach
													</select>
												</div>

												<!-- Judge Name Input with Autocomplete -->
												<div>
													<label class="block text-gray-700 font-semibold text-sm">Name of Judge<span class="text-red-500">*</span></label>
													<input type="text" name="judge_name" id="judge_name_input"
														list="judge_suggestions"
														value="{{ old('judge_name') }}"
														class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105"
														autocomplete="off"
														placeholder="Enter Judge name...">
													<datalist id="judge_suggestions"></datalist>
												</div>

												<div>
													<label class="block text-gray-700 font-semibold text-sm">Case Number<span class="text-red-500">*</span></label>
													<input 
														type="text" 
														name="case_number" 
														value="{{ old('case_number') }}" 
														class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105 @error('case_number') border-red-600 @enderror" 
														placeholder="Enter Case Number"
													>
													@error('case_number')
														<p class="text-red-600 text-sm mt-1">{{ $message }}</p>
													@enderror
												</div>
											</div>

											<!-- Second Row: 4 Columns -->
											<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
												<div>
													<label class="block text-gray-700 font-semibold text-sm">Date Of Reference Order<span class="text-red-500">*</span></label>
													<input type="date" name="reference_date" value="{{ old('reference_date') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
												</div>
												<div>
													<label class="block text-gray-700 font-semibold text-sm">Date of First Mediation<span class="text-red-500">*</span></label>
													<input type="date" name="mediation_date" value="{{ old('mediation_date') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
												</div>
												<div>
													<label class="block text-gray-700 font-semibold text-sm">Order of Court Referring To Mediation</label>
													<input type="file" name="order_file" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none file:bg-blue-700 file:text-white file:px-3 file:py-2 file:rounded-lg file:border-none file:cursor-pointer hover:file:bg-blue-600 transition-all">
												</div>
												<div>
													<label class="block text-gray-700 font-semibold text-sm">Case File</label>
													<input type="file" name="case_file" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none file:bg-blue-700 file:text-white file:px-3 file:py-2 file:rounded-lg file:border-none file:cursor-pointer hover:file:bg-blue-600 transition-all">
												</div>
											</div>
										</fieldset>
									</div>

									<script>
										function toggleAccordion() {
											const content = document.getElementById("accordion-content");
											const icon = document.getElementById("accordion-icon");
											content.classList.toggle("hidden");
											icon.style.transform = content.classList.contains("hidden") ? "rotate(180deg)" : "rotate(0deg)";
										}

										document.getElementById('judge_name_input').addEventListener('input', function () {
											const query = this.value;
											const courtSelect = document.querySelector('select[name="court_id"]');
											const courtId = courtSelect ? courtSelect.value : '';

											if (query.length >= 1) {
												fetch(`/judge-suggestions?query=${encodeURIComponent(query)}&court_id=${encodeURIComponent(courtId)}`)
													.then(response => response.json())
													.then(data => {
														const datalist = document.getElementById('judge_suggestions');
														datalist.innerHTML = '';
														data.forEach(judge => {
															const option = document.createElement('option');
															option.value = judge.Judge_Name;
															datalist.appendChild(option);
														});
													});
											}
										});

										// Re-trigger suggestions if judge_name has old value
										window.addEventListener('DOMContentLoaded', function () {
											const judgeInput = document.getElementById('judge_name_input');
											if (judgeInput.value.length > 0) {
												judgeInput.dispatchEvent(new Event('input'));
											}
										});
									</script>

								
								
								<!-- Basic Details Ends -->

              <!-- Complainant/Petitioner/Appellant Details Accordion -->

              
						<div class="bg-gradient-to-b from-gray-50 to-gray-100 border border-gray-300 rounded-lg shadow-lg mb-6">
							<!-- Accordion Header -->
							<div class="flex justify-between items-center p-4 bg-[#28A644] text-white rounded-t-lg cursor-pointer" onclick="toggleComplainantAccordion()">
								<legend class="text-md font-bold tracking-wide">Complainant/Petitioner/Appellant Details</legend>
								<span id="complainant-accordion-icon" class="transform transition-transform duration-300">&#9660;</span>
							</div>

							<!-- Accordion Content -->
							<fieldset id="complainant-accordion-content" class="p-6 bg-white space-y-8 rounded-b-lg shadow-sm hidden transition-all duration-500">
								
								<!-- First Row: 4 Columns -->
								
								<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
									<div>
										<label class="block text-gray-700 font-semibold text-sm">Name<span class="text-red-500">*</span></label>
										<input type="text" name="complainant_name" value="{{ old('complainant_name') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" placeholder="Enter respondent's name">
									</div>
									<div>
										<label class="block text-gray-700 font-semibold text-sm">Father's Name</label>
										<input type="text" name="complainant_father" value="{{ old('complainant_father') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" placeholder="Enter father's name">
									</div>
									<div>
										<label class="block text-gray-700 font-semibold text-sm">Date of Birth<span class="text-red-500">*</span></label>
										<input type="date" name="complainant_dob" value="{{ old('complainant_dob') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
									</div>
									<div>
											<label for="complainant_gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
												<select id="complainant_gender" name="complainant_gender" 
													class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
													<option value="">Select Gender</option>
													<option value="Male" {{ old('complainant_gender') == 'Male' ? 'selected' : '' }}>Male</option>
													<option value="Female" {{ old('complainant_gender') == 'Female' ? 'selected' : '' }}>Female</option>
													<option value="Other" {{ old('complainant_gender') == 'Other' ? 'selected' : '' }}>Other</option>
												</select>

									</div>

								</div>

								<!-- Second Row: 5 Columns -->
								<div class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-6">
									<div>
										<label class="block text-gray-700 font-semibold text-sm">Address</label>
										<input type="text" name="complainant_address" value="{{ old('complainant_address') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" placeholder="Enter address">
									</div>

									<div>
										<label class="block text-gray-700 font-semibold text-sm">State</label>
										<select 
												name="complainant_state_id" 
												class="state-select p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105"  
												id="state_select_1"
												data-old-state="{{ old('complainant_state_id') }}"
												data-old-city="{{ old('complainant_city_id') }}"
												data-target="#city_select_1"
											>

												<option value="">Select State</option>
												@foreach ($states as $state)
														<option value="{{ $state->id }}" {{ old('complainant_state_id') == $state->id ? 'selected' : '' }}>
																{{ ucfirst(strtolower($state->name)) }}
														</option>
												@endforeach
										</select>

								 </div>
								
									<div>
										<label class="block text-gray-700 font-semibold text-sm">City</label>
										<select 
												name="complainant_city_id" 
												class="city-select p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" 
												id="city_select_1"
										>
												<option value="">Select City</option>
												@foreach ($cities as $city)
														<option value="{{ $city->id }}" {{ old('complainant_city_id') == $city->id ? 'selected' : '' }}>
																{{ $city->name }}
														</option>
												@endforeach
										</select>

								  </div>
									<div>
										<label class="block text-gray-700 font-semibold text-sm">District</label>
										<input type="text" name="complainant_district" value="{{ old('complainant_district') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" placeholder="Enter district">
									</div>
									
									<div>
										<label class="block text-gray-700 font-semibold text-sm">Pincode</label>
										<input type="text" name="complainant_pincode" value="{{ old('complainant_pincode') }}"  class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" placeholder="Enter pincode">
									</div>
								</div>

								<!-- Third Row: Mobile & Email -->
								<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
										<!-- Mobile Section -->
										<div>
												<label for="complainant_mobile" class="block text-gray-700 font-semibold text-sm">Mobile</label>
												<input 
														id="complainant_mobile"
														type="tel" 
														name="complainant_mobile" 
														value="{{ old('complainant_mobile') }}" 
														autocomplete="tel"
														pattern="[0-9]{10}"
														class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105 @error('complainant_mobile') border-red-600 @enderror" 
														placeholder="Mobile number"
												>
												@error('complainant_mobile')
														<p class="text-red-600 text-sm mt-1">{{ $message }}</p>
												@enderror
										</div>

										<!-- Email Section -->
										<div>
												<label for="complainant_email" class="block text-gray-700 font-semibold text-sm">Email<span class="text-red-500">*</span></label>
												<input 
														id="complainant_email"
														type="email" 
														name="complainant_email" 
														value="{{ old('complainant_email') }}" 
														autocomplete="email"
														class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105 @error('complainant_email') border-red-600 @enderror" 
														placeholder="Email"
												>
												@error('complainant_email')
														<p class="text-red-600 text-sm mt-1">{{ $message }}</p>
												@enderror
										</div>
								</div>


								<!-- Fourth Row: Upload ID Proof -->
								<div class="mt-6">
									<label class="block text-gray-700 font-semibold text-sm">Upload ID Proof</label>
									<input type="file" name="complainant_id_proof" value="{{ old('complainant_id_proof') }}"  class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none file:bg-blue-700 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-none file:cursor-pointer hover:file:bg-blue-600 transition-all">
								</div>

								<!-- Buttons Row -->
								<div class="mt-6 flex justify-end space-x-4">
									<button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all">Save</button>
									<button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all">Save and Add Another</button>
									<button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all">Send Notice</button>
								</div>

							</fieldset>
						</div>

						<script>
							function toggleComplainantAccordion() {
								const content = document.getElementById("complainant-accordion-content");
								const icon = document.getElementById("complainant-accordion-icon");
								content.classList.toggle("hidden");
								icon.style.transform = content.classList.contains("hidden") ? "rotate(180deg)" : "rotate(0deg)";
							}
						</script>

              
            
            <!-- Complainant/Petitioner/Appellant Details Ends -->

             <!-- Defendant (Multiple) Details -->

          
					  <div class="bg-gradient-to-b from-gray-50 to-gray-100 border border-gray-300 rounded-lg shadow-lg mb-6">
						<!-- Accordion Header -->
						<div class="flex justify-between items-center p-4 bg-[#17A2B8] text-white rounded-t-lg cursor-pointer" onclick="toggleDefendantAccordion()">
							<legend class="text-md font-bold tracking-wide">Defendent/Respondent Details</legend>
							<span id="defendant-accordion-icon" class="transform transition-transform duration-300">&#9660;</span>
						</div>

						<!-- Accordion Content -->
						<fieldset id="defendant-accordion-content" class="p-6 bg-white space-y-8 rounded-b-lg shadow-sm hidden transition-all duration-500">
							
							<!-- First Row: 4 Columns -->
							<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Name<span class="text-red-500">*</span></label>
									<input type="text" name="defendant_name" value="{{ old('defendant_name') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm" placeholder="Enter respondent's name">
								</div>
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Father's Name</label>
									<input type="text" name="defendant_father" value="{{ old('defendant_father') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm" placeholder="Enter father's name">
								</div>
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Date of Birth<span class="text-red-500">*</span></label>
									<input type="date" name="defendant_dob" value="{{ old('defendant_dob') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm">
								</div>
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Gender</label>
									<select name="defendant_gender" 
											class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
											<option value="">Select Gender</option>
											<option value="Male" {{ old('defendant_gender') == 'Male' ? 'selected' : '' }}>Male</option>
											<option value="Female" {{ old('defendant_gender') == 'Female' ? 'selected' : '' }}>Female</option>
											<option value="Other" {{ old('defendant_gender') == 'Other' ? 'selected' : '' }}>Other</option>
									</select>
							</div>

							</div>

							<!-- Second Row: 5 Columns -->
							<div class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-6">
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Address</label>
									<input type="text" name="defendant_address" value="{{ old('defendant_address') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm" placeholder="Enter address">
								</div>
								<div>
										<label class="block text-gray-700 font-semibold text-sm">State</label>
										<select 
												name="defendant_state_id" 
												class="state-select p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105"  
												id="state_select_2"
												data-old-state="{{ old('defendant_state_id') }}"
												data-old-city="{{ old('defendant_city_id') }}"
												data-target="#city_select_2"
											>
												<option value="">Select State</option>
												@foreach ($states as $state)
														<option value="{{ $state->id }}" {{ old('defendant_state_id') == $state->id ? 'selected' : '' }}>
																{{ ucfirst(strtolower($state->name)) }}
														</option>

												@endforeach
										</select>
								</div>
								<div>
									<label class="block text-gray-700 font-semibold text-sm">City</label>
									<select name="defendant_city_id" class="city-select  p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" id="city_select_2" name="city_id_2">
											<option value="">Select City</option>
											@foreach ($cities as $city)
														<option value="{{ $city->id }}" {{ old('complainant_city_id') == $city->id ? 'selected' : '' }}>
																{{ $city->name }}
														</option>
												@endforeach
									</select>
							</div>
									<div>
										<label class="block text-gray-700 font-semibold text-sm">District</label>
										<input type="text" name="defendant_district" value="{{ old('defendant_district') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" placeholder="Enter district">
									</div>
									
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Pincode</label>
									<input type="text" name="defendant_pincode" value="{{ old('defendant_pincode') }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm" placeholder="Enter pincode">
								</div>
							</div>

							<!-- Third Row: Mobile & Email -->
							<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
									<!-- Mobile Section -->
									<div>
											<label for="defendant_mobile" class="block text-gray-700 font-semibold text-sm">Mobile</label>
											<input 
													id="defendant_mobile"
													type="tel" 
													name="defendant_mobile" 
													value="{{ old('defendant_mobile') }}" 
													autocomplete="tel"
													inputmode="numeric"
													pattern="^[0-9]{10}$"
													required
													class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105 @error('defendant_mobile') border-red-600 @enderror" 
													placeholder="Enter 10-digit mobile number"
											>
											@error('defendant_mobile')
													<p class="text-red-600 text-sm mt-1">{{ $message }}</p>
											@enderror
									</div>

									<!-- Email Section -->
									<div>
											<label for="defendant_email" class="block text-gray-700 font-semibold text-sm">Email<span class="text-red-500">*</span></label>
											<input 
													id="defendant_email"
													type="email" 
													name="defendant_email" 
													value="{{ old('defendant_email') }}" 
													autocomplete="email"
													required
													class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105 @error('defendant_email') border-red-600 @enderror" 
													placeholder="Enter email address"
											>
											@error('defendant_email')
													<p class="text-red-600 text-sm mt-1">{{ $message }}</p>
											@enderror
									</div>
							</div>

							<!-- Fourth Row: Upload ID Proof -->
								<div class="mt-6">
									<label class="block text-gray-700 font-semibold text-sm">Upload ID Proof</label>
									<input type="file" name="defandant_id_proof" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none file:bg-blue-700 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-none file:cursor-pointer hover:file:bg-blue-600 transition-all">
								</div>

							<!-- Action Buttons -->
							<div class="flex justify-end space-x-4 mt-6">
								<button class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-all">Save</button>
								<button class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-400 transition-all">Save and Add Another</button>
								<button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-500 transition-all">Send Notice</button>
							</div>
						</fieldset>
					</div>

					<script>
						function toggleDefendantAccordion() {
							const content = document.getElementById("defendant-accordion-content");
							const icon = document.getElementById("defendant-accordion-icon");
							content.classList.toggle("hidden");
							icon.style.transform = content.classList.contains("hidden") ? "rotate(180deg)" : "rotate(0deg)";
						}
					</script>

             <!-- Defendant Ends -->


						<!-- Assigned moderator ands advocates Details -->

					 <div class="bg-gradient-to-b from-gray-50 to-gray-100 border border-gray-300 rounded-lg shadow-lg mb-6">
						<!-- Accordion Header -->
						<div class="flex justify-between items-center p-4 bg-[#FEC106] text-white rounded-t-lg cursor-pointer" onclick="toggleModeratorAccordion()">
							<legend class="text-md font-bold tracking-wide">Assigned Moderator and Advocates</legend>
							<span id="moderator-accordion-icon" class="transform transition-transform duration-300">&#9660;</span>
						</div>

						<!-- Accordion Content -->
						<fieldset id="moderator-accordion-content" class="p-6 bg-white space-y-6 rounded-b-lg shadow-sm hidden transition-all duration-500">
							
							<!-- Fields in Single Row -->
							<!-- Advocates and Mediators selection + Add new buttons -->
							<div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
								@php
									use App\Models\Advocate;
									use App\Models\Mediator;

									$complainantAdvocateName = null;
									if (old('complainant_advocate_id')) {
											$advocate = Advocate::find(old('complainant_advocate_id'));
											$complainantAdvocateName = $advocate ? $advocate->name : old('complainant_advocate_name');
									} else {
											$complainantAdvocateName = old('complainant_advocate_name');
									}
									// Defendant Advocate
									$defendantAdvocateName = null;
									if (old('defendant_advocate_id')) {
										$advocate = Advocate::find(old('defendant_advocate_id'));
										$defendantAdvocateName = $advocate ? $advocate->name : old('defendant_advocate_name');
									} else {
										$defendantAdvocateName = old('defendant_advocate_name');
									}

									// Mediator
									$mediatorName = null;
									if (old('mediator_id')) {
										$mediator = Mediator::find(old('mediator_id'));
										$mediatorName = $mediator ? $mediator->name : old('mediator_name');
									} else {
										$mediatorName = old('mediator_name');
									}
							@endphp

  
								<!-- Complainant Advocate -->
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Complainant Advocate</label>
									<div class="flex items-center space-x-2">
											<div class="w-full">
													<input type="text" id="complainant_advocate_name"
															name="complainant_advocate_name"
															value="{{ $complainantAdvocateName }}"
															class="p-3 border border-gray-300 rounded-lg w-full"
															placeholder="Search Advocate">

													<input type="hidden" name="complainant_advocate_id" id="complainant_advocate_id"
															value="{{ old('complainant_advocate_id') }}">
											</div>
											<button type="button" onclick="openAdvocateModal()"
													class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">Add New</button>
									</div>
							</div>

								<!-- Defendant Advocate -->
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Defendant Advocate</label>
									<div class="flex items-center space-x-2">
										<div class="w-full">
											<input type="text" id="defendant_advocate_name"
														name="defendant_advocate_name"
														value="{{ $defendantAdvocateName }}"
														class="p-3 border border-gray-300 rounded-lg w-full"
														placeholder="Search Advocate">

											<input type="hidden" name="defendant_advocate_id" id="defendant_advocate_id"
														value="{{ old('defendant_advocate_id') }}">
										</div>
										<button type="button" onclick="openAdvocateModal()"
														class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">
											Add New
										</button>
									</div>
								</div>


								<!-- Mediator -->
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Mediator</label>
									<div class="flex items-center space-x-2">
										<div class="w-full">
											<input type="text" id="mediator_name"
														name="mediator_name"
														value="{{ $mediatorName }}"
														class="p-3 border border-gray-300 rounded-lg w-full"
														placeholder="Search Mediator">

											<input type="hidden" name="mediator_id" id="mediator_id"
														value="{{ old('mediator_id') }}">
										</div>
										<button type="button" onclick="openMediatorModal()"
														class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">
											Add New
										</button>
									</div>
								</div>




						</fieldset>
					</div>

					<script>
						function toggleModeratorAccordion() {
							const content = document.getElementById("moderator-accordion-content");
							const icon = document.getElementById("moderator-accordion-icon");
							content.classList.toggle("hidden");
							icon.style.transform = content.classList.contains("hidden") ? "rotate(180deg)" : "rotate(0deg)";
						}
					</script>


          <!-- Assigned moderator ands advocates Ends -->

					<!-- Case Classification -->

					<div class="bg-gradient-to-b from-gray-50 to-gray-100 border border-gray-300 rounded-lg shadow-lg mb-6">
						<!-- Accordion Header -->
						<div class="flex justify-between items-center p-4 bg-[#DD3445] text-white rounded-t-lg cursor-pointer" onclick="toggleCaseClassificationAccordion()">
							<legend class="text-md font-bold tracking-wide">Case Classification</legend>
							<span id="case-classification-accordion-icon" class="transform transition-transform duration-300">&#9660;</span>
						</div>

						<!-- Accordion Content -->
						<fieldset id="case-classification-accordion-content" class="p-6 bg-white space-y-6 rounded-b-lg shadow-sm hidden transition-all duration-500">
							
							<!-- Fields in Single Row -->
							<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
							<!-- Subject -->
							<div>
									<label class="block text-gray-700 font-semibold text-sm">Subject</label>
									<select name="subject_id" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
											<option value="">Select Subject</option>
											@foreach ($subjects as $subject)
													<option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
															{{ $subject->name }}
													</option>
											@endforeach
									</select>
							</div>

							<!-- Issue -->
							<div>
									<label class="block text-gray-700 font-semibold text-sm">Issue</label>
									<select name="issue_id" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
											<option value="">Select Issue</option>
											@foreach ($issues as $issue)
													<option value="{{ $issue->Issue_Code }}" {{ old('issue_id') == $issue->Issue_Code ? 'selected' : '' }}>
															{{ $issue->IssueName }}
													</option>
											@endforeach
									</select>
							</div>

							<!-- Statute -->
							<div>
									<label class="block text-gray-700 font-semibold text-sm">Statute</label>
									<select name="statute_id" class="p-3 border border-gray-300 bg-white rounded-lg w-full">
											<option value="">Select Statute</option>
											@foreach ($statutes as $statute)
													<option value="{{ $statute->AG_StatuteCode }}" {{ old('statute_id') == $statute->AG_StatuteCode ? 'selected' : '' }}>
															{{ $statute->Act_Name }}
													</option>
											@endforeach
									</select>
							</div>


					</fieldset>
				</div>

					<script>
						function toggleCaseClassificationAccordion() {
							const content = document.getElementById("case-classification-accordion-content");
							const icon = document.getElementById("case-classification-accordion-icon");
							content.classList.toggle("hidden");
							icon.style.transform = content.classList.contains("hidden") ? "rotate(180deg)" : "rotate(0deg)";
						}
					</script>
 


			<!-- Case Classification Ends-->

			</form>
				   <!-- Alert Box -->
					  <script>
					  function validateForm(event) {
						  event.preventDefault(); // Prevent form submission
						  let missingFields = [];

						  // Select all required input and select fields
						  const requiredFields = document.querySelectorAll("input, select");

						  requiredFields.forEach(field => {
							  if (field.value.trim() === "") {
								  const label = field.closest("div").querySelector("label"); // Get the field label
								  const fieldName = label ? label.innerText : "A required field";
								  missingFields.push(fieldName);
							  }
						  });

						  if (missingFields.length > 0) {
							  alert("Please fill in the following required fields:\n" + missingFields.join("\n"));
						  } else {
							  alert("Form submitted successfully!"); 
							  document.getElementById("your-form-id").submit();
						  }
					  }
					  </script>
          <!-- Alert Box Ends-->

					<div class="flex justify-center mt-6">
						<button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-blue-600">
							Save
						</button>
					</div>

					
				</form>
        </section>
    </main>
		<!-- Footer -->
				<footer class="bg-gray-800 text-white text-center py-4 mt-6">
					© 2025 Fast and Fair Arbitration. All rights reserved.
				</footer>


													<!-- AJAX to dynamically fetch cities based on the selected state -->
														<script>
																document.addEventListener("DOMContentLoaded", function () {
																	document.querySelectorAll('.state-select').forEach(stateDropdown => {
																		const citySelector = stateDropdown.getAttribute('data-target');
																		const cityDropdown = document.querySelector(citySelector);

																		// Get old values from data attributes (if present)
																		const oldStateId = stateDropdown.dataset.oldState;
																		const oldCityId = stateDropdown.dataset.oldCity;

																		// If old state and city exist (form error case), prepopulate
																		if (oldStateId && oldCityId) {
																			fetchCities(oldStateId, oldCityId, cityDropdown);
																	}

																		// On state change
																		stateDropdown.addEventListener('change', function () {
																			const stateId = this.value;
																			if (stateId) {
																				fetchCities(stateId, null, cityDropdown); // Clear city selection
																			} else {
																				cityDropdown.innerHTML = '<option value="">Select City</option>';
																			}
																		});
																	});

																	function fetchCities(stateId, selectedCityId = null, cityDropdown) {
																		fetch(`/fetch-cities?state_id=${stateId}`)
																			.then(response => response.json())
																			.then(data => {
																				cityDropdown.innerHTML = '<option value="">Select City</option>';
																				data.cities.forEach(city => {
																					const option = document.createElement('option');
																					option.value = city.id;
																					option.textContent = city.name;
																					if (selectedCityId && city.id == selectedCityId) {
																						option.selected = true;
																					}
																					cityDropdown.appendChild(option);
																				});
																			});
																	}
																});
															</script>

													
												</div>
											</div>
										</div>

								<!-- Advocate Modal -->
								<div id="advocateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 h-screen">
										<div class="bg-white p-6 rounded-lg max-w-md w-full space-y-4">
												<h2 class="text-lg font-semibold">Add New Advocate</h2>
												<form id="advocateForm">
														@csrf
														<input type="text" name="name" placeholder="Name" class="w-full p-2 border rounded" required>
														<input type="text" name="bar_number" placeholder="Bar Number" class="w-full p-2 border rounded mt-2" required>
														<input type="text" name="mobile" placeholder="Mobile" class="w-full p-2 border rounded mt-2" required>
														<input type="email" name="emailId" placeholder="Email" class="w-full p-2 border rounded mt-2" required>


														<div class="flex justify-end pt-3">
																<button type="button" onclick="closeAdvocateModal()" class="px-4 py-2 mr-2 text-gray-600">Cancel</button>
																<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
														</div>
												</form>
										</div>
								</div>

								<!-- Mediator Modal -->
								<div id="mediatorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 h-screen">
										<div class="bg-white p-6 rounded-lg max-w-md w-full space-y-4">
												<h2 class="text-lg font-semibold">Add New Mediator</h2>
												<form id="mediatorForm">
														@csrf
														<input type="text" name="name" placeholder="Name" class="w-full p-2 border rounded" required>
														<input type="text" name="qualification" placeholder="Specialization" class="w-full p-2 border rounded mt-2" required>
														<input type="text" name="address" placeholder="Address" class="w-full p-2 border rounded mt-2" required>
														<input type="text" name="mobile" placeholder="Mobile" class="w-full p-2 border rounded mt-2" required>
														<input type="email" name="emailId" placeholder="Email" class="w-full p-2 border rounded mt-2" required>

														<div class="flex justify-end pt-3">
																<button type="button" onclick="closeMediatorModal()" class="px-4 py-2 mr-2 text-gray-600">Cancel</button>
																<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
														</div>
												</form>
										</div>
								</div>

								<!-- Flash message container -->
								<div id="flash-message" class="fixed top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded text-white bg-green-600 opacity-0 transition-opacity duration-1000 z-50 hidden">
										<span id="flash-text"></span>
								</div>

								<script>
											// Modal open/close functions
											function openAdvocateModal() {
												document.getElementById('advocateModal').classList.remove('hidden');
											}

											function closeAdvocateModal() {
												document.getElementById('advocateModal').classList.add('hidden');
											}

											function openMediatorModal() {
												document.getElementById('mediatorModal').classList.remove('hidden');
											}

											function closeMediatorModal() {
												document.getElementById('mediatorModal').classList.add('hidden');
											}

											function showFlashMessage(message, type = 'success') {
												const flashMessage = document.getElementById('flash-message');
												const flashText = document.getElementById('flash-text');

												flashText.textContent = message;
												flashMessage.classList.remove('hidden', 'opacity-0', 'bg-green-600', 'bg-red-600');
												flashMessage.classList.add(type === 'success' ? 'bg-green-600' : 'bg-red-600', 'opacity-100');

												setTimeout(() => {
													flashMessage.classList.remove('opacity-100');
													flashMessage.classList.add('opacity-0');
												}, 2000);

												setTimeout(() => {
													flashMessage.classList.add('hidden');
												}, 4000);
											}

											document.addEventListener('DOMContentLoaded', function () {
												const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

												// Advocate form submit
												const advocateForm = document.getElementById('advocateForm');
												if (advocateForm) {
													advocateForm.addEventListener('submit', function (e) {
														e.preventDefault();
														const formData = new FormData(this);

														// Append CSRF token if missing
														if (!formData.has('_token')) {
															formData.append('_token', csrfToken);
														}

														fetch("{{ route('advocates.store') }}", {
															method: "POST",
															headers: {
																'Accept': 'application/json' //  important fix
															},
															body: formData
														})
														.then(async res => {
															const text = await res.text();

															if (!res.ok) {
																try {
																	const json = JSON.parse(text);
																	if (json.errors) {
																		throw new Error(Object.values(json.errors).flat().join(', '));
																	}
																	throw new Error(json.message || 'Unknown error occurred.');
																} catch (e) {
																	throw new Error('Unexpected response: ' + text);
																}
															}

															return JSON.parse(text);
														})
														.then(data => {
															if (data.advocate) {
																const option = new Option(`${data.advocate.name} (${data.advocate.bar_number})`, data.advocate.id);

																document.getElementById('complainant_advocate_id').appendChild(option.cloneNode(true));
																document.getElementById('defendant_advocate_id').appendChild(option.cloneNode(true));

																document.getElementById('complainant_advocate_id').value = data.advocate.id;
																document.getElementById('defendant_advocate_id').value = data.advocate.id;

																closeAdvocateModal();
																advocateForm.reset();

																// Show success message
																showFlashMessage('Advocate added successfully and login credentials sent to email!');
															} else if (data.errors) {
																alert('Error: ' + Object.values(data.errors).flat().join(', '));
															}
														})
														.catch(error => {
															alert('Failed to save advocate. Please try again.\nDetails: ' + error.message);
														});
													});
												}
	


												// Mediator form submit
												const mediatorForm = document.getElementById('mediatorForm');
												if (mediatorForm) {
														mediatorForm.addEventListener('submit', function (e) {
																e.preventDefault();
																const formData = new FormData(this);

																if (!formData.has('_token')) {
																		formData.append('_token', csrfToken);
																}

																fetch("{{ route('mediators.store') }}", {
																		method: "POST",
																		headers: {
																		'Accept': 'application/json' //important fix
																	},
																		body: formData
																})
																.then(async res => {
																		if (!res.ok) {
																				const errorText = await res.text();
																				console.error('Mediator Save Error:', errorText);
																				throw new Error(errorText);
																		}
																		return res.json();
																})
																.then(data => {
																		if (data.mediator) {
																				const option = new Option(`${data.mediator.name} (${data.mediator.qualification})`, data.mediator.id);
																				document.getElementById('mediator_id').appendChild(option.cloneNode(true));
																				document.getElementById('mediator_id').value = data.mediator.id;

																				closeMediatorModal();
																				mediatorForm.reset();

																				// Show success message
																				showFlashMessage('Mediator added successfully and login credentials sent to email!');
																		} else if (data.errors) {
																				alert('Error: ' + Object.values(data.errors).flat().join(', '));
																		}
																})
																.catch(error => {
																		alert('Failed to save mediator. Please try again.\nDetails: ' + error.message);
																});
														});
												}
										});
								</script>


								<!-- To show the advocate suggestion and prevent duplicate selection -->
								<script>
								$(function () {
										let selectedAdvocateIds = {
												complainant: null,
												defendant: null
										};

										function setupAdvocateAutocomplete(inputSelector, hiddenSelector, getOtherSelectedId) {
												$(inputSelector).autocomplete({
														source: function (request, response) {
																$.ajax({
																		url: '/autocomplete/advocates', 
																		data: { term: request.term },
																		success: function (data) {
																				// Filter out the advocate selected in the other field to prevent duplication
																				const filtered = data.filter(item => item.id != getOtherSelectedId());
																				response(filtered);
																		}
																});
														},
														minLength: 1,
														select: function (event, ui) {
																$(inputSelector).val(ui.item.label); 
																$(hiddenSelector).val(ui.item.id);   

																// Save selected advocate ID
																if (inputSelector === '#complainant_advocate_name') {
																		selectedAdvocateIds.complainant = ui.item.id;
																} else if (inputSelector === '#defendant_advocate_name') {
																		selectedAdvocateIds.defendant = ui.item.id;
																}


																if (inputSelector === '#complainant_advocate_name') {
																		$("#defendant_advocate_name").autocomplete("search", $("#defendant_advocate_name").val());
																} else if (inputSelector === '#defendant_advocate_name') {
																		$("#complainant_advocate_name").autocomplete("search", $("#complainant_advocate_name").val());
																}

																return false;
														}
												});
										}

										// advocate autocompletes 
										setupAdvocateAutocomplete(
												"#complainant_advocate_name",
												"#complainant_advocate_id",
												() => selectedAdvocateIds.defendant
										);

										setupAdvocateAutocomplete(
												"#defendant_advocate_name",
												"#defendant_advocate_id",
												() => selectedAdvocateIds.complainant
										);

										// Mediator autocomplete 
										$("#mediator_name").autocomplete({
												source: function (request, response) {
														$.ajax({
																url: '/autocomplete/mediators',
																data: { term: request.term },
																success: function (data) {
																		response(data);
																}
														});
												},
												minLength: 1,
												select: function (event, ui) {
														$("#mediator_id").val(ui.item.id);
												}
										});
								});
								</script>

</body>
</html>