<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceMaintenances;
use App\Models\Services;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = ServiceMaintenances::all()->where('serviceId', '!=', 3);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serviceTypes = Services::all()->where('id', '!=', 3);
        return view('services.create', compact('serviceTypes'));
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
            'serviceType' => 'required','integer',
            'serviceName' => 'required','regex:/^[\p{L}\s-]+$/',
        ]);

        if($request->serviceType == 1)
        {
            ServiceMaintenances::create([
                'serviceId' => $request->serviceType,
                'docType' => $request->serviceName
            ]);
        }
        else
        {
            ServiceMaintenances::create([
                'serviceId' => $request->serviceType,
                'complainType' => $request->serviceName
            ]);
        }

        // ServiceMaintenances::create([
        //     'serviceId' => $request->serviceType,
        //     'docType' => $request->serviceName
        // ]);

        return redirect('/services')->with('success', 'Service added!');
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
