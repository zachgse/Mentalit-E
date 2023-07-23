<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Clinic;

class CheckSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:subscription';

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
            if($var[$i]['subscriptionDuration'] == 0){
                $var[$i]->update([
                    'clinicStatus' => false,
                ]);
                //$var[$i]['clinicStatus'] = false;
            } 
        }
    }
}
