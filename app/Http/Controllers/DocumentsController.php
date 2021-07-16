<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $data = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 1)
        ->select('transactions.id', DB::raw("concat(users.firstName, ' ' ,users.lastName) as name"), 'users.email', 
                    'transactions.purpose', 'transactions.barangayIdPath' ,'transactions.status', 'availed_services.userId', 'service_maintenances.docType')
        ->get();
   
        return view('documents.index', compact('data'));
    }

    public function pdfViewDocument($transId, $userId) 
    {
        $users = User::find($userId);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        // dd($officials);

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
        $users = User::find($userId);

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

        $pdf = PDF::loadView('documents.document', compact('data', 'td', 'officials'));
        return $pdf->download('Document.pdf');
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

        return redirect('/documents/create')->with('success', 'Document requested successfully!');
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
        $paid = Transaction::where('id', $transId)->update(['status' => 'Paid']);
        return redirect('documents')->with('success', 'Document payment noted!');
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
