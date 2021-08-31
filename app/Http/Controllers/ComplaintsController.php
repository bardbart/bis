<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;
// use App\Models\AvailedServices;
use App\Models\ComplaintsTransactions;
use App\Models\Hearings;
use App\Models\ServiceMaintenances;
use App\Models\Services;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade;
use PDF;

class ComplaintsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('permission:res-module-file-complaint', ['only' => ['create','store']]);
        $this->middleware('permission:module-filed-complaints', ['only' => 'index']);
        $this->middleware('permission:complaint-view-complaint-form', ['only' => 'pdfViewComplaint']);
        $this->middleware('permission:complaint-save-complaint-form', ['only' => 'pdfSaveComplaint']);
        
        // $this->middleware('permission:complaint-show-details', ['only' => 'index']);
        $this->middleware('permission:complaint-settle', ['only' => 'settle']);
        $this->middleware('permission:complaint-view-settle-form', ['only' => 'pdfViewSettle']);
        $this->middleware('permission:complaint-save-settle-form', ['only' => 'pdfSaveSettle']);

        $this->middleware('permission:complaint-escalate', ['only' => 'escalate']);
        $this->middleware('permission:complaint-view-escalation-form', ['only' => 'pdfViewEscalate']);
        $this->middleware('permission:complaint-save-escalation-form', ['only' => 'pdfSaveEscalate']);
        $this->middleware('permission:complaint-reject', ['only' => 'reject']);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('term')){
            $data = DB::table('complaints_transactions')
            ->join('transactions', 'complaints_transactions.transId', '=', 'transactions.id')
            ->join('users', 'transactions.userId', '=', 'users.id')
            ->orderBy('complaints_transactions.id','DESC')
            ->where('users.lastName', 'Like', '%' . request('term') . '%')
            ->orWhere('users.firstName', 'Like', '%' . request('term') . '%')
            ->orWhere('complaints_transactions.respondents', 'Like', '%' . request('term') . '%')
            ->select('complaints_transactions.id', 'complaints_transactions.transId', 'complaints_transactions.compDetails', 
                    'complaints_transactions.respondents', 'complaints_transactions.respondentsAdd',
                    DB::raw('date(complaints_transactions.created_at) as "date"'),
                    'users.firstName','users.lastName', 'users.houseNo', 'users.street', 
                    'transactions.status','transactions.userId')
            ->paginate(5);
            $data->appends($request->all());

        }else if(!$request->input('term')){
            $data = DB::table('complaints_transactions')
            ->join('transactions', 'complaints_transactions.transId', '=', 'transactions.id')
            ->join('users', 'transactions.userId', '=', 'users.id')
            ->orderBy('complaints_transactions.id','DESC')
            ->select('complaints_transactions.id', 'complaints_transactions.transId', 'complaints_transactions.compDetails', 
                    'complaints_transactions.respondents', 'complaints_transactions.respondentsAdd',
                    DB::raw('date(complaints_transactions.created_at) as "date"'),
                    'users.firstName','users.lastName', 'users.houseNo', 'users.street', 
                    'transactions.status','transactions.userId')
            ->paginate(5);
        }
        
        return view('complaints.index', compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function getDocData($transId, $userId)
    {
        $td = DB::table('complaints_transactions')
        ->join('transactions', 'complaints_transactions.transId', '=', 'transactions.id')
        ->join('users', 'users.id', '=', 'transactions.userId')
        ->where('users.id', $userId)
        ->where('complaints_transactions.id', $transId)
        ->select('complaints_transactions.id', DB::raw('date(complaints_transactions.created_at) as "date"'), 
                'complaints_transactions.respondents', 'complaints_transactions.respondentsAdd',
                'complaints_transactions.compDetails','users.lastName', 'users.firstName', 'users.houseNo', 'users.street','transactions.unique_code')
        ->first();
        
        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        return compact('td', 'officials');
    }

    public function pdfViewComplaint($transId, $userId) 
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];

        return view('complaints.form')->with('td', $td)->with('officials', $officials);
    }

    public function pdfSaveComplaint($transId, $userId) 
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];
        // $pdf = PDF::loadView('complaints.form', compact('data', 'td', 'officials'));
        $pdf = PDF::loadView('complaints.form', ['td' => $td,  'officials' => $officials]);
        return $pdf->download($td->lastName.'-'.'Complaint-Form.pdf');
    }

    public function pdfViewEscalate($transId, $userId)
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];

        return view('complaints.escalate')->with('td', $td)->with('officials', $officials);


        // return view('complaints.escalate', compact('data', 'td', 'officials'));
    }

    public function pdfSaveEscalate($transId, $userId)
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];
        // $pdf = PDF::loadView('complaints.form', compact('data', 'td', 'officials'));
        $pdf = PDF::loadView('complaints.escalate', ['td' => $td,  'officials' => $officials]);
        return $pdf->download($td->lastName.$td->firstName.'-'.'Escalation-Form.pdf');

        // $pdf = PDF::loadView('complaints.escalate', compact('data', 'td', 'officials'));
        // return $pdf->download($data['lastName'].$data['firstName'].'-'.'Escalation-Form.pdf');
    }

    public function pdfViewSettle($transId, $userId)
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];

        return view('complaints.settle')->with('td', $td)->with('officials', $officials);
    }

    public function pdfSaveSettle($transId, $userId)
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];
        // $pdf = PDF::loadView('complaints.form', compact('data', 'td', 'officials'));
        $pdf = PDF::loadView('complaints.settle', ['td' => $td,  'officials' => $officials]);
        return $pdf->download($td->lastName.'-'.'Settlement-Form.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data = ServiceMaintenances::all()->where('serviceId','=', 2);
        // dd($data);
        $users = User::all()->where('id', '>', 1);
        // dd($users);
        return view('complaints.create', ['users' => $users]);
    }

    public function autocompleteSearch(Request $request)
    {
        // $data = $request->complainant;
        // $query = $data['query'];
        $query = $request->get('query');
        $filterResult = User::where('firstName', 'like', '%'. $query .'%')
                            ->orwhere('lastName', 'like', '%'. $query .'%')
                            ->select('firstName', 'lastName')
                            ->get();

        return response()->json_decode($filterResult);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $userId = Auth::User()->id;
        $serviceId = 2;
        $request->validate([
            'complainantId' => ['required', 'integer'],
            'compDetails' => 'required', 'string',
            'respondents' => ['required','regex:/^[a-zA-ZñÑ\s]+$/','string', 'max:255'],
            'respondentsAdd' => 'required','string',
        ]);

        $transId = Transactions::create([
            'userId' => $request->complainantId,
            'serviceId' => $serviceId,
            'status' => 'Unsettled',
            'unique_code' => sha1(time()),               
        ]);
        
        ComplaintsTransactions::create([  
            'transId' => $transId->id,
            'compDetails' => $request->compDetails,
            'respondents' => $request->respondents,
            'respondentsAdd' => $request->respondentsAdd,
        ]);
        
        return redirect('home')->with('success', 'Complaint filed successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($compId, $userId)
    {
        $td = DB::table('complaints_transactions')
        ->join('transactions', 'complaints_transactions.transId', '=', 'transactions.id')
        ->join('users', 'users.id', '=', 'transactions.userId')
        ->where('users.id', $userId)
        ->where('complaints_transactions.id', $compId)
        ->select('complaints_transactions.id', DB::raw('date(complaints_transactions.created_at) as "date"'), 
                'complaints_transactions.respondents', 'complaints_transactions.respondentsAdd',
                'complaints_transactions.compDetails', 'complaints_transactions.transId', 
                'users.lastName', 'users.firstName', 'users.houseNo', 'users.street',
                'transactions.status', 'transactions.userId')
        ->first();

        $hearings = DB::table('hearings')
        ->join('complaints_transactions', 'hearings.compId', '=', 'complaints_transactions.id')
        ->where('hearings.compId', $compId)
        ->select('hearings.details', DB::raw('date(hearings.created_at) as "date"'))
        ->get();
        // dd($hearings[0]);

        $hearingCounts = $hearings->count();
        
        return view('complaints.show')
        ->with('td', $td)
        ->with(['hearings' => $hearings])
        ->with('hearingCounts', $hearingCounts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function settle($transId)
    {
        $settled = Transactions::where('id', $transId)->update(['status' => 'Settled']);
        return redirect()->back()->with('success', 'Complaint Settled!');
    }

    public function escalate($transId)
    {
        $settled = Transactions::where('id', $transId)->update(['status' => 'Escalated']);
        return redirect()->back()->with('warning', 'Complaint Escalated!');
    }

    public function dismiss($transId)
    {
        $settled = Transactions::where('id', $transId)->update(['status' => 'Dismissed']);
        return redirect()->back()->with('danger', 'Complaint Dismissed!');
    }

    public function recordHearing(Request $request, $compId, $transId)
    {
        $request->validate([
            'details' => 'required',
        ]);

        Hearings::create([
            'compId' => $compId,
            'details' => $request->details,
        ]);

        $onGoing = Transactions::where('id', $transId)->update(['status' => 'On Going']);

        return redirect()->back()->with('success', 'Hearing Details Recorded!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}