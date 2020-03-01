<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Carbon\Carbon;
use App\Models\ChatMessages;
use App\Models\User;
use DB;
use App\Helpers\Commons;

class SecurityChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:security';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command security chat';

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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $submius = Carbon::now()->subMinutes(5);
        $return  = ChatMessages::deleteMessageSecret($submius);
        Log::info($return);
    }
}
