<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Contracts\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lastName' => ['required', 'string', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            // 'middleName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contactNo' => ['integer'],
            'houseNo' => ['required', 'string'],
            'street' => ['required', 'string'],
            'zipCode' => ['required', 'integer'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'dob' => ['required', 'date'],  
            'gender' => ['required', 'string'],
            'civilStatus' => ['required', 'string'],
            'citizenship' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'lastName' => $data['lastName'],
            'firstName' => $data['firstName'],
            'middleName' => $data['middleName'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'contactNo' => $data['contactNo'],
            'houseNo' => $data['houseNo'],
            'street' => $data['street'],
            'zipCode' => $data['zipCode'],
            'province' => $data['province'],
            'city' => $data['city'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'civilStatus' => $data['civilStatus'],
            'citizenship' => $data['citizenship'],
        ]);

        $user->assignRole('User');

        $user->syncPermissions([
            'module-services',
            'module-barangay-officials',
            'document-request',
            'complaint-file',
            'blotter-file',
            'barangay-official-list'
        ]);


        return $user;

    }
}