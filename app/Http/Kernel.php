<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'SystemAdministratorMiddleware' =>  \App\Http\Middleware\SystemAdministratorMiddleware::class,
        'ClinicAdmin' =>  \App\Http\Middleware\ClinicAdmin::class,
        'ClinicEmployee' =>  \App\Http\Middleware\ClinicEmployee::class,
        'AccountStatusMiddleware' => \App\Http\Middleware\AccountStatusMiddleware::class,
        'ClinicStatus' => \App\Http\Middleware\ClinicStatus::class,
        'ClinicSubscriptionStatus' => \App\Http\Middleware\ClinicSubscriptionStatus::class,
        'EmployeeStatus' => \App\Http\Middleware\EmployeeStatus::class,
        'ClinicService' => \App\Http\Middleware\ClinicService::class,
        'ClinicBooking' => \App\Http\Middleware\ClinicBooking::class,
        'ClinicRecord1' => \App\Http\Middleware\ClinicRecord1::class,
        'ClinicRecord2' => \App\Http\Middleware\ClinicRecord2::class,
        'EmployeeBooking1' => \App\Http\Middleware\EmployeeBooking1::class,
        'EmployeeBooking2' => \App\Http\Middleware\EmployeeBooking2::class,
        'PatientMiddleware' => \App\Http\Middleware\PatientMiddleware::class,
        'PatientBooking' => \App\Http\Middleware\PatientBooking::class,
        'PatientRecord1' => \App\Http\Middleware\PatientRecord1::class,
        'PatientRecord2' => \App\Http\Middleware\PatientRecord2::class,
        'PatientJournal' => \App\Http\Middleware\PatientJournal::class,
        'OwnTicket' => \App\Http\Middleware\OwnTicket::class,
        'OwnPost' => \App\Http\Middleware\OwnPost::class,
        'Report1' => \App\Http\Middleware\Report1::class,
        'Report2' => \App\Http\Middleware\Report2::class,
        'CheckEmployee' => \App\Http\Middleware\CheckEmployee::class,
        'EmailVerify' => \App\Http\Middleware\EmailVerify::class,
        
        'signedhttps' => \App\Http\Middleware\ValidateHttpsSignature::class,
        'signed' => \App\Http\Middleware\ValidateHttpsSignature::class,
    ];
}
