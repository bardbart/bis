<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Transaction;
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
    public function index(Request $request, Transaction $transaction)
    {   
            $userId = Auth::user()->id;
    
            $documents = DB::table('transactions')
            ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            ->join('users', 'users.id', '=', 'availed_services.userId')
            ->where('service_maintenances.serviceId', 1)
            ->where('users.id', $userId)
            ->whereNull('transactions.deleted_at')
            ->orderBy('transactions.id','DESC')
            ->select('transactions.id', DB::raw('date(transactions.created_at) as "date"'), 
                        'transactions.purpose', 'service_maintenances.docType', 'transactions.status')
            ->get();
    
            $complaints = DB::table('transactions')
            ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            ->join('users', 'users.id', '=', 'availed_services.userId')
            ->where('service_maintenances.serviceId', 2)
            ->where('users.id', $userId)
            ->orderBy('transactions.id','DESC')
            ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"), 'transactions.complainDetails', 
                    'transactions.respondents', 'transactions.respondentsAdd', 'service_maintenances.complainType',
                    'transactions.status')
            ->get();
    
            $blotters = DB::table('transactions')
            ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            ->join('users', 'users.id', '=', 'availed_services.userId')
            ->where('service_maintenances.serviceId', 3)
            ->where('users.id', $userId)
            ->orderBy('transactions.id','DESC')
            ->select('transactions.id', DB::raw("date(transactions.created_at) as 'date'"),
                    'transactions.blotterDetails', 'transactions.status')
            ->get();
            
            $xdocus = DB::table('transactions')
            ->join('availed_services', 'transactions.availedServiceId', '=', 'availed_services.id')
            ->join('service_maintenances', 'availed_services.smId', '=', 'service_maintenances.id')
            ->join('users', 'users.id', '=', 'availed_services.userId')
            ->where('service_maintenances.serviceId', 1)
            ->where('users.id', $userId)
            ->whereNotNull('transactions.deleted_at')
            ->orderBy('transactions.id','DESC')
            ->select('transactions.id', DB::raw('date(transactions.created_at) as "date"'),
                    DB::raw('date(transactions.deleted_at) as "cancelDate"'),
                    'transactions.purpose', 'service_maintenances.docType', 'transactions.status')
            ->get();

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

    public function cancel($transId)
    {
        $cancel = Transaction::where('id', $transId)->update(['status' => 'Cancelled']);
        $docu = Transaction::where('id', $transId)->first();
        if($docu->delete())
            return redirect()->route('home');
        else
            abort(404);
    }
}
