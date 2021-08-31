<?php

namespace App\Http\Controllers;

use Auth;
use App\Events\ProcessRequestedDocument;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;
// use App\Models\AvailedServices;
use App\Models\DocumentsTransactions;
use App\Models\DocumentTypes;
use App\Models\Services;
use App\Models\BarangayOfficials;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade;
use Illuminate\Support\Facades\Hash;
use PDF;

class DocumentsController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('permission:res-module-request-document', ['only' => ['create','store']]);
        $this->middleware('permission:module-requested-documents',['only' => 'index']);
        // $this->middleware('permission:documents-show-ID', ['only' => ['create','store']]);
        $this->middleware('permission:documents-process',['only' => 'process']);
        $this->middleware('permission:documents-view', ['only' => 'pdfViewDocument']);
        $this->middleware('permission:documents-save-PDF',['only' => 'pdfSaveDocument']);
        $this->middleware('permission:documents-disapprove',['only' => 'disapproved']);



        // $this->middleware();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('term'))
        {
            $data = DB::table('documents_transactions')
            ->join('transactions', 'documents_transactions.transId', '=', 'transactions.id')
            ->join('document_types', 'documents_transactions.dmId', '=', 'document_types.id')
            ->join('users', 'transactions.userId', '=', 'users.id')
            ->where('users.lastName', 'Like', '%' . request('term') . '%')
            ->orWhere('document_types.docType', 'Like', '%' . request('term') . '%')
            ->orderBy('documents_transactions.id','DESC')
            ->select('documents_transactions.id', 'documents_transactions.transId', 'documents_transactions.purpose', 
                    'documents_transactions.barangayIdPath', DB::raw('date(documents_transactions.created_at) as "date"'),
                    'users.firstName', 'users.lastName', 'users.email', 
                    'transactions.status', 'transactions.userId', 'document_types.docType')
            ->paginate(6);
            $data->appends($request->all());
        }
        else if(!$request->input('term'))
        {
            $data = DB::table('documents_transactions')
            ->join('transactions', 'documents_transactions.transId', '=', 'transactions.id')
            ->join('document_types', 'documents_transactions.dmId', '=', 'document_types.id')
            ->join('users', 'users.id', '=', 'transactions.userId')
            ->orderBy('documents_transactions.id','DESC')
            ->select('documents_transactions.id', 'documents_transactions.transId', 'documents_transactions.purpose', 
                    'documents_transactions.barangayIdPath', DB::raw('date(documents_transactions.created_at) as "date"'),
                    'users.firstName', 'users.lastName', 'users.email', 
                    'transactions.status', 'transactions.userId', 'document_types.docType')
            ->paginate(6);
        }
           
        return view('documents.index', compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 6);
    }

    public function getDocData($transId, $userId)
    {
        $td = DB::table('documents_transactions')
        ->join('transactions', 'documents_transactions.transId', '=', 'transactions.id')
        ->join('document_types', 'documents_transactions.dmId', '=', 'document_types.id')
        ->join('users', 'users.id', '=', 'transactions.userId')
        ->where('users.id', $userId)
        ->where('documents_transactions.id', $transId)
        ->select('documents_transactions.id', DB::raw('date(documents_transactions.created_at) as "date"'), 
                'documents_transactions.purpose', 'document_types.docType',
                'users.lastName', 'users.firstName', 'users.civilStatus', 'users.citizenship', 'users.houseNo','transactions.unique_code')
        ->first();
        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();
        
        return compact('td', 'officials');
    }

    public function pdfViewDocument($transId, $userId) 
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];
        return view('documents.document')->with('td', $td)->with('officials', $officials);
    }

    public function pdfSaveDocument($transId, $userId) 
    {
        $document = $this->getDocData($transId, $userId);
        $td = $document['td'];
        $officials = $document['officials'];
        // dd($td);
        // $pdf = PDF::loadView('documents.document')->with('td', $td)->with('officials', $officials);
        $pdf = PDF::loadView('documents.document', ['td' => $td,  'officials' => $officials]);
        return $pdf->download($td->lastName.'-'.$td->firstName.'-'.$td->docType.'-'.'Document.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $doctypes = DocumentTypes::select('id','docType')->get();
        return view('documents.create', compact('doctypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::User()->id;
        $serviceId = 1;
        $request->validate([
            'docType' => 'required', 'integer',
            // 'transMode' => 'required', 'string',
            'purpose' => 'required', 'string',
            // 'paymentMode' => 'required', 'string',
            // 'userId' => 'required', 'integer',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',

        ]);
        if($request->input('docType'))
        {
            $newImageName = time() . '-' . $request->lastName . '.' . $request->firstName . '.' . $request->middleName . '.' .$request->image->extension();
            $request->image->move(public_path('images/barangayId'), $newImageName);
            
            $transId = Transactions::create([
                'userId' => $userId,
                // 'transMode' => $request->transMode,
                'serviceId' => $serviceId,
                // 'paymentMode' => $request->paymentMode,
                'status' => 'Unpaid',
                'unique_code' => sha1(time()),

            ]);

            DocumentsTransactions::create([
                'transId' => $transId->id,
                'dmId' => $request->docType,
                'purpose' => $request->purpose,
                'barangayIdPath' => $newImageName,
                'reason' => 'Still in Review'
            ]);

            return redirect('home')->with('success', 'Document requested successfully!');
        }
        else
        {
            return redirect('home')->with('danger', 'Select document type!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update($id, $userId)
    {
        //
    }

    public function reason(Request $request, $docId, $transId, $userId)
    {
        $request->validate([
            'reason' => 'string',
            'otherReason' => 'nullable',
            'submit' => 'string',
        ]);

        // dd($transId);

        if($request->otherReason == null)
        {
            DocumentsTransactions::where('id', $docId)->update(['reason' => $request->reason]);       
        }
        else    
        {
            DocumentsTransactions::where('id', $docId)->update(['reason' => $request->otherReason]);  
        }

        if($request->submit == 'process')
        {
            $this->process($transId, $userId);
            return redirect('documents')->with('success', 'Document is ready to claim and user emailed!');
        }
        else if($request->submit == 'disapprove')
        {
            $this->disapproved($transId);
            return redirect('documents')->with('danger', 'Document diapproved!');
        }
        else if($request->submit == 'cancel')
        {
            $this->cancel($transId);
            return redirect('home')->with('danger', 'Document Request Cancelled!');
        } 
    }

    public function process($transId, $userId)
    {
        $rtc = Transactions::where('id', $transId)->update(['status' => 'Ready to Claim']);

        $email = User::where('id', $userId)->pluck('email')->all();
        
        event(new ProcessRequestedDocument($email));
    }
    
    public function disapproved($transId)
    {
        $paid = Transactions::where('id', $transId)->update(['status' => 'Disapproved']);
    }
    
    public function cancel($transId)
    {
        $cancel = Transactions::where('id', $transId)->update(['status' => 'Cancelled']);
    }

    public function paid($transId)
    {
        $paid = Transactions::where('id', $transId)->update(['status' => 'Paid']);
        return redirect('documents')->with('success', 'Document paid!');
    }

    public function checkDoc(Request $request)
    {
        $result = Transactions::where('unique_code',$request->input('code'))->pluck('unique_code')->toArray();
        return view('scanner.resultView', ['result' => $result]);
    }
    public function scan()
    {
        $instascanJS = true;
        return view('scanner.scanView', compact('instascanJS'));
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
