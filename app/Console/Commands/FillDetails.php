<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\V1\Controllers\DataController;

class FillDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detail:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Detail table ';

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
        echo 'detail filling ...';
        $DataController = new DataController;
        $DataController->fillDetails();
        echo "filling detail finish!";
    }
}
