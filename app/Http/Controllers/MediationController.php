<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\WelcomeEmail;

use App\Models\{Advocate,Mediator,Mediation,Complainant,Respondent,User,CourtMast,JudgeMast,State,City,Subject,Issue,Statute};


class MediationController extends Controller
{

    
    public function create(Request $request)
    {
        $courts = CourtMast::all();

        $judges = $request->has('court_id')
            ? JudgeMast::where('AG_Courtcode', $request->court_id)->get()
            : JudgeMast::all();

        $states = State::all();
        $subjects = Subject::all();
        $issues = Issue::all();
        $statutes = Statute::all();

        $cities = $request->has('state_id')
            ? City::where('state_id', $request->state_id)->get()
            : collect();

        $advocates = Advocate::all();
        $mediators = Mediator::all();

        return view('mediation.registrationnew', compact(
            'courts', 'judges', 'states', 'subjects', 'issues',
            'cities', 'statutes', 'advocates', 'mediators'
        ));
    }

    public function fetchJudges(Request $request)
    {
        $judges = JudgeMast::where('AG_Courtcode', $request->court_id)->get();
        return response()->json(['judges' => $judges]);
    }

    public function fetchCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json(['cities' => $cities]);
    }

    public function fetchAdvocates()
    {
        $advocates = Advocate::all();
        return response()->json($advocates);
    }

    public function fetchMediators()
    {
        $mediators = Mediator::all();
        return response()->json($mediators);
    }

    public function judgeSuggestions(Request $request)
    {
        $query = $request->get('query', '');
        $courtId = $request->get('court_id');

        $judges = JudgeMast::where('Judge_Name', 'LIKE', "%{$query}%");

        if ($courtId) {
            $judges->where('AG_Courtcode', $courtId);
        }

        $judges = $judges->select('Judge_Name')->distinct()->limit(10)->get();

        return response()->json($judges);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        
            'case_number'       => 'required|string|unique:mediations,case_number',
            'court_id'          => 'required|exists:court_mast,AG_Courtcode',
            'judge_name'        => 'required|string|max:255',
            'reference_date'    => 'required|date',
            'mediation_date'    => 'required|date|after_or_equal:reference_date',

            
            // Types
            'complainant_type'  => 'required|in:individual,entity',
            'defendant_type'    => 'required|in:individual,entity',

            // Complainant (always present)
            'complainant_name'      => 'required|string|max:255',
            'complainant_father'    => 'required|string|max:255',
            'complainant_dob'       => ['required','date','before:mediation_date'],
            'complainant_gender'    => ['nullable','in:Male,Female,Other','required_if:complainant_type,individual'],
            'complainant_address'   => 'required|string',
            'complainant_state_id'  => 'required|exists:states,id',
            'complainant_city_id'   => 'required|exists:cities,id',
            'complainant_district_id' => 'exists:districts,id',
            'complainant_pincode'   => 'required|numeric',
            'complainant_mobile' => ['required_if:complainant_type,individual', 'digits:10'],
            'complainant_email'     => 'required|email|unique:complainants,email|unique:users,email',
            'complainant_id_proof'  => 'nullable|file',

            // Defendant (always present)
            'defendant_name'        => 'required|string|max:255',
            'defendant_father'      => 'required|string|max:255',
            'defendant_dob'         => ['required','date','before:mediation_date'],
            'defendant_gender'      => ['nullable','in:Male,Female,Other','required_if:defendant_type,individual'],
            'defendant_address'     => 'required|string',
            'defendant_state_id'    => 'required|exists:states,id',
            'defendant_city_id'     => 'required|exists:cities,id',
            'defendant_district_id'   => 'exists:districts,id',
            'defendant_pincode'     => 'required|numeric',
            'defendant_mobile'      =>   ['required_if:defendant_type,individual', 'digits:10'],
            'defendant_email'       => 'required|email|unique:respondents,email|unique:users,email',
            'defandant_id_proof'    => 'nullable|file',
        ], [
            'complainant_dob.before' => 'Complainant date must be before the mediation date.',
            'defendant_dob.before'   => 'Defendant date must be before the mediation date.',
        ]);

        DB::beginTransaction();

        try {
            // 1) Judge
            $judge = JudgeMast::firstOrCreate(
                [
                    'Judge_Name'  => $validated['judge_name'],
                    'AG_Courtcode'=> $validated['court_id'],
                ],
                [
                    'AGJudgecode'=> uniqid('J'),
                    'Count_code' => CourtMast::where('AG_Courtcode', $validated['court_id'])
                                            ->value('Count_code'),
                ]
            );

            // 2) Store files
            $orderFile          = $request->file('order_file')           ? $request->file('order_file')->store('orders')       : null;
            $caseFile           = $request->file('case_file')            ? $request->file('case_file')->store('cases')         : null;
            $complainantProof   = $request->file('complainant_id_proof') ? $request->file('complainant_id_proof')->store('id_proofs') : null;
            $defendantProof     = $request->file('defandant_id_proof')   ? $request->file('defandant_id_proof')->store('id_proofs')   : null;

            // 3) Mediation record
            $mediation = Mediation::create([
                'court_id'               => $validated['court_id'],
                'judge_id'               => $judge->AGJudgecode,
                'case_number'            => $validated['case_number'],
                'reference_date'         => $validated['reference_date'],
                'mediation_date'         => $validated['mediation_date'],
                'order_file'             => $orderFile,
                'case_file'              => $caseFile,
                'subject_id'             => $request->subject_id,
                'issue_id'               => $request->issue_id,
                'statute_id'             => $request->statute_id,
                'complainant_advocate_id'=> $request->complainant_advocate_id,
                'defendant_advocate_id'  => $request->defendant_advocate_id,
                'mediator_id'            => $request->mediator_id,

                // complainant fields
                'complainant_type'       => $validated['complainant_type'],
                'complainant_name'       => $validated['complainant_name'],
                'complainant_father'     => $validated['complainant_father'],
                'complainant_dob'        => $validated['complainant_dob'],
                'complainant_gender'     => $validated['complainant_gender'] ?? null,
                'complainant_address'    => $validated['complainant_address'],
                'complainant_state_id'   => $validated['complainant_state_id'],
                'complainant_district_id' => $validated['complainant_district_id'] ?? null,
                'complainant_mobile'     => $validated['complainant_mobile'] ?? null,
                'complainant_city_id'    => $validated['complainant_city_id'],
                'complainant_pincode'    => $validated['complainant_pincode'],
                'complainant_email'      => $validated['complainant_email'],
                'complainant_id_proof'   => $complainantProof,

                // defendant fields
                'defendant_type'         => $validated['defendant_type'],
                'defendant_name'         => $validated['defendant_name'],
                'defendant_father'       => $validated['defendant_father'],
                'defendant_dob'          => $validated['defendant_dob'],
                'defendant_gender'       => $validated['defendant_gender'] ?? null,
                'defendant_address'      => $validated['defendant_address'],
                'defendant_state_id'     => $validated['defendant_state_id'],
                'defendant_city_id'      => $validated['defendant_city_id'],
                'defendant_district_id'  => $validated['defendant_district_id'] ?? null,
                'defendant_mobile'       => $validated['defendant_mobile'] ?? null,
                'defendant_pincode'      => $validated['defendant_pincode'],
                'defendant_email'        => $validated['defendant_email'],
                'defandant_id_proof'     => $defendantProof,
            ]);

            // 4) Related models
            $mediation->complainant()->create([
                'name'              => $validated['complainant_name'],
                'father'            => $validated['complainant_father'],
                'dob'               => $validated['complainant_dob'],
                'gender'            => $validated['complainant_gender'] ?? null,
                'address'           => $validated['complainant_address'],
                'state_id'          => $validated['complainant_state_id'],
                'district'          => $validated['complainant_district'] ?? null,
                'city_id'           => $validated['complainant_city_id'],
                'pincode'           => $validated['complainant_pincode'],
                'mobile'            => $validated['complainant_mobile'] ?? null,
                'email'             => $validated['complainant_email'],
                'id_proof'          => $complainantProof,
                'complainant_type'  => $validated['complainant_type'],
            ]);


            $mediation->respondent()->create([
                'name'             => $validated['defendant_name'],
                'father'           => $validated['defendant_father'],
                'dob'              => $validated['defendant_dob'],
                'gender'           => $validated['defendant_gender'] ?? null,
                'address'          => $validated['defendant_address'],
                'state_id'         => $validated['defendant_state_id'],
                'district'         => $validated['defendant_district'] ?? null,
                'city_id'          => $validated['defendant_city_id'],
                'pincode'          => $validated['defendant_pincode'],
                'mobile'           => $validated['defendant_mobile'] ?? null, 
                'email'            => $validated['defendant_email'],
                'id_proof'         => $defendantProof,
                'defendant_type'  => $validated['defendant_type'],
            ]);


            // 5) Create Users & Send Emails
            $complainantPassword = Str::random(10);
            $respondentPassword  = Str::random(10);

            User::create([
                'name'     => $validated['complainant_name'],
                'email'    => $validated['complainant_email'],
                'mobile'   => $validated['complainant_mobile'] ?? null,
                'password' => Hash::make($complainantPassword),
                'role_id'  => 3,
            ]);

            User::create([
                'name'     => $validated['defendant_name'],
                'email'    => $validated['defendant_email'],
                'mobile'   => $validated['defendant_mobile'] ?? null,
                'password' => Hash::make($respondentPassword),
                'role_id'  => 4,
            ]);

            // queue welcome emails
            try {
                Mail::to($validated['complainant_email'])
                    ->queue(new WelcomeEmail(
                        $validated['complainant_name'],
                        $validated['complainant_email'],
                        $complainantPassword,
                        'complainant'
                    ));

                Mail::to($validated['defendant_email'])
                    ->queue(new WelcomeEmail(
                        $validated['defendant_name'],
                        $validated['defendant_email'],
                        $respondentPassword,
                        'respondent'
                    ));
            } catch (\Exception $e) {
                Log::error('Email send failed: '.$e->getMessage());
            }

            DB::commit();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Mediation record stored successfully!');
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store mediation failed: '.$e->getMessage());
            return back()->withErrors('Something went wrong. Please try again.');
        }
    }

  


   public function storeAdvocate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bar_number' => 'required|string|max:100|unique:advocate_mast,bar_number',
            'emailId' => 'required|email|max:255|unique:advocate_mast,emailId|unique:users,email',
            'mobile' => 'required|string|max:15',
        ]);

        $password = Str::random(10);

        $advocate = Advocate::create($validated);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['emailId'],
            'mobile' => $validated['mobile'],
            'password' => Hash::make($password),
            'role_id' => 1, //advocate role
        ]);

        try {
            Mail::to($validated['emailId'])->send(new WelcomeEmail(
                $validated['name'],
                $validated['emailId'],
                $password,
                'advocate'
            ));
        } catch (\Exception $e) {
            Log::error('Mail send failed: ' . $e->getMessage());

            // Return JSON if the request expects JSON (e.g., from mediation form via AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Advocate created but failed to send email.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            // Otherwise redirect with error
            return redirect()->back()->with('error', 'Advocate created but failed to send email.');
        }

        // Check if request expects JSON (AJAX call)
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Advocate added successfully and login credentials sent to email.',
                'advocate' => $advocate,
            ]);
        }

        // Normal web redirect (e.g., from advocates.index page)
        return redirect()->route('advocates.index')->with('success', 'Advocate added successfully and login credentials sent to email.');
    }


   public function storeMediator(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'qualification' => 'nullable|string|max:255',
            'emailId' => 'required|email|max:255|unique:mediator_mast,emailId|unique:users,email',
            'mobile' => 'required|string|max:15',
        ]);

        $password = Str::random(10);

        $mediator = Mediator::create($validated);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['emailId'],
            'mobile' => $validated['mobile'],
            'password' => Hash::make($password),
            'role_id' => 2,
        ]);

        try {
            Mail::to($validated['emailId'])->send(new WelcomeEmail(
                $validated['name'],
                $validated['emailId'],
                $password,
                'mediator'
            ));
        } catch (\Exception $e) {
            Log::error('Mail send failed: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Mediator created but failed to send email.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Mediator created but failed to send email.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Mediator added successfully and login credentials sent to email.',
                'mediator' => $mediator,
            ]);
        }

        return redirect()->route('mediators.index')->with('success', 'Mediator added successfully and login credentials sent to email.');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('term');

        $advocates = Advocate::where('name', 'like', "%{$search}%")
            ->orWhere('bar_number', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json($advocates->map(function ($advocate) {
            return [
                'id' => $advocate->id,
                'label' => $advocate->name . " ({$advocate->bar_number})",
                'value' => $advocate->name,
            ];
        }));
    }

    public function autocompleteMediators(Request $request)
    {
        $search = $request->get('term');

        $mediators = Mediator::where('name', 'like', "%{$search}%")
            ->orWhere('qualification', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json($mediators->map(function ($mediator) {
            return [
                'id' => $mediator->id,
                'label' => $mediator->name . " ({$mediator->qualification})",
                'value' => $mediator->name,
            ];
        }));
    }  

    public function edit($id)
    {
        $mediation = Mediation::with(['complainant', 'respondent'])->findOrFail($id);

        // Fetch data for dropdowns
        $courts = CourtMast::all();
        $judges = JudgeMast::all();
        $states = State::all();
        $cities = City::all();
        $subjects = Subject::all();
        $issues = Issue::all();
        $statutes = Statute::all();
        $advocates = Advocate::all();
        $mediators = Mediator::all();

        return view('mediations.edit', compact(
            'mediation', 'courts', 'judges', 'states', 'cities',
            'subjects', 'issues', 'statutes', 'advocates', 'mediators'
        ));
    }

    public function update(Request $request, $id)
    {
        \Log::info("Update called for mediation id: $id");
        \Log::info($request->all());

        $mediation = Mediation::with(['complainant', 'respondent'])->findOrFail($id);
        

        $validatedData = $request->validate([
            'court_id' => 'required|exists:court_mast,AG_Courtcode',
            'judge_id' => 'nullable|exists:judge_mast,AGJudgecode',
            'case_number' => "required|string|max:255|unique:mediations,case_number,{$id}",

            'reference_date' => 'required|date',
            'mediation_date' => 'required|date',

            'complainant_name' => 'required|string|max:255',
            'complainant_father' => 'nullable|string|max:255',
            'complainant_dob' => 'nullable|date',
            'complainant_gender' => 'nullable|string',
            'complainant_address' => 'nullable|string',
            'complainant_state_id' => 'nullable|exists:states,id',
            'complainant_city_id' => 'nullable|exists:cities,id',
            'complainant_district' => 'nullable|string',
            'complainant_pincode' => 'nullable|string',
            'complainant_mobile' => 'nullable|string',
            'complainant_email' => "nullable|email|unique:complainants,email,{$mediation->complainant->id}",

            'defendant_name' => 'required|string|max:255',
            'defendant_father' => 'nullable|string|max:255',
            'defendant_dob' => 'nullable|date',
            'defendant_gender' => 'nullable|string',
            'defendant_address' => 'nullable|string',
            'defendant_state_id' => 'nullable|exists:states,id',
            'defendant_city_id' => 'nullable|exists:cities,id',
            'defendant_district' => 'nullable|string',
            'defendant_pincode' => 'nullable|string',
            'defendant_mobile' => 'nullable|string',
            'defendant_email' => "nullable|email|unique:respondents,email,{$mediation->respondent->id}",

            'subject_id' => 'nullable|exists:subjects,id',
            'issue_id' => 'nullable|exists:issue_mast,Issue_code',
            'statute_id' => 'nullable|exists:statute_mast,AG_StatuteCode',
            'complainant_advocate_id' => 'nullable|exists:advocate_mast,id',
            'defendant_advocate_id' => 'nullable|exists:advocate_mast,id',
            'mediator_id' => 'nullable|exists:mediator_mast,id',
            'status' => 'nullable|string',

            'order_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg',
            'case_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg',
            'complainant_id_proof_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg',
            'defandant_id_proof_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg',
        ]);

        DB::transaction(function () use ($request, $mediation, $validatedData) {

            // Handle order_file upload
            $orderFileName = $mediation->order_file;
            if ($request->hasFile('order_file')) {
                if ($mediation->order_file) {
                    Storage::disk('public')->delete($mediation->order_file);
                }
                $orderFileName = $request->file('order_file')->store('orders', 'public');
            }

            // Handle case_file upload
            $caseFileName = $mediation->case_file;
            if ($request->hasFile('case_file')) {
                if ($mediation->case_file) {
                    Storage::disk('public')->delete($mediation->case_file);
                }
                $caseFileName = $request->file('case_file')->store('cases', 'public');
            }

            // Handle complainant id proof
            $complainantIdProof = $mediation->complainant->id_proof ?? null;
            if ($request->hasFile('complainant_id_proof_file')) {
                if ($complainantIdProof) {
                    Storage::disk('public')->delete($complainantIdProof);
                }
                $complainantIdProof = $request->file('complainant_id_proof_file')->store('id_proofs', 'public');
            }

            // Handle defendant id proof
            $defandantIdProof = $mediation->respondent->id_proof ?? null;
            if ($request->hasFile('defandant_id_proof_file')) {
                if ($defandantIdProof) {
                    Storage::disk('public')->delete($defandantIdProof);
                }
                $defandantIdProof = $request->file('defandant_id_proof_file')->store('id_proofs', 'public');
            }

            
            
            $mediation->order_file = $orderFileName;
            $mediation->case_file = $caseFileName;
            $mediation->save();

            // Update complainant and respondent proofs if needed
            // if ($mediation->complainant) {
            //     $mediation->complainant->id_proof = $complainantIdProof;
            //     $mediation->complainant->save();
            // }

            // if ($mediation->respondent) {
            //     $mediation->respondent->id_proof = $defandantIdProof;
            //     $mediation->respondent->save();
            // }



            // Update mediation table (direct fields)
            $mediation->update([
                'court_id' => $validatedData['court_id'],
                'judge_id' => $validatedData['judge_id'] ?? null,
                'case_number' => $validatedData['case_number'],
                'reference_date' => $validatedData['reference_date'],
                'mediation_date' => $validatedData['mediation_date'],
                'order_file' => $orderFileName,
                'case_file' => $caseFileName,
                'subject_id' => $validatedData['subject_id'] ?? null,
                'issue_id' => $validatedData['issue_id'] ?? null,
                'statute_id' => $validatedData['statute_id'] ?? null,
                'complainant_advocate_id' => $validatedData['complainant_advocate_id'] ?? null,
                'defendant_advocate_id' => $validatedData['defendant_advocate_id'] ?? null,
                'mediator_id' => $validatedData['mediator_id'] ?? null,
                'status' => $validatedData['status'] ?? $mediation->status,

                'complainant_name' => $validatedData['complainant_name'],
                'complainant_father' => $validatedData['complainant_father'] ?? null,
                'complainant_dob' => $validatedData['complainant_dob'] ?? null,
                'complainant_gender' => $validatedData['complainant_gender'] ?? null,
                'complainant_address' => $validatedData['complainant_address'] ?? null,
                'complainant_state_id' => $validatedData['complainant_state_id'] ?? null,
                'complainant_city_id' => $validatedData['complainant_city_id'] ?? null,
                'complainant_district' => $validatedData['complainant_district'] ?? null,
                'complainant_pincode' => $validatedData['complainant_pincode'] ?? null,
                'complainant_mobile' => $validatedData['complainant_mobile'] ?? null,
                'complainant_email' => $validatedData['complainant_email'] ?? null,
                'complainant_id_proof' => $complainantIdProof,

                'defendant_name' => $validatedData['defendant_name'],
                'defendant_father' => $validatedData['defendant_father'] ?? null,
                'defendant_dob' => $validatedData['defendant_dob'] ?? null,
                'defendant_gender' => $validatedData['defendant_gender'] ?? null,
                'defendant_address' => $validatedData['defendant_address'] ?? null,
                'defendant_state_id' => $validatedData['defendant_state_id'] ?? null,
                'defendant_city_id' => $validatedData['defendant_city_id'] ?? null,
                'defendant_district' => $validatedData['defendant_district'] ?? null,
                'defendant_pincode' => $validatedData['defendant_pincode'] ?? null,
                'defendant_mobile' => $validatedData['defendant_mobile'] ?? null,
                'defendant_email' => $validatedData['defendant_email'] ?? null,
                'defandant_id_proof' => $defandantIdProof,
            ]);

            // Update complainant (related table)
            if ($mediation->complainant) {
                $mediation->complainant->update([
                    'name' => $validatedData['complainant_name'],
                    'father' => $validatedData['complainant_father'] ?? null,
                    'dob' => $validatedData['complainant_dob'] ?? null,
                    'gender' => $validatedData['complainant_gender'] ?? null,
                    'address' => $validatedData['complainant_address'] ?? null,
                    'state_id' => $validatedData['complainant_state_id'] ?? null,
                    'city_id' => $validatedData['complainant_city_id'] ?? null,
                    'district' => $validatedData['complainant_district'] ?? null,
                    'pincode' => $validatedData['complainant_pincode'] ?? null,
                    'mobile' => $validatedData['complainant_mobile'] ?? null,
                    'email' => $validatedData['complainant_email'] ?? null,
                    'id_proof' => $complainantIdProof,
                ]);
            }

            // Update respondent (related table)
            if ($mediation->respondent) {
                $mediation->respondent->update([
                    'name' => $validatedData['defendant_name'],
                    'father' => $validatedData['defendant_father'] ?? null,
                    'dob' => $validatedData['defendant_dob'] ?? null,
                    'gender' => $validatedData['defendant_gender'] ?? null,
                    'address' => $validatedData['defendant_address'] ?? null,
                    'state_id' => $validatedData['defendant_state_id'] ?? null,
                    'city_id' => $validatedData['defendant_city_id'] ?? null,
                    'district' => $validatedData['defendant_district'] ?? null,
                    'pincode' => $validatedData['defendant_pincode'] ?? null,
                    'mobile' => $validatedData['defendant_mobile'] ?? null,
                    'email' => $validatedData['defendant_email'] ?? null,
                    'id_proof' => $defandantIdProof,
                ]);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Mediation updated successfully.');
    }

    public function destroy($id)
    {
        $case = Mediation::findOrFail($id);
        $case->delete();

        return redirect()->route('dashboard')->with('success', 'Case deleted successfully.');
    }



}
