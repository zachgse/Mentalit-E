<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Award;
use Carbon\Carbon;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstName' => 'Zach Gabriel',
            'lastName' => 'Estrella',
            'middleName' => 'Salonga',
            'email' => 'systemadmin@gmail.com',
            'password' => Hash::make('%mt:3G-+jwk'),
            'userType' => 'SystemAdmin',
            'birthDate' => now(),
            'gender' => 'Male',
            'contactNo' => '09770971214',
            'zipCode' => '1004',
            'city' => 'Manila',
            'barangay' => 'Barangay 707',
            'streetNumber' => '945',
            'email_verified_at' => now(),
            'created_at' => now(),
            'status' => true,
            'consent' => true,
        ]);

        User::create([
            'firstName' => 'Miguel',
            'lastName' => 'Cerrer',
            'middleName' => 'Romerosa',
            'email' => 'clinicadmin@gmail.com',
            'password' => Hash::make('%mt:3G-+jwk'),
            'userType' => 'ClinicAdmin',
            'birthDate' => now(),
            'gender' => 'Male',
            'contactNo' => '09123456789',
            'zipCode' => '5000',
            'city' => 'Manila',
            'barangay' => 'Barangay 187',
            'streetNumber' => '0101',
            'email_verified_at' => now(),
            'created_at' => now(),
            'status' => true,
            'consent' => true,
        ]);        

        User::create([
            'firstName' => 'Ralph Lance',
            'lastName' => 'Dahilig',
            'middleName' => 'Martin',
            'email' => 'clinicemployee@gmail.com',
            'password' => Hash::make('%mt:3G-+jwk'),
            'userType' => 'ClinicEmployee',
            'birthDate' => now(),
            'gender' => 'Male',
            'contactNo' => '09123456789',
            'zipCode' => '1000',
            'city' => 'Caloocan',
            'barangay' => 'Barangay Tibay',
            'streetNumber' => '69',
            'email_verified_at' => now(),
            'created_at' => now(),
            'status' => true,
            'consent' => true,
        ]);

        User::create([
            'firstName' => 'Michail Joaquin',
            'lastName' => 'Dela Cruz',
            'middleName' => 'Teodosio',
            'email' => 'patient@gmail.com',
            'password' => Hash::make('%mt:3G-+jwk'),
            'userType' => 'Patient',
            'birthDate' => now(),
            'gender' => 'Male',
            'contactNo' => '09123456789',
            'zipCode' => '1020',
            'city' => 'Paranaque',
            'barangay' => 'Barangay Lambot',
            'streetNumber' => '143',
            'email_verified_at' => now(),
            'created_at' => now(),
            'status' => true,
            'consent' => true,
        ]);

        Subscription::create([
            'subName' => 'Basic',
            'subPrice' => '200',
            'subLength' => '30',
        ]);

        Subscription::create([
            'subName' => 'Advanced',
            'subPrice' => '500',
            'subLength' => '90',
        ]);

        Subscription::create([
            'subName' => 'Premium',
            'subPrice' => '1000',
            'subLength' => '180',
        ]);

        Award::create([
            'awardName' => 'Helpful in Community',
            'awardImage' => 'storage/awards/award1.png',
        ]);

        Award::create([
            'awardName' => 'Outstanding Performance',
            'awardImage' => 'storage/awards/award2.png',
        ]);

    }
}

