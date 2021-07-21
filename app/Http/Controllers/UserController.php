<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('permission:module-usrmngmnt', ['only' => ['index']]);
        $this->middleware('permission:usrmngmnt-show', ['only' => ['show']]);
        $this->middleware('permission:usrmngmnt-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:usrmngmnt-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {   
        if($request->input('term')){
            $data = User::where('firstName', 'Like', '%' . request('term') . '%')
            ->orWhere('lastName', 'Like', '%' . request('term') . '%')
            ->orWhere('middleName', 'Like', '%' . request('term') . '%')
            ->paginate(5);

        }else if(!$request->input('term')){
            $data = User::orderBy('id','DESC')->paginate(5);
        }

        
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $roles = Role::pluck('name','name')->all();

    //     // dd(compact('roles'));
    //     // exit();
    //     return view('users.create',compact('roles'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'lastName' => ['required', 'string', 'max:255'],
    //         'firstName' => ['required', 'string', 'max:255'],
    //         // 'middleName' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'contactNo' => ['integer'],
    //         'houseNo' => ['required', 'string'],
    //         'street' => ['required', 'string'],
    //         'zipCode' => ['required', 'integer'],
    //         'province' => ['required', 'string'],
    //         'city' => ['required', 'string'],
    //         'dob' => ['required', 'date'],  
    //         'gender' => ['required', 'string'],
    //         'civilStatus' => ['required', 'string'],
    //         'citizenship' => ['required', 'string'],

    //     ]);
    
    //     $input = $request->all();
    //     $input['password'] = Hash::make($input['password']);
    
    //     $user = User::create($input);
    //     $user->assignRole($request->input('roles'));
    
    //     return redirect()->route('users.index')
    //                     ->with('success','User created successfully');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        
        // $permissions = $user->getAllPermissions();
        return view('users.show',compact('user'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        $permission = Permission::get();
        // $userPermissions= DB::table("model_has_permissions")->where("model_has_permissions.model_id",$id)
        // ->pluck('model_has_permissions.permission_id', 'model_has_permissions.permission_id')
        // ->all();
        $userPermissions = $user->getPermissionNames()->all();
        // dd($userPermissions);
        // exit();

        return view('users.edit',compact('user','roles','userRole','permission', 'userPermissions'));
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
        $this->validate($request, [

            'roles' => 'required',
            'permission' => 'required'
        ]);
    

    
        $user = User::find($id);
        // $permission = Permission::get();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        // dd($request->input('roles'));
        // if($request->input('roles')){
            
        //     if($request->input('roles') == 'Admin'){
        //         // $user->syncPermissions(Permission::pluck('name'));
        //         dd(Permission::pluck('name'));
        //     }
        //     else if($request->input('roles')== 'User'){
        //         // $user->syncPermissions(DB::table('permissions')->where('name', 'like', '%user%')->pluck('name'));
        //         dd(DB::table('permissions')->where('name', 'like', '%user%')->pluck('name'));
        //     }
        // }


  
        // $permissions = DB::table('permissions')->where('name', 'like', '%user%')->pluck('name');
        // dd($permissions);

        // ->where('name','LIKE','%barangay%')
        
        // dd($request->input('permission'));
        // exit();

        // if(empty($request->input('permission'))){
        //     $user->revokePermissionTo($permission);
        // }

        // dd(count($request->input('permission')));

        $permissionsLength = count($request->input('permission'));

    //    dd($permissionsLength);
        
        if($request->input('permission') && $permissionsLength > 1){
            for($i=1; $i < $permissionsLength; $i++)
            {   
                // dd($request->input('permission[$i]'));
                $perm[] = $request->input("permission.$i");

            }
            $user->syncPermissions($perm);
            // dd($perm);
        }else if($permissionsLength === 1){
            $user->revokePermissionTo(Permission::pluck('name')->toArray());
        }

        // dd($role[0]);

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // User::find($id)->delete();

        $user = User::where('id',$id)->first();
        if($user->delete())
            return redirect()->route('users.index')->with('success','User deleted successfully');
        else
            abort(404);

        // return redirect()->route('users.index')
        //                 ->with('success','User deleted successfully');
    }
}
