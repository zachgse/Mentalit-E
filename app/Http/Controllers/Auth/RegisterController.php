<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;

//Validation Rules
use App\Rules\AlphaSpace;
use App\Rules\PHNumber;
use App\Rules\Uppercase;
use App\Rules\MiddleInitial;
use App\Rules\ZipCode;
use App\Rules\StreetNo;

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
            'firstName' => ['required', 'string', 'max:50', new AlphaSpace],
            'lastName' => ['required', 'string', 'max:50', new AlphaSpace],
            'middleName' => ['nullable', 'string', 'max:50', new AlphaSpace],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'userType' => ['required', 'string', 'max:255'],
            'birthDate' => ['required', 'date', 'before:today'],
            'gender' => 'required', 
            'contactNo' => ['required', 'max:13', new PHNumber],
            'zipCode' => ['required', new ZipCode],  
            'city' => ['required', 'max:50', new AlphaSpace],
            'barangay' => ['required','max:50'], 
            'streetNumber' => ['required', 'max:50'],   
            'consent' => 'required',
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
        $request->password;

        $user =  User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'middleName' => $data['middleName'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'userType' => $data['userType'],
            'birthDate' => $data['birthDate'],
            'gender' => $data['gender'],
            'contactNo' => $data['contactNo'],
            'zipCode' => $data['zipCode'],
            'city' => $data['city'],
            'barangay' => $data['barangay'],
            'streetNumber' => $data['streetNumber'],
            'consent' => $data['consent'],
        ]);

        return $user;
    }
}
