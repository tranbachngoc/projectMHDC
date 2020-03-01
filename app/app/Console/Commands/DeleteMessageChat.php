<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Carbon\Carbon;
use App\Models\ChatMessages;
use App\Models\User;
use DB;
use App\Helpers\Commons;
class DeleteMessageChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message_chat:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Delete Message Chat';

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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $current_date = date('Y-m-d');
        $current_time = date('H:i');
        $one_week_ago = Carbon::now()->subWeeks(1);
        $messageDeleted = ChatMessages::getListMessageDeleted($one_week_ago);
        echo $messageDeleted;
        Log::info($messageDeleted);

        /*$listUser = User::get();
        foreach ( $listUser as $k => $v) {
            $address = $v['use_address'];
            $infoLatLng = Commons::getLatLng($address);
            DB::table('tbtt_user')
            ->where('use_id', $v['use_id'])
            ->update(['use_lat' => $infoLatLng['lat'],'use_lng' => $infoLatLng['lng']]);

        }
        */

    }
}
