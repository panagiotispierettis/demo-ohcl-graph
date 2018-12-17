<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\PopulateDbService;

class PopulateDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populatedb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates Database';

    protected $populateDb;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PopulateDbService $populateDb)
    {
        parent::__construct();

        $this->populateDb = $populateDb;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->populateDb->truncate();
        $this->populateDb->stocks();
        $this->populateDb->prices();
        $this->info("Database Populated");
    }
}
