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

class BlottersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

        $this->middleware('permission:user-module-file-blotter', ['only' => ['create','store']]);
        $this->middleware('permission:module-filed-blotters',['only' => 'index']);
        $this->middleware('permission:blotter-note',['only' => ['noted']]);
        
        // $this->middleware('permission:blotter-show',['only' => ['noted']]);
        

    }
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
        ->where('service_maintenances.serviceId', 3)
        ->select('transactions.id', DB::raw("concat(users.firstName, ' ' ,users.lastName) as name"), 
                DB::raw("concat(users.houseNo, ' ', users.street,' ',users.city,' ',users.province) as 'address'"),
                'transactions.blotterDetails', 'transactions.status', 'availed_services.userId')
        ->get();
   
        return view('blotters.index', compact('data')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $smId = DB::table('service_maintenances')
        ->where('serviceId', 3)
        ->select('id')
        ->get();
        return view('blotters.create', compact('smId'));
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
            'blotterDetails' => 'required', 'integer',
            'userId' => 'required', 'integer',
            'smId' => 'required', 'integer',
        ]);
        
        $availedService = AvailedServices::create([
            'userId' => $request->userId,
            'smId' => $request->smId
        ]);

        Transaction::create([
            'availedServiceId' => $availedService->id,
            'blotterDetails' => $request->blotterDetails,
            'status' => 'Unread',
        ]);

        return redirect('/blotters/create')->with('success', 'Blotter filed successfully!');
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

    public function noted($transId, $userId)
    {   
        $noted = Transaction::where('id', $transId)->update(['status' => 'Noted']);
        return redirect('blotters')->with('success', 'Blotter noted!');
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
