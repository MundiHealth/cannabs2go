<?php


namespace OnNow\ExchangeRate\Job;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailyUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $repository = resolve(\OnNow\ExchangeRate\Repositories\ExchangeRateRepository::class);
        $repository->dailyUpdate();
    }
}