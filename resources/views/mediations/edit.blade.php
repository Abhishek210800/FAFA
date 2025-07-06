<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fast and Fair Arbitration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
</head>

<body class="bg-gray-100">

    <div class="max-w-6xl mx-auto p-6 bg-white rounded shadow mt-8">

        <h1 class="text-3xl font-bold mb-8">Edit Case - {{ $mediation->case_number }}</h1>

        <form action="{{ route('mediation.update', $mediation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-6">
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-700 mb-2 text-center">Mediation Registration</h2>
			
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
										<label class="block text-gray-700 font-semibold text-sm">Court</label>
                                        <input type="text" 
                                            name="court_display" 
                                            id="court_display"
                                            value="{{ old('court_display', $mediation->court->Court_Name ?? 'Unknown') }}"
                                            class="w-full border p-2 rounded bg-gray-100 text-gray-700"
                                            readonly>

                                        <input type="hidden" name="court_id" value="{{ str_pad($mediation->court_id, 3, '0', STR_PAD_LEFT) }}">
                                    
		
								</div>

								<!-- Judge Name Input with Autocomplete -->
									<div>
											<label class="block text-gray-700 font-semibold text-sm">Name of Judge</label>                                                      

											<input type="text" 
                        name="judge_display" 
                        id="judge_display"
                        value="{{ old('judge_display', $mediation->judge->Judge_Name ?? 'Unknown') }}"
                        class="p-3 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105"
                        autocomplete="off"readonly>

                        <input type="hidden" name="judge_id" value="{{ $mediation->judge_id }}">

                                                    
											<datalist id="judge_suggestions"></datalist>
									</div>

								<div>
									<label class="block text-gray-700 font-semibold text-sm">Case Number</label>                                                  

									<input 
											type="text" 
											name="case_number" 
											value="{{ old('case_number', $mediation->case_number) }}" 
                                            id="case_number" 
											class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105 @error('case_number') border-red-600 @enderror" 
											placeholder="Enter Case Number" readonly
									>
									
							 </div>

							</div>

							<!-- Second Row: 4 Columns -->
							<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
									<div>
											<label class="block text-gray-700 font-semibold text-sm">Date Of Reference Order</label>                                                       

											<input type="date" name="reference_date" value="{{ old('reference_date', $mediation->reference_date) }}"  class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" >
									</div>
									<div>
											<label class="block text-gray-700 font-semibold text-sm">Date of First Mediation</label>

											<input type="date" name="mediation_date" value="{{ old('mediation_date', $mediation->mediation_date) }}" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105" >
									</div>
									<div>
											<label class="block text-gray-700 font-semibold text-sm">Order of Court Referring To Mediation</label>
                                            @if ($mediation->order_file)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $mediation->order_file) }}" target="_blank" class="text-blue-600 underline">View Current File</a>
                                                </div>
                                            @endif
											<input type="file" name="order_file" id="order_file" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none file:bg-blue-700 file:text-white file:px-3 file:py-2 file:rounded-lg file:border-none file:cursor-pointer hover:file:bg-blue-600 transition-all">
									</div>
									<div>
											<label class="block text-gray-700 font-semibold text-sm">Case File</label>
                                            @if ($mediation->case_file)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $mediation->case_file) }}" target="_blank" class="text-blue-600 underline">View Current File</a>
                                                </div>
                                            @endif
											<input type="file" name="case_file" id="case_file" class="p-3 border border-gray-300 bg-white rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:outline-none file:bg-blue-700 file:text-white file:px-3 file:py-2 file:rounded-lg file:border-none file:cursor-pointer hover:file:bg-blue-600 transition-all">
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
												
												<!-- Complainant Type Selection -->
												<div class="mb-4">
														<label class="inline-flex items-center mr-4">
																<input type="radio" name="complainant_type" value="individual" class="form-radio"
																		{{ old('complainant_type', $mediation->complainant_type ?? 'individual') === 'individual' ? 'checked' : '' }}>
																<span class="ml-2">Individual</span>
														</label>
														<label class="inline-flex items-center">
																<input type="radio" name="complainant_type" value="entity" class="form-radio"
																		{{ old('complainant_type', $mediation->complainant_type ?? '') === 'entity' ? 'checked' : '' }}>
																<span class="ml-2">Entity</span>
														</label>
												</div>

												<!-- Individual Fields -->
												@if($mediation->complainant_type === 'individual')
												<div class="individual-fields grid grid-cols-1 md:grid-cols-3 gap-4">

														<div>
												<label class="block text-gray-700 font-semibold text-sm">Name</label>
												<input type="text" name="complainant_name" value="{{ old('complainant_name', $mediation->complainant_name) }}" class="p-3 border rounded-lg w-full" placeholder="Enter name">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Father's Name</label>
												<input type="text" name="complainant_father" value="{{ old('complainant_father', $mediation->complainant_father) }}" class="p-3 border rounded-lg w-full" placeholder="Enter father's name">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Date of Birth</label>
												<input type="date" name="complainant_dob" value="{{ old('complainant_dob', $mediation->complainant_dob) }}" class="p-3 border rounded-lg w-full">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Gender</label>
												<select name="complainant_gender" class="p-3 border rounded-lg w-full">
														@foreach(['Male', 'Female', 'Other'] as $gender)
																<option value="{{ $gender }}" @if(old('complainant_gender', $mediation->complainant_gender) == $gender) selected @endif>{{ $gender }}</option>
														@endforeach
												</select>
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Address</label>
												<input type="text" name="complainant_address" value="{{ old('complainant_address', $mediation->complainant_address) }}" class="p-3 border rounded-lg w-full" placeholder="Enter address">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">State</label>
												<input type="text" name="complainant_state_display" value="{{ optional($mediation->complainantState)->name }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="complainant_state_id" value="{{ $mediation->complainant_state_id }}">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">City</label>
												<input type="text" name="complainant_city_display" value="{{ optional($mediation->complainantCity)->name ?? 'Unknown' }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="complainant_city_id" value="{{ $mediation->complainant_city_id }}">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">District</label>
												<input type="text" name="complainant_district" value="{{ old('complainant_district', $mediation->complainant_district) }}" class="p-3 border rounded-lg w-full" placeholder="Enter district">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Pincode</label>
												<input type="text" name="complainant_pincode" value="{{ old('complainant_pincode', $mediation->complainant_pincode) }}" class="p-3 border rounded-lg w-full" placeholder="Enter pincode" readonly>
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Mobile</label>
												<input type="tel" name="complainant_mobile" pattern="[0-9]{10}" value="{{ old('complainant_mobile', $mediation->complainant_mobile) }}" class="p-3 border rounded-lg w-full" placeholder="Mobile number">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Email</label>
												<input type="email" name="complainant_email" value="{{ old('complainant_email', $mediation->complainant_email) }}" class="p-3 border rounded-lg w-full" placeholder="Email" readonly>
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Upload ID Proof</label>
												@if ($mediation->complainant_id_proof)
														<div class="mb-2">
																<a href="{{ asset('storage/' . $mediation->complainant_id_proof) }}" target="_blank" class="text-blue-600 underline">View Current ID Proof</a>
														</div>
												@endif
												<input type="file" name="complainant_id_proof" class="p-3 border rounded-lg w-full">
										</div>
									</div>
									@endif

									<!-- Entity Fields -->
										@if($mediation->complainant_type === 'entity')
									<div class="entity-fields grid grid-cols-1 md:grid-cols-2 gap-4">

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Name of Entity</label>
												<input type="text" name="complainant_name" value="{{ old('complainant_name', $mediation->complainant_name) }}" class="p-3 border rounded-lg w-full" placeholder="Enter entity name">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Authorised Representative</label>
												<input type="text" name="complainant_father" value="{{ old('complainant_father', $mediation->complainant_father) }}" class="p-3 border rounded-lg w-full" placeholder="Enter authorized person">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Date of Incorporation</label>
												<input type="date" name="complainant_dob" value="{{ old('complainant_dob', $mediation->complainant_dob) }}" class="p-3 border rounded-lg w-full">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Address</label>
												<input type="text" name="complainant_address" value="{{ old('complainant_address', $mediation->complainant_address) }}" class="p-3 border rounded-lg w-full" placeholder="Enter address">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">State</label>
												<input type="text" name="complainant_state_display" value="{{ optional($mediation->complainantState)->name }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="complainant_state_id" value="{{ $mediation->complainant_state_id }}">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">City</label>
												<input type="text" name="complainant_city_display" value="{{ optional($mediation->complainantCity)->name ?? 'Unknown' }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="complainant_city_id" value="{{ $mediation->complainant_city_id }}">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Pincode</label>
												<input type="text" name="complainant_pincode" value="{{ old('complainant_pincode', $mediation->complainant_pincode) }}" class="p-3 border rounded-lg w-full" placeholder="Enter pincode" readonly>
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Email</label>
												<input type="email" name="complainant_email" value="{{ old('complainant_email', $mediation->complainant_email) }}" class="p-3 border rounded-lg w-full" placeholder="Email" readonly>
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">Upload Incorporation Certificate</label>
												@if ($mediation->complainant_id_proof)
														<div class="mb-2">
																<a href="{{ asset('storage/' . $mediation->complainant_id_proof) }}" target="_blank" class="text-blue-600 underline">View Current Document</a>
														</div>
												@endif
												<input type="file" name="complainant_id_proof" class="p-3 border rounded-lg w-full">
										</div>

												</div>
												@endif
										</fieldset>
								</div>

								<script>
								function toggleComplainantAccordion() {
										const content = document.getElementById('complainant-accordion-content');
										const icon = document.getElementById('complainant-accordion-icon');

										content.classList.toggle('hidden');
										icon.classList.toggle('rotate-180');
								}
								</script>



              
            
            <!-- Complainant/Petitioner/Appellant Details Ends -->

            <!-- Defendant/Respondent Details Accordion -->
							<div class="bg-gradient-to-b from-gray-50 to-gray-100 border border-gray-300 rounded-lg shadow-lg mb-6">
								<!-- Accordion Header -->
								<div
									class="flex justify-between items-center p-4 bg-[#17A2B8] text-white rounded-t-lg cursor-pointer"
									onclick="toggleDefendantAccordion()"
								>
									<legend class="text-md font-bold tracking-wide">Defendant/Respondent Details</legend>
									<span id="defendant-accordion-icon" class="transform transition-transform duration-300">&#9660;</span>
								</div>

								<!-- Accordion Content -->
								<fieldset
									id="defendant-accordion-content"
									class="p-6 bg-white space-y-6 rounded-b-lg shadow-sm hidden transition-all duration-500"
								>
									<!-- Defendant Type (read‑only) -->
									<div class="mb-4">
														<label class="inline-flex items-center mr-4">
																<input type="radio" name="defendant_type" value="individual" class="form-radio"
																		{{ old('defendant_type', $mediation->defendant_type ?? 'individual') === 'individual' ? 'checked' : '' }}>
																<span class="ml-2">Individual</span>
														</label>
														<label class="inline-flex items-center">
																<input type="radio" name="defendant_type" value="entity" class="form-radio"
																		{{ old('defendant_type', $mediation->defendant_type ?? '') === 'entity' ? 'checked' : '' }}>
																<span class="ml-2">Entity</span>
														</label>
												</div>

									<!-- Individual Fields -->
									<div
										class="individual-fields grid grid-cols-1 md:grid-cols-3 gap-6 {{ $mediation->defendant_type === 'individual' ? '' : 'hidden' }}"
									>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Name <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_name"
												value="{{ old('defendant_name', $mediation->defendant_name) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter name"
											>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Father's Name <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_father"
												value="{{ old('defendant_father', $mediation->defendant_father) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter father's name"
											>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Date of Birth <span class="text-red-500">*</span>
											</label>
											<input
												type="date"
												name="defendant_dob"
												value="{{ old('defendant_dob', $mediation->defendant_dob) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
											>
										</div>

										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Gender <span class="text-red-500">*</span>
											</label>
											<select
												name="defendant_gender"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
											>
												<option value="">Select Gender</option>
												@foreach(['Male','Female','Other'] as $g)
													<option
														value="{{ $g }}"
														{{ old('defendant_gender', $mediation->defendant_gender) === $g ? 'selected' : '' }}
													>
														{{ $g }}
													</option>
												@endforeach
											</select>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Address <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_address"
												value="{{ old('defendant_address', $mediation->defendant_address) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter address"
											>
										</div>
										<div>
												<label class="block text-gray-700 font-semibold text-sm">State</label>
												<input type="text" name="defendant_state_display" value="{{ optional($mediation->defendantState)->name }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="defendant_state_id" value="{{ $mediation->defendant_state_id }}">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">City</label>
												<input type="text" name="defendant_city_display" value="{{ optional($mediation->defendantCity)->name ?? 'Unknown' }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="defendant_city_id" value="{{ $mediation->defendant_city_id }}">
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												District <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_district"
												value="{{ old('defendant_district', $mediation->defendant_district) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter district"
											>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Pincode <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_pincode"
												value="{{ old('defendant_pincode', $mediation->defendant_pincode) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter pincode"
											>
										</div>

										<div>
											<label class="block text-gray-700 font-semibold text-sm">Mobile</label>
											<input
												type="tel"
												name="defendant_mobile"
												pattern="[0-9]{10}"
												value="{{ old('defendant_mobile', $mediation->defendant_mobile) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="10-digit mobile"
											>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Email <span class="text-red-500">*</span>
											</label>
											<input
												type="email"
												name="defendant_email"
												value="{{ old('defendant_email', $mediation->defendant_email) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter email"
											>
										</div>
										<div>
												<label class="block text-gray-700 font-semibold text-sm">Upload ID Proof</label>
												@if ($mediation->defandant_id_proof)
														<div class="mb-2">
																<a href="{{ asset('storage/' . $mediation->defandant_id_proof) }}" target="_blank" class="text-blue-600 underline">View Current ID Proof</a>
														</div>
												@endif
												<input type="file" name="defandant_id_proof" class="p-3 border rounded-lg w-full">
										</div>
									</div>

									<!-- Entity Fields -->
									<div
										class="entity-fields grid grid-cols-1 md:grid-cols-2 gap-6 {{ $mediation->defendant_type === 'entity' ? '' : 'hidden' }}"
									>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Name of Entity <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_name"
												value="{{ old('defendant_name', $mediation->defendant_name) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm" 
												placeholder="Enter entity name" readonly>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Authorised Representative <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_father"
												value="{{ old('defendant_father', $mediation->defendant_father) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter authorized person" readonly
											>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Date of Incorporation <span class="text-red-500">*</span>
											</label>
											<input
												type="date"
												name="defendant_dob"
												value="{{ old('defendant_dob', $mediation->defendant_dob) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm" readonly
											>
										</div>

										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Address <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_address"
												value="{{ old('defendant_address', $mediation->defendant_address) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter address" readonly
											>
										</div>
										<div>
												<label class="block text-gray-700 font-semibold text-sm">State</label>
												<input type="text" name="defendant_state_display" value="{{ optional($mediation->defendantState)->name }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="defendant_state_id" value="{{ $mediation->defendant_state_id }}">
										</div>

										<div>
												<label class="block text-gray-700 font-semibold text-sm">City</label>
												<input type="text" name="defendant_city_display" value="{{ optional($mediation->defendantCity)->name ?? 'Unknown' }}" class="p-3 border rounded-lg w-full bg-gray-100" readonly>
												<input type="hidden" name="defendant_city_id" value="{{ $mediation->defendant_city_id }}">
										</div>

										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Pincode <span class="text-red-500">*</span>
											</label>
											<input
												type="text"
												name="defendant_pincode"
												value="{{ old('defendant_pincode', $mediation->defendant_pincode) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter pincode" readonly
											>
										</div>
										<div>
											<label class="block text-gray-700 font-semibold text-sm">
												Email <span class="text-red-500">*</span>
											</label>
											<input
												type="email"
												name="defendant_email"
												value="{{ old('defendant_email', $mediation->defendant_email) }}"
												class="w-full p-3 border border-gray-300 rounded-lg shadow-sm"
												placeholder="Enter email" readonly
											>
										</div>
										<div>
												<label class="block text-gray-700 font-semibold text-sm">Upload Incorporation Certificate</label>
												@if ($mediation->defandant_id_proof)
														<div class="mb-2">
																<a href="{{ asset('storage/' . $mediation->defandant_id_proof) }}" target="_blank" class="text-blue-600 underline">View Current Document</a>
														</div>
												@endif
												<input type="file" name="defandant_id_proof" class="p-3 border rounded-lg w-full">
										</div>
									</div>
								</fieldset>
							</div>

							<script>
								function toggleDefendantAccordion() {
									const content = document.getElementById('defendant-accordion-content');
									const icon = document.getElementById('defendant-accordion-icon');
									content.classList.toggle('hidden');
									icon.classList.toggle('rotate-180');
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
  
								<!-- Complainant Advocate -->
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Complainant Advocate</label>
									<div class="flex items-center space-x-2">
										<div class="w-full">
                                            <input type="text" 
                                                    id="complainant_advocate_name"  
                                                    name="complainant_advocate_name" 
                                                    list="advocate_suggestions" 
                                                    value="{{ old('complainant_advocate_name', optional($mediation->complainantAdvocate)->name ?? '') }}" 
                                                    class="p-3 border border-gray-300 rounded-lg w-full" 
                                                    placeholder="Search Advocate" 
                                                    autocomplete="off" readonly>

                                            <datalist id="advocate_suggestions">
                                                @foreach($advocates as $advocate)
                                                <option data-id="{{ $advocate->id }}" value="{{ $advocate->name }}"></option>
                                                @endforeach
                                            </datalist>

                                            <input type="hidden" 
                                                    name="complainant_advocate_id" 
                                                    id="complainant_advocate_id" 
                                                    value="{{ old('complainant_advocate_id', $mediation->complainant_advocate_id) }}">
                                        </div>
                                        <script>
                                            const advocateInput = document.getElementById('complainant_advocate_name');
                                            const hiddenAdvocateId = document.getElementById('complainant_advocate_id');
                                            const dataList = document.getElementById('advocate_suggestions');

                                            advocateInput.addEventListener('input', function() {
                                                const val = this.value;
                                                const opts = dataList.options;
                                                hiddenAdvocateId.value = '';

                                                for(let i = 0; i < opts.length; i++) {
                                                if(opts[i].value === val) {
                                                    hiddenAdvocateId.value = opts[i].dataset.id; 
                                                    break;
                                                }
                                                }
                                            });
                                            </script>

										<button type="button" onclick="openAdvocateModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">Add New</button>
									</div>
								</div>

								<!-- Defendant Advocate -->
								<div>
									<label class="block text-gray-700 font-semibold text-sm">Defendant Advocate</label>
									<div class="flex items-center space-x-2">
										<div class="w-full mt-4">
                                               <input type="text" 
                                                id="defendant_advocate_name" 
                                                name="defendant_advocate_name"
                                                list="advocate_suggestions" 
                                                value="{{ old('defendant_advocate_name', optional($mediation->defendantAdvocate)->name ?? '') }}" 
                                                class="p-3 border border-gray-300 rounded-lg w-full" 
                                                placeholder="Search Advocate" 
                                                autocomplete="off" readonly>

                                               <input type="hidden" 
                                                name="defendant_advocate_id" 
                                                id="defendant_advocate_id" 
                                                value="{{ old('defendant_advocate_id', $mediation->defendant_advocate_id) }}">
                                        </div>

                                        <datalist id="advocate_suggestions">
                                            @foreach($advocates as $advocate)
                                                <option data-id="{{ $advocate->id }}" value="{{ $advocate->name }}"></option>
                                            @endforeach
                                        </datalist>

										<button type="button" onclick="openAdvocateModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">Add New</button>
									</div>
								</div>

								<!-- Mediator -->
								<div>
										<label class="block text-gray-700 font-semibold text-sm">Mediator</label>
										<div class="flex items-center space-x-2">
												<div class="w-full">
														<input type="text" 
																	id="mediator_name" 
																	name="mediator_name" 
																	list="mediator_suggestions"
																	value="{{ old('mediator_name', optional($mediation->mediator)->name ?? '') }}" 
																	class="p-3 border border-gray-300 rounded-lg w-full" 
																	placeholder="Search Mediator"
																	autocomplete="off" readonly>

														<datalist id="mediator_suggestions">
																@foreach($mediators as $mediator)
																		<option data-id="{{ $mediator->id }}" value="{{ $mediator->name }}"></option>
																@endforeach
														</datalist>

														<input type="hidden" 
																	name="mediator_id" 
																	id="mediator_id" 
																	value="{{ old('mediator_id', $mediation->mediator_id) }}">
												</div>

												<button type="button" onclick="openMediatorModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500">Add New</button>
										</div>
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
                                    <div class="w-full">
                                    <input type="text" id="subject_name" value="{{ old('subject_name', optional($mediation->subject)->name) }}" placeholder="Search Subject" class="p-3 border border-gray-300 rounded-lg w-full" autocomplete="off" readonly/>
                                    <input type="hidden" name="subject_id" id="subject_id" value="{{ old('subject_id', $mediation->subject_id) }}" />
                                </div>

							</div>

							<!-- Issue -->
							<div>
								<label class="block text-gray-700 font-semibold text-sm">Issue</label>
								<div class="relative w-full">
                                        
                                        <input 
                                            type="text" 
                                            id="issue_name" 
                                            value="{{ old('issue_name', optional($mediation->issue)->IssueName ?? '') }}" 
                                            placeholder="Issue Name"
                                            class="w-full border p-2 rounded bg-gray-100 cursor-not-allowed"
                                            readonly
                                        />

                                        
                                        <input 
                                            type="hidden" 
                                            name="issue_id" 
                                            id="issue_id" 
                                            value="{{ old('issue_id', $mediation->issue_id) }}" 
                                        />
                                </div>
							</div>

							<!-- Statute -->
							<div>
									<label class="block text-gray-700 font-semibold text-sm">Statute</label>
									<div class="relative w-full">
                                    <input type="text" name="statute_name" id="statute_name" 
                                        value="{{ old('statute_name', $mediation->statute ? $mediation->statute->Act_Name : '') }}" 
                                        class="w-full border p-2 rounded" readonly />


                                    <input 
                                        type="hidden" 
                                        name="statute_id" 
                                        id="statute_id" 
                                        value="{{ old('statute_id', $mediation->statute_id) }}" 
                                    />
                                    </div>


							</div>
						</div>

                        <div class="mt-6">
                        <label for="status" class="block text-gray-700 font-semibold text-sm mb-2">Status</label>
                        <select name="status" id="status" 
                            class="w-full p-3 border border-gray-300 rounded-lg bg-white text-gray-900 font-medium 
                                hover:border-[#DD3445] focus:outline-none focus:ring-2 focus:ring-[#DD3445] transition">
                            <option value="Active" {{ old('status', $mediation->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Closed" {{ old('status', $mediation->status) == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
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
							Update case
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
						document.querySelectorAll('.state-select').forEach(stateDropdown => {
								stateDropdown.addEventListener('change', function () {
										const stateId = this.value;
										const citySelector = this.getAttribute('data-target');
										const cityDropdown = document.querySelector(citySelector);

										if (stateId) {
												fetch(`/fetch-cities?state_id=${stateId}`)
														.then(response => response.json())
														.then(data => {
																cityDropdown.innerHTML = '<option value="">Select City</option>';
																data.cities.forEach(city => {
																		const option = document.createElement('option');
																		option.value = city.id;
																		option.textContent = city.name;
																		cityDropdown.appendChild(option);
																});
														});
										} else {
												cityDropdown.innerHTML = '<option value="">Select City</option>';
										}
								});
						});
				 </script>
			  
			</div>
		</div>
	</div>
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

										// Setup advocate autocompletes 
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
                                
        </form>
    </div>

    <script>
  function setupAdvocateAutocomplete(textInputId, hiddenInputId) {
    const textInput = document.getElementById(textInputId);
    const hiddenInput = document.getElementById(hiddenInputId);
    const datalist = document.getElementById('advocate_suggestions');

    textInput.addEventListener('input', function() {
      const val = this.value;
      const options = datalist.options;
      hiddenInput.value = ''; // clear hidden id if no match

      for (let i = 0; i < options.length; i++) {
        if (options[i].value === val) {
          hiddenInput.value = options[i].dataset.id;
          break;
        }
      }
    });
  }
	

  // Initialize autocomplete for both fields
  setupAdvocateAutocomplete('complainant_advocate_name', 'complainant_advocate_id');
  setupAdvocateAutocomplete('defendant_advocate_name', 'defendant_advocate_id');
</script>
</body>

</html>
