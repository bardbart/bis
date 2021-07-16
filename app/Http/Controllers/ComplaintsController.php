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
    public function index()
    {
        $data = DB::select(
            'select a.`id`, concat(b.`firstName`," ", b.`lastName`) as "name", concat(b.`houseNo`, " ", b.`street`," ",b.`city`," ",b.`province`) as "address",
                    a.`complainDetails`, a.`respondents`, a.`respondentsAdd`, a.`status`, c.`userId`
            FROM `transactions`a
            inner join `availed_services`c on a.`availedServiceId` = c.`id`
            inner join `service_maintenances`d on c.`smId` = d.`id`
            inner join `users`b on b.`id` = c.`userId`
            where d.serviceId = 2'
        );
   
        return view('complaints.index', compact('data'));
    }

    public function pdfViewComplaint($id) 
    {
        $users = User::find($id);

        $td = DB::select(
            'select a.id, date(a.created_at) as "date", a.complainDetails, a.respondents, a.respondentsAdd, d.`complainType` 
            from `transactions`a 
            inner join `availed_services`c on a.`availedServiceId` = c.`id`
            inner join `service_maintenances`d on c.`smId` = d.`id`
            inner join `users`b on b.`id` = c.`userId` 
            where d.serviceId = 2 and b.id = ?', [$id]
        );

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'houseNo' => $users->houseNo,
            'city' => $users->city,
            'province' => $users->province
        ];

        return view('complaints.form', compact('data', 'td'));
    }

    public function pdfSaveComplaint($id) 
    {
        $users = User::find($id);

        $td = DB::select(
            'select a.id, date(a.created_at) as "date", a.complainDetails, a.respondents, a.respondentsAdd, d.`complainType` 
            from `transactions`a 
            inner join `availed_services`c on a.`availedServiceId` = c.`id`
            inner join `service_maintenances`d on c.`smId` = d.`id`
            inner join `users`b on b.`id` = c.`userId` 
            where d.serviceId = 2 and b.id = ?', [$id]
        );

        $data = [
            'lastName' => $users->lastName,
            'firstName' => $users->firstName,
            'civilStatus' => $users->civilStatus,
            'citizenship' => $users->citizenship,
            'houseNo' => $users->houseNo,
            'city' => $users->city,
            'province' => $users->province
        ];

        $pdf = PDF::loadView('complaints.form', compact('data', 'td'));
        return $pdf->download('ComplaintForm.pdf');
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
            // 'respondents' => 'required', 'string',
            // 'respondentsAdd' => 'required', 'string',
            'userId' => 'required', 'integer',

        ]);


        // dd($request->complainDetails);
        
        $availedService = AvailedServices::create([
            'userId' => $request->userId,
            'smId' => $request->complainType
        ]);

        Transaction::create([
            
            'complainDetails' => $request->complainDetails,
            'respondents' => $request->respondents,
            'respondentsAdd' => $request->respondentsAdd,
            'status' => 'Unsettled',
            'availedServiceId' => $availedService->id,

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
