<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\ChatMessages;
class UpdateParentMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:updateparent';

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
     * @return mixed
     */
    public function handle()
    {
        //

        $userLogin = null;
        $listMessages = ChatMessages::where("messageId", 0)->select("id")->offset(0)->limit(2000)->get() ;
        $count = 1;
        foreach($listMessages as $k => $v) {
           
            $id = $v['id'];
            $arr = ChatMessages::getArrElementChild($id, $userLogin, $cond = 1);
            if(count($arr)  > 0) {
                echo '====';
                print_r($arr);
                ChatMessages::whereIn("id",$arr)->update(['parentMessId' => $id ]);
            }
            //ChatMessages::whereIn("id",$arr)->update(['parentMessId' => $id ]);
            $count++;
        }
        
        Log::info("Update Parent Message" . $count);
    }
}
