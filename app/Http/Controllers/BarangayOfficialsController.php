<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\BarangayOfficials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangayOfficialsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('permission:user-barangay-official-list', ['only' => ['index']]);
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
        $officials = DB::table('barangay_officials')
        ->whereIn('position', array("Chairman", "Councilor", "SK Chairman", "Secretary", "Treasurer"))
        ->orderBy(DB::raw(
            'CASE position
             WHEN "Chairman" THEN 1
             WHEN "Councilor" THEN 2
             WHEN "SK Chairman" THEN 3
             WHEN "Secretary" THEN 4
             WHEN "Treasurer" THEN 5
             END'
        ))
        ->get();
        $off = BarangayOfficials::all()->count();
        return view('officials.index', [
            'officials' => $officials,
            'off' => $off
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $officials = [
            'cm' => BarangayOfficials::where('position','=','Chairman')->count(),
            'coun' => BarangayOfficials::where('position','=','Councilor')->count(),
            'sk' => BarangayOfficials::where('position','=','SK Chairman')->count(),
            'sec' => BarangayOfficials::where('position','=','Secretary')->count(),
            'tre' => BarangayOfficials::where('position','=','Treasurer')->count()
        ];
  
        // dd();

        return view('officials.create',compact('officials'));
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
        return redirect('/officials')->with('success', 'Official added!');
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
        // dd($request->input());

        $request->validate([
            'lastName' => ['required','regex:/^[a-zA-Z\s]+$/','string', 'max:255'],
            'firstName' => ['required','regex:/^[a-zA-Z\s]+$/','string', 'max:255'],
            'middleName' => ['nullable','regex:/^[a-zA-Z\s]+$/', 'string', 'max:255'],
            'image' => 'mimes:jpg,png,jpeg|max:5048',
        ]);

        if($request->image)
        {
            $newImageName = time() . '-' . $request->lastName . ',' . $request->firstName . '.' . $request->middleName . $request->image->extension() ;   
            $request->image->move(public_path('images/officials'), $newImageName);
            
            BarangayOfficials::where('id',$id)->update([
                'lastName' => $request->input('lastName'),
                'firstName' => $request->input('firstName'),
                'middleName' => $request->input('middleName'),
                'imagePath' => $newImageName
            ]);
        } 
        else 
        {
            BarangayOfficials::where('id',$id)->update([
                'lastName' => $request->input('lastName'),
                'firstName' => $request->input('firstName'),
                'middleName' => $request->input('middleName'),
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
