<?php

namespace App\Http\Controllers;

use App\Events\ProcessRequestedDocument;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AvailedServices;
use App\Models\ServiceMaintenances;
use App\Models\Services;
use App\Models\BarangayOfficials;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade;
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
        $this->middleware('permission:user-module-request-document', ['only' => ['create','store']]);
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
            $data = DB::table('transactions')
            ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            ->join('users', 'users.id', '=', 'availed_services.userId')
            ->where('service_maintenances.serviceId', 1)
            ->where('users.lastName', 'Like', '%' . request('term') . '%')
            ->orWhere('users.middleName', 'Like', '%' . request('term') . '%')
            ->orWhere('users.firstName', 'Like', '%' . request('term') . '%')
            ->orWhere('users.email', 'Like', '%' . request('term') . '%')
            ->orWhere('service_maintenances.docType', 'Like', '%' . request('term') . '%')
            ->orWhere('transactions.status', 'Like', '%' . request('term') . '%')
            ->select('transactions.id', 'users.firstName', 'users.lastName', 'users.email', 
            'transactions.purpose', 'transactions.barangayIdPath' ,'transactions.status', 'availed_services.userId', 'service_maintenances.docType')
            ->paginate(5);
            $data->appends($request->all());
        }
        else if(!$request->input('term'))
        {
            $data = DB::table('transactions')
            ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            ->join('users', 'users.id', '=', 'availed_services.userId')
            ->where('service_maintenances.serviceId', 1)
            // ->whereNull('users.deleted_at')
            ->orderBy('transactions.id','DESC')
            ->select('transactions.id', 'users.firstName', 'users.lastName', 'users.email', 
            'transactions.purpose', 'transactions.barangayIdPath' ,'transactions.status', 'availed_services.userId', 'service_maintenances.docType')
            ->paginate(5);
        }
           
        return view('documents.index', compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function pdfViewDocument($transId, $userId) 
    {
        // $users = User::find($userId);
        $users = DB::table('users')
        ->where('users.id', $userId)
        ->first();
        // dd($users);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 1)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw('date(transactions.created_at) as "date"'), 
                    'transactions.purpose', 'service_maintenances.docType')
        ->get();

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'houseNo' => $users->houseNo,
            'city' => $users->city,
            'province' => $users->province
        ];

        return view('documents.document', compact('data', 'td', 'officials'));
    }

    public function pdfSaveDocument($transId, $userId) 
    {
        // $users = User::find($userId);
        $users = DB::table('users')
        ->where('users.id', $userId)
        ->first();

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();
        
        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 1)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw('date(transactions.created_at) as "date"'), 
                    'transactions.purpose', 'service_maintenances.docType')
        ->get();

        $type = $td->pluck('docType');

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'houseNo' => $users->houseNo,
            'city' => $users->city,
            'province' => $users->province
        ];

        $pdf = PDF::loadView('documents.document', compact('data', 'td', 'officials'));
        return $pdf->download($data['lastName'].$data['firstName'].'-'.$type[0].'-'.'Document.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ServiceMaintenances::all()->where('serviceId', 1);
        // dd($data);
        // exit;
        return view('documents.create', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'docType' => 'required', 'integer',
            'transMode' => 'required', 'string',
            'purpose' => 'required', 'string',
            'paymentMode' => 'required', 'string',
            'userId' => 'required', 'integer',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',

        ]);
        if($request->input('docType')){

        
            $newImageName = time() . '-' . $request->lastName . '.' . $request->firstName . '.' . $request->middleName . '.' .$request->image->extension();
            
            $request->image->move(public_path('images/barangayId'), $newImageName);
            
            $availedService = AvailedServices::create([
                'userId' => $request->userId,
                'smId' => $request->docType
            ]);

            Transaction::create([
                'availedServiceId' => $availedService->id,
                'transMode' => $request->transMode,
                'purpose' => $request->purpose,
                'paymentMode' => $request->paymentMode,
                'status' => 'Unpaid',
                'barangayIdPath' => $newImageName
            ]);


            return redirect('home')->with('success', 'Document requested successfully!');
        }else{
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
        
    }

    public function process($transId, $userId)
    {
        $rtc = Transaction::where('id', $transId)->update(['status' => 'Ready to Claim']);

        $email = User::where('id',$userId)->pluck('email')->all();
        
        event(new ProcessRequestedDocument($email));

        return redirect('documents')->with('success', 'Document ready to claim and user emailed!');       
    }

    public function paid($transId, $userId)
    {
        $paid = Transaction::where('id', $transId)->update(['status' => 'Paid']);
        return redirect('documents')->with('success', 'Document paid!');
    }

    public function disapproved($transId, $userId)
    {
        $paid = Transaction::where('id', $transId)->update(['status' => 'Disapproved']);
        return redirect('documents')->with('danger', 'Document diapproved!');
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
