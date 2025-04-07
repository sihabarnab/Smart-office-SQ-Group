<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestingCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:cron';

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
          $result = app('App\Http\Controllers\HrmBackOfficeController')->AutoAttProcess01();

        DB::table('pro_yesno')->insert([
            'yesno_name'=>'kl',
            'valid'=>1,
        ]);
        
        \Log::info("Testing Cron is Running ... $result !");
    }
}
