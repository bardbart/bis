<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;
// use App\Models\AvailedServices;
use App\Models\BlottersTransactions;
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
        $this->middleware(['auth','verified']);
        $this->middleware('permission:res-module-file-blotter', ['only' => ['create','store']]);
        $this->middleware('permission:module-filed-blotters',['only' => 'index']);
        $this->middleware('permission:blotter-note',['only' => ['noted']]);
        
        // $this->middleware('permission:blotter-show',['only' => ['noted']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('term')){
            $data = DB::table('blotters_transactions')
            ->join('transactions', 'blotters_transactions.transId', '=', 'transactions.id')
            ->join('users', 'transactions.userId', '=', 'users.id')
            ->orderBy('blotters_transactions.id','DESC')
            ->where('users.lastName', 'Like', '%' . request('term') . '%')
            ->select('blotters_transactions.id', 'blotters_transactions.transId', 'blotters_transactions.blotDetails', 
                    'users.firstName','users.lastName','users.houseNo', 'users.street',
                    'transactions.status', 'transactions.userId')
            ->paginate(5);
            $data->appends($request->all());

        }else if(!$request->input('term')){
            $data = DB::table('blotters_transactions')
            ->join('transactions', 'blotters_transactions.transId', '=', 'transactions.id')
            ->join('users', 'transactions.userId', '=', 'users.id')
            ->orderBy('blotters_transactions.id','DESC')
            ->select('blotters_transactions.id', 'blotters_transactions.transId', 'blotters_transactions.blotDetails', 
                    'users.firstName','users.lastName','users.houseNo', 'users.street',
                    'transactions.status', 'transactions.userId')
            ->paginate(5);
        }
   
        return view('blotters.index', compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $smId = DB::table('service_maintenances')
        // ->where('serviceId', 3)
        // ->select('id')
        // ->get();
        return view('blotters.create');
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
        $serviceId = 3;
        $request->validate([
            'blotDetails' => 'required',
            'respondents' => ['required','regex:/^[a-zA-ZñÑ\s]+$/','string', 'max:255'],
            'respondentsAdd' => ['required','regex:/^[a-zA-ZñÑ\s]+$/','string', 'max:255'],
            // 'userId' => 'required', 'integer',
            // 'smId' => 'required', 'integer',
        ]);
        
        // $availedService = AvailedServices::create([
        //     'userId' => $request->userId,
        //     'smId' => $request->smId
        // ]);

        // Transaction::create([
        //     'availedServiceId' => $availedService->id,
        //     'blotterDetails' => $request->blotterDetails,
        //     'status' => 'Unread',
        // ]);

        $transId = Transactions::create([
            'userId' => $userId,
            'serviceId' => $serviceId,
            'status' => 'Unread',               
        ]);
        
        BlottersTransactions::create([  
            'transId' => $transId->id,
            'blotDetails' => $request->blotDetails,
            'respondents' => $request->respondents,
            'respondentsAdd' => $request->respondentsAdd,
        ]);

        return redirect('home')->with('success', 'Blotter filed successfully!');
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
        $noted = Transactions::where('id', $transId)->update(['status' => 'Noted']);
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
