<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Achievement;
use App\Models\AchievementDriver;
use App\Events\EventAchievementDemo;

class AchievenmentDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'end:achievement_demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End Achievenment Demo';

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
    public function handle() {
        Log::info('End Achievement Demo');
        //todo handle end achievement
        $achievement = Achievement::where('key', Achievement::KEY_DEMO)->first();
        Log::info($achievement);
        if (!$achievement || $achievement->status == Achievement::STATUS_END) {
            return;
        }

        $achievementDrivers = AchievementDriver::where('achievementKey', $achievement->key)->select('driverId')->get();

        try {
            foreach ($achievementDrivers as $value) {
                event(new EventAchievementDemo($value->driverId, $achievement));
            }

            $achievement->status = Achievement::STATUS_END;
            $achievement->save();

        } catch (Exception $ex) {
            Log::error('Error to save achievement');
        }
    }
}