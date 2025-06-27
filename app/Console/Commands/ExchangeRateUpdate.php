<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExchangeRateUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force exchange rate update';

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
        $repository = resolve(\OnNow\ExchangeRate\Repositories\ExchangeRateRepository::class);
        $repository->dailyUpdate();
    }
}
