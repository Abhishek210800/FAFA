<?php

namespace App\Http\Controllers;

use App\Models\Mediation;
use App\Models\CaseModel;
use App\Models\CourtMast;
use App\Models\JudgeMast;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Http;
use App\Models\SupportMessage;

class DashboardController extends Controller
{
    
    public function recentMediations()
    {
        $recentCases = Mediation::with(['caseModel'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', compact('recentCases'));
    }

    public function index()
{
    $today = now()->startOfDay();

    $pendingCases = Mediation::where('status', 'Active')
        ->whereDate('reference_date', '<=', $today)
        ->count();

    $resolvedCases = Mediation::where('status', 'Closed')->count();

    $upcomingHearings = Mediation::where('status', 'Active')
        ->whereDate('reference_date', '>', $today)
        ->count();

    $recentCases = Mediation::with(['court', 'judge', 'caseModel']) // Include caseModel here
        ->orderBy('created_at', 'desc')
        ->take(20)
        ->get();

    $caseNumbers = CaseModel::select('id', 'case_number')
        ->orderBy('created_at', 'desc')
        ->take(50)
        ->get();

    $judges = JudgeMast::all();
    $courts = CourtMast::all();
    $cases = Mediation::all();

    $unreadMessages = SupportMessage::where('is_read', false)
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'pendingCases',
        'resolvedCases',
        'upcomingHearings',
        'recentCases',
        'caseNumbers',
        'judges',
        'courts',
        'cases',
        'unreadMessages'
    ));
}

    public function filterByStatus($status)
    {
        $today = now()->startOfDay();

        if ($status === 'pending') {
            $cases = Mediation::where('status', 'Active')
                ->whereDate('reference_date', '<=', $today)
                ->get();
        } elseif ($status === 'resolved') {
            $cases = Mediation::where('status', 'Closed')->get();
        } elseif ($status === 'upcoming') {
            $cases = Mediation::where('status', 'Active')
                ->whereDate('reference_date', '>', $today)
                ->get();
        } else {
            abort(404);
        }

        return view('cases.filtered', compact('cases', 'status'));
    }

    public function show($id)
    {
        $case = Mediation::with(['complainant', 'respondent'])->findOrFail($id);
        return view('cases.show', compact('case'));
    }


    public function summarizeOrder(Request $request, $id)
    {
        return $this->doSummarize($id, 'order_file', 'order_summary');
    }

    public function summarizeCase(Request $request, $id)
    {
        return $this->doSummarize($id, 'case_file',  'case_summary');
    }

    protected function doSummarize($id, $fileColumn, $summaryColumn)
    {
        $case = \App\Models\Mediation::findOrFail($id);

        if (! $case->$fileColumn) {
            return response()->json(['error' => ucfirst($fileColumn) . ' missing.'], 404);
        }

        $path = storage_path('app/public/'.$case->$fileColumn);
        if (! file_exists($path)) {
            return response()->json(['error' => 'File not found on disk.'], 404);
        }

        $text = (new \Smalot\PdfParser\Parser())->parseFile($path)->getText();
        if (strlen(trim($text)) < 50) {
            return response()->json(['error' => 'PDF too short.'], 400);
        }

        $text = substr($text, 0, 15000);

        $prompt = <<<PROMPT
    You are a legal assistant. Given the following legal document, extract and return a structured JSON in this format:

    {
    "dates": ["12-Jan-2023: Petition filed", "25-Mar-2023: First hearing"],
    "facts": ["Fact 1...", "Fact 2..."],
    "summary": "A short 3-4 line summary of the case."
    }

    Here is the document:
    $text
    PROMPT;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.env('OPENROUTER_API_KEY'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'mistralai/mistral-7b-instruct',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a legal assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $output = $response->json();
        $content = $output['choices'][0]['message']['content'] ?? null;

        if (! $content) {
            return response()->json(['error' => 'No summary returned.'], 500);
        }

        $parsed = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'error' => 'Failed to parse structured summary.',
                'raw' => $content
            ], 500);
        }

        // Save plain summary if you still want
        $case->$summaryColumn = $parsed['summary'] ?? '';
        $case->save();

        return response()->json([
            'dates' => $parsed['dates'] ?? [],
            'facts' => $parsed['facts'] ?? [],
            'summary' => $parsed['summary'] ?? '',
        ]);
    }


    //for chatbot 

   public function store(Request $request)
    {
        SupportMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'issue_type' => $request->input('issue_type'),
            'message' => $request->input('message'),
            'is_read' => false,
        ]);

        return redirect()->route('dashboard')->with('success', 'Your message has been submitted successfully!');
    }


    public function notifications()
    {
        $messages = SupportMessage::latest()->paginate(10);
        return view('notifications.index', compact('messages'));
    }

    public function markRead($id)
    {
        $message = SupportMessage::findOrFail($id);
        $message->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Message marked as read.');
    }


}
