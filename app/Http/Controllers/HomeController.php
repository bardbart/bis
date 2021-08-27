<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Transactions;
use App\Models\User;
use App\Models\AvailedServices;
use App\Models\ServiceMaintenances;
use App\Models\Services;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, Transactions $transaction)
    {   
            $userId = Auth::user()->id;
    
            $documents = DB::table('documents_transactions')
            // ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            // ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            // ->join('users', 'users.id', '=', 'availed_services.userId')
            // ->where('service_maintenances.serviceId', 1)
            ->join('transactions', 'documents_transactions.transId', '=', 'transactions.id')
            ->join('document_types', 'documents_transactions.dmId', '=', 'document_types.id')
            ->join('users', 'transactions.userId', '=', 'users.id')
            ->where('users.id', $userId)
            ->where('transactions.status', '<>', 'Cancelled')
            // ->whereNull('transactions.deleted_at')
            ->orderBy('documents_transactions.id','DESC')
            ->select('documents_transactions.id',  'documents_transactions.transId', DB::raw('date(documents_transactions.created_at) as "date"'), 
                    'documents_transactions.purpose', 'documents_transactions.transId', 'document_types.docType', 
                    'documents_transactions.reason', 'transactions.status', 'transactions.userId')
            ->get();
            // dd($documents);
    
        //     $complaints = DB::table('transactions')
        //     ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        //     ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        //     ->join('users', 'users.id', '=', 'availed_services.userId')
        //     ->where('service_maintenances.serviceId', 2)
        //     ->where('users.id', $userId)
        //     ->orderBy('transactions.id','DESC')
        //     ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"), 'transactions.complainDetails', 
        //             'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType',
        //             'transactions.status')
        //     ->get();
            $complaints = DB::table('complaints_transactions')
            ->join('transactions', 'complaints_transactions.transId', '=', 'transactions.id')
            ->join('users', 'users.id', '=', 'transactions.userId')
            ->where('users.id', $userId)
            ->orderBy('complaints_transactions.id','DESC')
            ->select('complaints_transactions.id', DB::raw('date(complaints_transactions.created_at) as "date"'), 
                    'complaints_transactions.respondents','complaints_transactions.compDetails', 
                    'transactions.status', 'transactions.userId')
            ->get();
    
        //     $blotters = DB::table('transactions')
        //     ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
        //     ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
        //     ->join('users', 'users.id', '=', 'availed_services.userId')
        //     ->where('service_maintenances.serviceId', 3)
        //     ->where('users.id', $userId)
        //     ->orderBy('transactions.id','DESC')
        //     ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"),
        //             'transactions.blotterDetails', 'transactions.status')
        //     ->get();
            $blotters = DB::table('blotters_transactions')
            ->join('transactions', 'blotters_transactions.transId', '=', 'transactions.id')
            ->join('users', 'users.id', '=', 'transactions.userId')
            ->where('users.id', $userId)
            ->orderBy('blotters_transactions.id','DESC')
            ->select('blotters_transactions.id', DB::raw('date(blotters_transactions.created_at) as "date"'), 
                    'blotters_transactions.respondents','blotters_transactions.blotDetails', 
                    'transactions.status')
            ->get();
            
            $xdocus = DB::table('documents_transactions')
            // ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            // ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            // ->join('users', 'users.id', '=', 'availed_services.userId')
            // ->where('service_maintenances.serviceId', 1)
            ->join('transactions', 'documents_transactions.transId', '=', 'transactions.id')
            ->join('document_types', 'documents_transactions.dmId', '=', 'document_types.id')
            ->join('users', 'users.id', '=', 'transactions.userId')
            ->where('users.id', $userId)
            ->where('transactions.status', 'Cancelled')
            ->orderBy('documents_transactions.id','DESC')
            ->select('documents_transactions.id', 
                    DB::raw('date(documents_transactions.created_at) as "date"'), 
                    DB::raw('date(documents_transactions.updated_at) as "cancelDate"'), 
                    'documents_transactions.purpose', 'documents_transactions.transId', 'documents_transactions.reason',
                    'document_types.docType','transactions.status')
            ->get();

        // return view('home', compact('documents', 'complaints', 'blotters', 'xdocus'));
        return view('home', compact('documents', 'complaints', 'blotters', 'xdocus'));
    }

    // public function fetch_data(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         $documents = DB::table('transactions')
    //         ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
    //         ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
    //         ->join('users', 'users.id', '=', 'availed_services.userId')
    //         ->where('service_maintenances.serviceId', 1)
    //         ->where('users.id', $userId)
    //         ->whereNull('transactions.deleted_at')
    //         ->orderBy('transactions.id','DESC')
    //         ->select('transactions.id', DB::raw('date(transactions.created_at) as "date"'), 
    //                     'transactions.purpose', 'service_maintenances.docType', 'transactions.status')
    //         ->paginate(5);

    //         return view('home', compact('documents'))->render();
    //     }
    // }

}
