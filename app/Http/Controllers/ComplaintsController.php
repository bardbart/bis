<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AvailedServices;
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
    public function index(Request $request)
    {
        $data = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 2)
        ->orderBy('transactions.id','DESC')
        ->select('transactions.id', DB::raw("concat(users.firstName, ' ' ,users.lastName) as name"), 
                DB::raw('concat(users.houseNo, " ", users.street," ",users.city," ",users.province) as "address"'), 
                'transactions.complainDetails', 'transactions.respondents', 'transactions.respondentsAdd','transactions.status', 
                'availed_services.userId', 'service_maintenances.complainType')
        ->paginate(5);
   
        return view('complaints.index', compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function pdfViewComplaint($transId, $userId) 
    {
        $users = User::find($userId);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 2)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"), 
                DB::raw('concat(users.houseNo, " ", users.street," ",users.city," ",users.province) as "address"'),
                'transactions.complainDetails', 'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType')
        ->get();

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'houseNo' => $users->houseNo,
            'address' => $users->houseNo.' '.$users->street.' '.$users->city,
        ];

        return view('complaints.form', compact('data', 'td', 'officials'));
    }

    public function pdfSaveComplaint($transId, $userId) 
    {
        $users = User::find($userId);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 2)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"),
                DB::raw('concat(users.houseNo, " ", users.street," ",users.city," ",users.province) as "address"'), 
                'transactions.complainDetails', 'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType')
        ->get();

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'address' => $users->houseNo.' '.$users->street.' '.$users->city,
        ];

        $pdf = PDF::loadView('complaints.form', compact('data', 'td', 'officials'));
        return $pdf->download('ComplaintForm.pdf');
    }

    public function pdfViewEscalate($transId, $userId)
    {
        $users = User::find($userId);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 2)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"),
                DB::raw('concat(users.houseNo, " ", users.street," ",users.city," ",users.province) as "address"'), 
                'transactions.complainDetails', 'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType')
        ->get();

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'address' => $users->houseNo.' '.$users->street.' '.$users->city,
        ];

        return view('complaints.escalate', compact('data', 'td', 'officials'));
    }

    public function pdfSaveEscalate($transId, $userId)
    {
        $users = User::find($userId);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 2)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"),
                DB::raw('concat(users.houseNo, " ", users.street," ",users.city," ",users.province) as "address"'), 
                'transactions.complainDetails', 'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType')
        ->get();

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'address' => $users->houseNo.' '.$users->street.' '.$users->city,
        ];

        $pdf = PDF::loadView('complaints.escalate', compact('data', 'td', 'officials'));
        return $pdf->download('EscalationForm.pdf');
    }

    public function pdfViewSettle($transId, $userId)
    {
        $users = User::find($userId);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 2)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"),
                DB::raw('concat(users.houseNo, " ", users.street," ",users.city," ",users.province) as "address"'), 
                'transactions.complainDetails', 'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType')
        ->get();

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'address' => $users->houseNo.' '.$users->street.' '.$users->city,
        ];

        return view('complaints.settle', compact('data', 'td', 'officials'));
    }

    public function pdfSaveSettle($transId, $userId)
    {
        $users = User::find($userId);

        $officials = DB::table('barangay_officials')
        ->select(DB::raw('concat(firstName, " ", lastName) as "name"'), 'position')
        ->get();

        $td = DB::table('transactions')
        ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        ->join('users', 'users.id', '=', 'availed_services.userId')
        ->where('service_maintenances.serviceId', 2)
        ->where('users.id', $userId)
        ->where('transactions.id', $transId)
        ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"),
                DB::raw('concat(users.houseNo, " ", users.street," ",users.city," ",users.province) as "address"'), 
                'transactions.complainDetails', 'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType')
        ->get();

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'address' => $users->houseNo.' '.$users->street.' '.$users->city,
        ];

        $pdf = PDF::loadView('complaints.settle', compact('data', 'td', 'officials'));
        return $pdf->download('SettlementForm.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ServiceMaintenances::all()->where('serviceId','=', 2);
        // dd($data);
        return view('complaints.create', ['data' => $data]);
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
            'complainType' => 'required', 'integer',
            'complainDetails' => 'required', 'string',
            'respondents' => 'regex:/^[\p{L}\s-]+$/','required', 'string',
            'respondentsAdd' => 'required', 'string',
            'userId' => 'required', 'integer',
        ]);
        
        $availedService = AvailedServices::create([
            'userId' => $request->userId,
            'smId' => $request->complainType
        ]);

        Transaction::create([  
            'complainDetails' => $request->complainDetails,
            'respondents' => $request->respondents,
            'respondentsAdd' => $request->respondentsAdd,
            'status' => 'Unsettled',
            'availedServiceId' => $availedService->id
        ]);

        return redirect('/complaints/create')->with('success', 'Complaint filed successfully!');
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
    public function update(Request $request, $id)
    {
        //
    }

    public function settle($transId, $userId)
    {
        $settled = Transaction::where('id', $transId)->update(['status' => 'Settled']);
        return redirect('complaints')->with('success', 'Complaint Settled!');
    }

    public function escalate($transId, $userId)
    {
        $settled = Transaction::where('id', $transId)->update(['status' => 'Escalated']);
        return redirect('complaints')->with('success', 'Complaint Escalated');
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
