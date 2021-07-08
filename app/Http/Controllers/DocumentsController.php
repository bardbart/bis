<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AvailedServices;
use App\Models\Services;
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
        $data = DB::select(
            'select a.`id`, concat(b.`firstName`, " ", b.`lastName`) as "name", b.`email`, a.`transMode`, a.`purpose`, a.`paymentMode`, a.`status`, c.`userId`, d.`docType` 
            FROM `transactions`a
            inner join `availed_services`c on a.`availedServiceId` = c.`id`
            inner join `service_maintenances`d on c.`smId` = d.`id`
            inner join `users`b on b.`id` = c.`userId`
            where d.serviceId = 1'
        );

        return view('documents.index', compact('data'));
    }

    public function pdfView($id) 
    {
        $users = User::find($id);

        $td = DB::select(
            'select a.id, date(a.created_at) as "date", d.`docType` from `transactions`a 
            inner join `availed_services`c on a.`availedServiceId` = c.`id`
            inner join `service_maintenances`d on c.`smId` = d.`id`
            inner join `users`b on b.`id` = c.`userId` 
            where b.id = ?', [$id]
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

        // dd(compact('data'),compact('td'), $td);
             
        return view('documents.indigency', compact('data', 'td'));
    }

    public function pdfSave($id) 
    {

        $users = User::find($id);

        $td = DB::select(
            'select a.id, date(a.created_at) as "date", d.`docType` from `transactions`a 
            inner join `availed_services`c on a.`availedServiceId` = c.`id`
            inner join `service_maintenances`d on c.`smId` = d.`id`
            inner join `users`b on b.`id` = c.`userId` 
            where b.id = ?', [$id]
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
          
        $pdf = PDF::loadView('documents.indigency', compact('data', 'td'));
    
        return $pdf->download('document.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::select(
            'select id, docType from service_maintenances'
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
            'lastName' => ['required', 'string', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            'middleName' => ['required', 'string', 'max:255'],
            'houseNo' => ['required', 'string'],
            'street' => ['required', 'string'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'civilStatus' => ['required', 'string'],
            'citizenship' => ['required', 'string'],
            'docType' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'transMode' => ['required', 'string'],
            'paymentMode' => ['required', 'string']
        ]);
    
        $input = $request->all();
        $user = Transactions::create($input);
        return redirect()->route('home')
                        ->with('success','Document Requested successfully');
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
