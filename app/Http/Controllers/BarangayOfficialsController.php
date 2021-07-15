<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\BarangayOfficials;
use Illuminate\Http\Request;

class BarangayOfficialsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:barangay-official-list|barangay-official-create|barangay-official-edit|barangay-official-delete', ['only' => ['index','store']]);
        $this->middleware('permission:barangay-official-create', ['only' => ['create','store']]);
        $this->middleware('permission:barangay-official-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:barangay-official-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officials = BarangayOfficials::all();
        return view('officials.index', ['officials' => $officials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('officials.create');
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
            'lastName' => 'required',
            'firstName' => 'required',
            // 'middleName' => 'required',
            'position' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',

        ]);

        $newImageName = time() . '-' . $request->lastName . '.' . $request->firstName . '.' . $request->middleName . '.' .$request->image->extension();
        
        $request->image->move(public_path('images/officials'), $newImageName);
            
        $official = BarangayOfficials::create([
            'lastName' => $request->input('lastName'),
            'firstName' => $request->input('firstName'),
            'middleName' => $request->input('middleName'),
            'position' => $request->input('position'),
            'imagePath' => $newImageName,
            // 'user_id' => auth()->user()->id

        ]);
        return redirect('/officials');
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
        $officials = BarangayOfficials::find($id);
        return view('officials.edit')->with('officials', $officials);
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
        $request->validate([
            'lastName' => 'required',
            'firstName' => 'required',
            'position' => 'required',
        ]);

        if($request->image)
        {
            $newImageName = time() . '-' . $request->lastName . ',' . $request->firstName . '.' . $request->middleName . $request->image->extension() ;   
            $request->image->move(public_path('images/officials'), $newImageName);
            
            $car = BarangayOfficials::where('id',$id)->update([
                'lastName' => $request->input('lastName'),
                'firstName' => $request->input('firstName'),
                'middleName' => $request->input('middleName'),
                'position' => $request->input('position'),
                'imagePath' => $newImageName
            ]);
        } 
        else 
        {
            $car = BarangayOfficials::where('id',$id)->update([
                'lastName' => $request->input('lastName'),
                'firstName' => $request->input('firstName'),
                'middleName' => $request->input('middleName'),
                'position' => $request->input('position'),
            ]);
        }

        return redirect('/officials')->with('success','Official updated successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangayOfficials $official)
    {
                //
        // $car = Car::find($id);
        $official->delete();
        return redirect('/officials');
    }
}
