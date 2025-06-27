<?php


namespace OnNow\ExchangeRate\Services\Rate;


use Illuminate\Support\Facades\Log;
use OnNow\ExchangeRate\Services\Connection;

class ExchangeRate
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * ExchangeRate constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $base
     * @param array $symbols
     * @return mixed
     * @throws \Exception
     */
    public function getLatest(string $from = 'USD', string $to = "BRL")
    {
        $this->connection->setPath('fetch-one');
        $this->connection->setData([
            'from' => $from,
            'to' => $to
        ]);

        $response = $this->connection->exec();
        $result = $response->result;

        Log::info("Exchange Rate Response: " . json_encode($result));

        return $result->$to;
    }

}