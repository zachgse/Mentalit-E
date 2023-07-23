<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Clinic;
use App\Models\ClinicNotification;

class Scheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $var = Clinic::all();

        for ($i=0; $i < count($var) ; $i++) { 
            if($var[$i]['subscriptionDuration'] != 0){
                $temp[$i] =  Clinic::where('id', $var[$i]->id)->decrement('subscriptionDuration', 1);

                if ($var[$i]['subscriptionDuration'] <= 10) {
                    ClinicNotification::create([
                        'clinic_id' => $var[$i]['id'],
                        'notifDescription' => 'User subscription is running out',
                        'notifDateTime' => now(),
                    ]);
                } 

            } 
        }
    }
}
