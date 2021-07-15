<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AvailedServices;
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
                    'transactions.transMode', 'transactions.purpose', 'transactions.paymentMode', 'transactions.status', 'availed_services.userId', 'service_maintenances.docType')
        ->get();
   
        return view('documents.index', compact('data'));
    }

    public function pdfViewDocument($id) 
    {
        $users = User::find($id);

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 1)
        ->where('users.id', $id)
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

        return view('documents.document', compact('data', 'td'));
    }

    public function pdfSaveDocument($id) 
    {
        $users = User::find($id);

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 1)
        ->where('users.id', $id)
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

        $pdf = PDF::loadView('documents.document', compact('data', 'td'));
        return $pdf->download('Document.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::select(
            'select id, docType from service_maintenances where serviceId = 1'
        );
        return view('documents.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'docType' => ['required', 'integer'],
            'transMode' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'paymentMode' => ['required', 'string'],
            'userId' => ['required', 'integer']
        ]);
    
        $availedService = AvailedServices::create([
            'userId' => $request->userId,
            'smId' => $request->docType
        ]);

        Transaction::create([
            'availedServiceId' => $availedService->id,
            'transMode' => $request->transMode,
            'purpose' => $request->purpose,
            'paymentMode' => $request->paymentMode,
            'status' => 'Unpaid'
        ]);

        redirect()->route('home')->with();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
