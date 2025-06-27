<?php

namespace App\Http\Controllers;

use App\Models\CourtMast;
use App\Models\JudgeMast;

use App\Models\CaseComplaint;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\CaseNumber;
use App\Models\Mediation;
use App\Models\State;
use App\Models\City;
use App\Models\Subject;
use App\Models\Issue;
use App\Models\Statute;
use App\Models\Advocate;
use App\Models\Mediator;
use App\Models\Complainant;
use App\Models\Respondent;


class CaseComplaintController extends Controller
{


    // Show the complaint creation form
    public function create()
{
    $courts = CourtMast::all();
    $judges = JudgeMast::all(); 
    $caseNumbers = CaseNumber::all();

    return view('complaints.create', compact('courts', 'judges', 'caseNumbers'));
}





    // Store the complaint data
    public function store(Request $request)
    {
        
        $request->validate([
            'court_id' => 'required|exists:court_mast,AG_Courtcode',
            'judge_id' => 'required|exists:judges_mast,id',
            'plaintiff' => 'required|string',
            'defendant' => 'required|string',
            'case_model_id' => 'required|exists:case_models,id', 
            'reference_date' => 'required|date',
            'order_file' => 'nullable|file|mimes:pdf',
            'case_file' => 'nullable|file|mimes:pdf',
        ]);

        // File uploads
        $orderFilePath = $request->file('order_file') ? $request->file('order_file')->store('public/orders') : null;
        $caseFilePath = $request->file('case_file') ? $request->file('case_file')->store('public/cases') : null;

        // Create complaint entry
        CaseComplaint::create([
            'court_id' => $request->court_id,
            'judge_id' => $request->judge_id,
            'plaintiff' => $request->plaintiff,
            'defendant' => $request->defendant,
            'case_model_id' => $request->case_model_id,
            'reference_date' => $request->reference_date,
            'order_file' => $orderFilePath,
            'case_file' => $caseFilePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Complaint submitted successfully.');
    }

    // Submit new case
    public function submitCase(Request $request)
    {
        //  Correct validation
        $request->validate([
            'case_model_id' => 'required|exists:case_models,id', 
            'reference_date' => 'required|date',
            'court_id' => 'required|exists:court_mast,AG_Courtcode',
            'judge_id' => 'required|exists:judges_mast,id',
            'plaintiff' => 'required|string|max:255',
            'defendant' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png|max:2048',
        ]);

        // Store new case
        $case = new CaseModel();
        $case->case_model_id = $request->case_model_id;
        $case->reference_date = $request->reference_date;
        $case->court_id = $request->court_id;
        $case->judge_id = $request->judge_id;
        $case->plaintiff = $request->plaintiff;
        $case->defendant = $request->defendant;

        if ($request->hasFile('document')) {
            $case->document_path = $request->file('document')->store('documents');
        }

        $case->save();

        return redirect()->back()->with('success', 'Case has been successfully submitted!');
    }    

}
