<?php

namespace Shifat\Salat_notification\Console;

use Illuminate\Console\Command;
use Shifat\Salat_notification\Models\salat_waqt;
use Illuminate\Support\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;

class RunEveryMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:everyminute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command runs every minute';

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
        $timezone = new CarbonTimeZone('Asia/Dhaka');
        $time = Carbon::now($timezone)->format('H:i');
        $salat_waqt = salat_waqt::all();
        $notification = '';
        foreach($salat_waqt as $waqt){

            if($waqt->time){
                $salatTime = Carbon::createFromFormat('H:i:s', $waqt->time, $timezone);
                $salatTime= $salatTime->subMinute(10);
                $salatTime=$salatTime->format('H:i');

                if($time == $salatTime){
                    $notification= $waqt->name. " prayer will begin in 10 minutes. Please prepare for Salah.";
                    if(!empty($notification)){
                        $slack = curl_init("https://slack.com/api/chat.postMessage");
                        $data = http_build_query([
                        "token" => "xoxb-7617279241380-7624864435587-JHvlvEVRHcgyMVzFf4IP7TqK",
                        "channel" => "#salat-times", 
                        "text" => $notification,
                        "username" => "Salat",
                        ]);

                        curl_setopt($slack, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($slack, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($slack, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($slack, CURLOPT_SSL_VERIFYPEER, false);
                        $result = curl_exec($slack);
                        curl_close($slack);
                    }
                }
            }  
        }
    }
}
