<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Advocate;
use App\Models\Complainant;
use App\Models\Respondent;
use App\Models\Mediator;
use App\Models\CourtMast; 
use App\Models\Subject; 
use App\Models\Issue;
use App\Models\Statute;
use App\Models\User;
use App\Models\City;
use App\Models\State;

class CrudController extends Controller
{
    //For Complainant --->

    public function appellant()
    {
        $appellants = Complainant::all();
        return view('appellants.index', compact('appellants'));
    }

    public function showComplainant($id)
    {
        $appellant = Complainant::findOrFail($id);
        return view('appellants.show', compact('appellant'));
    }

    
    public function editComplainant($id)
    {
        $appellant = Complainant::findOrFail($id);
         $cities = City::all();    
        $states = State::all();    
        return view('appellants.edit', compact('appellant', 'cities', 'states'));
    }

    public function updateComplainant(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'father' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'city_id' => 'nullable|integer',
            'district' => 'nullable|string|max:255',
            'state_id' => 'nullable|integer',
            'pincode' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'id_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $appellant = Complainant::findOrFail($id);

        if ($request->hasFile('id_proof')) {
            $file = $request->file('id_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/id_proofs'), $filename);
            $validatedData['id_proof'] = $filename;
        }

        $appellant->update($validatedData);

        return redirect()->route('appellants.index')->with('success', 'Appellant updated successfully.');
    }

    
    public function destroyComplainant($id)
    {
        $appellant = Complainant::findOrFail($id);
        $appellant->delete();

        return redirect()->route('appellants.index')->with('success', 'Appellant deleted successfully.');
    }

    // For Respondents---->
    public function Respondent()
    {
        $respondents = Respondent::all();
        return view('Respondent.index', compact('respondents'));
    }
    public function showRespondent($id)
    {
        $respondent = Respondent::findOrFail($id);
        return view('Respondent.show', compact('respondent'));
    }

    public function editRespondent($id)
    {
        $respondent = Respondent::findOrFail($id);
        $cities = City::all();    
        $states = State::all(); 
        return view('Respondent.edit', compact('respondent', 'cities', 'states'));
    }

    public function updateRespondent(Request $request, $id)
    {
        $respondent = Respondent::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'father' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'city_id' => 'nullable|integer',
            'district' => 'nullable|string|max:255',
            'state_id' => 'nullable|integer',
            'pincode' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'id_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $respondent->update($data);

        return redirect()->route('respondents.index')->with('success', 'Respondent updated successfully.');
    }

    public function destroyRespondent($id)
    {
        $respondent = Respondent::findOrFail($id);
        $respondent->delete();

        return redirect()->route('respondents.index')->with('success', 'Respondent deleted successfully.');
    }

    // For Advocates--->
    public function advocate()
    {
        $advocates = Advocate::all();
        return view('advocates.index', compact('advocates'));
    }       


    public function showAdvocate($id)
    {
        $advocate = Advocate::findOrFail($id);
        return view('advocates.show', compact('advocate'));
    }

    public function editAdvocate($id)
    {
        $advocate = Advocate::findOrFail($id);
        return view('advocates.edit', compact('advocate'));
    }


    public function updateAdvocate(Request $request, $id)
    {
        $advocate = Advocate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bar_number' => 'nullable|string|max:255',
            'emailId' => 'nullable|email',
            'mobile' => 'nullable|string|max:20',
        ]);

        $advocate->update($validated);

        return redirect()->route('advocates.index')->with('success', 'Advocate updated successfully.');
    }
    public function destroyAdvocate($id)
    {
        $advocate = Advocate::findOrFail($id);
        $advocate->delete();

        return redirect()->route('advocates.index')->with('success', 'Advocate deleted successfully.');
    }


    // For Mediators--->
    public function Mediator()
    {
        $mediators = Mediator::all();
        return view('mediators.index', compact('mediators'));
    }
    public function showMediator($id)
    {
        $mediator = Mediator::findOrFail($id);
        return view('mediators.show', compact('mediator'));
    }

    public function editMediator($id)
    {
        $mediator = Mediator::findOrFail($id);
        return view('mediators.edit', compact('mediator'));
    }

     public function updateMediator(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'address'  => 'nullable|string|max:500',
            'emailId'  => 'nullable|email|max:255',
            'mobile'   => 'nullable|string|max:15',
            'qualification' => 'nullable|string|max:255',
        ]);

        $mediator = Mediator::findOrFail($id);
        $mediator->name     = $request->name;
        $mediator->address  = $request->address;
        $mediator->emailId  = $request->emailId;
        $mediator->mobile   = $request->mobile;
        $mediator->qualification = $request->qualification;
        $mediator->save();

        return redirect()->route('mediators.index')->with('success', 'Mediator updated successfully.');
    }

    public function destroyMediator($id)
    {
        $mediator = Mediator::findOrFail($id);
        $mediator->delete();

        return redirect()->route('mediators.index')->with('success', 'Mediator deleted successfully.');
    }


    // For Courts--->
    public function court()
    {
        $courts = CourtMast::all();
        return view('courts.index', compact('courts'));
    }
    public function createCourt()
    {
        return view('courts.create');
    }

    public function storeCourt(Request $request)
    {
        $validated = $request->validate([
            'Court_Name' => 'required|string|max:255',
            'Count_code' => 'nullable|string|max:10',
        ]);

        // Manually determine the next court code
        $maxCode = CourtMast::max('AG_Courtcode');
        $newCode = $maxCode ? intval($maxCode) + 1 : 1;

        $court = new CourtMast();
        $court->AG_Courtcode = $newCode;
        $court->Court_Name = $validated['Court_Name'];
        $court->Count_code = $validated['Count_code'] ?? null;
        $court->Date_updated = now();

        $court->save();

        return redirect()->route('courts.index')->with('success', 'Court created successfully.');
    }


    public function showCourt($AG_Courtcode)
    {
        $court = CourtMast::where('AG_Courtcode', $AG_Courtcode)->firstOrFail();
        return view('courts.show', compact('court'));
    }

    public function editCourt($AG_Courtcode)
    {
        $court = CourtMast::where('AG_Courtcode', $AG_Courtcode)->firstOrFail();
        return view('courts.edit', compact('court'));
    }

    public function updateCourt(Request $request, $AG_Courtcode)
    {
        $validated = $request->validate([
            'Court_Name' => 'required|string|max:255',
            'Count_code' => 'nullable|string|max:10',
        ]);

        $court = CourtMast::findOrFail($AG_Courtcode);

        $court->Court_Name = $validated['Court_Name'];
        $court->Count_code = $validated['Count_code'] ?? $court->Count_code;

        $court->save();

        return redirect()->route('courts.index', $court->AG_Courtcode)->with('success', 'Court updated successfully.');
    }


    public function destroyCourt($AG_Courtcode)
    {
        $court = CourtMast::where('AG_Courtcode', $AG_Courtcode)->firstOrFail();
        $court->delete();

        return redirect()->route('courts.index')->with('success', 'Court deleted successfully.');
    }


    // For Subjects--->
    public function subject()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }
    public function createSubject()
    {
        return view('subjects.create');
    }

    public function storeSubject(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Generate next subject_id
    $maxId = Subject::max('subject_id');
    $newId = $maxId ? intval($maxId) + 1 : 1;

    // Create subject with both `id` and `subject_id`
    Subject::create([
        'id' => $newId,
        'subject_id' => $newId,
        'name' => $request->name,
    ]);

    return redirect()->route('subjects.index')->with('success', 'Subject added successfully.');
}



    public function showSubject($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        return view('subjects.show', compact('subject'));
    }


    public function editSubject($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        return view('subjects.edit', compact('subject'));
    }

    public function updateSubject(Request $request, $subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        $subject->update([
            'subject_id' => $request->subject_id,
            'name' => $request->name,
        ]);
        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroySubject($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }



    //// For Issues--->
    public function issue()
    {
        $issues = Issue::all();
        return view('issues.index', compact('issues'));
    }

    public function createIssue()
    {
        return view('issues.create');
    }

    public function storeIssue(Request $request)
    {
        $request->validate([
            'IssueName' => 'required|string|max:255',
            'Sub_Code' => 'nullable|string|max:255',
            'Date_updated' => 'nullable|date',
        ]);

        $maxCode = Issue::max('Issue_Code');
        $newCode = $maxCode ? $maxCode + 1 : 1; 

        Issue::create([
            'Issue_Code' => $newCode,
            'IssueName' => $request->IssueName,
            'Sub_Code' => $request->Sub_Code,
            'Date_updated' => $request->Date_updated,
        ]);

        return redirect()->route('issues.index')->with('success', 'Issue created successfully.');
    }



    public function showIssue($id)
    {
        $issue = Issue::findOrFail($id);
        return view('issues.show', compact('issue'));
    }

    public function editIssue($id)
    {
        $issue = Issue::findOrFail($id);
        return view('issues.edit', compact('issue'));
    }

    public function updateIssue(Request $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $issue->update($request->only(['IssueName', 'Issue_Code', 'Date_updated']));
        return redirect()->route('issues.index')->with('success', 'Issue updated successfully.');
    }

    public function destroyIssue($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();
        return redirect()->route('issues.index')->with('success', 'Issue deleted successfully.');
    }


    // For Statutes--->
    public function statute()
    {
        $statutes = Statute::all();
        return view('statutes.index', compact('statutes'));
    }
    public function createStatute()
    {
        return view('statutes.create');
    }

    public function storeStatute(Request $request)
    {
        $request->validate([
            'Act_Name' => 'required|string|max:90',
            'Date_updated' => 'required|string|max:20', 
            'Count_code' => 'required|string|max:50',
        ]);

        $maxCode = Statute::max('AG_StatuteCode');

        $newCode = $maxCode ? $maxCode + 1 : 1;  

        $statute = new Statute();
        $statute->AG_StatuteCode = $newCode;
        $statute->Act_Name = $request->Act_Name;
        $statute->Date_updated = $request->Date_updated;
        $statute->Count_code = $request->Count_code;
        $statute->save();

        return redirect()->route('statutes.index')->with('success', 'Statute created successfully.');
    }

    
    public function showStatute($id)
    {
        $statute = Statute::findOrFail($id);
        return view('statutes.show', compact('statute'));
    }

    public function editStatute($id)
    {
        $statute = Statute::findOrFail($id);
        return view('statutes.edit', compact('statute'));
    }

    public function updateStatute(Request $request, $id)
    {
        $statute = Statute::findOrFail($id);

        $validated = $request->validate([
            'Act_Name'     => 'required|string|max:90', 
            'Count_code'   => 'required|string|max:50',
        ]);

        $statute->update($validated);

        return redirect()->route('statutes.index')->with('success', 'Statute updated successfully.');
    }

    public function destroyStatute($id)
    {
        $statute = Statute::findOrFail($id);
        $statute->delete();

        return redirect()->route('statutes.index')->with('success', 'Statute deleted successfully.');
    }

    // For Users--->
    public function users()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function createUser()
    {
        return view('users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'role_id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Always hash passwords!
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id",
            'role_id' => 'required|integer',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = $request->password; 
        }

        $user->save();

        return redirect()->route('users.index', $user->id)->with('success', 'User updated successfully.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }


}
