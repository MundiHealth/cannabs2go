<?php


namespace OnNow\ExchangeRate\Repositories;


use Illuminate\Database\QueryException;
use OnNow\ExchangeRate\Services\Rate\ExchangeRate;
use Webkul\Core\Eloquent\Repository;
use Webkul\Core\Models\CurrencyExchangeRate;
use Webkul\Core\Repositories\CurrencyRepository;

class ExchangeRateRepository extends Repository
{

    /**
     * @var ExchangeRate
     */
    protected $exchangeRate;

    protected $currencyRepository;

    protected $currencyExchangeRateModel;

    /**
     * ExchangeRateRepository constructor.
     * @param ExchangeRate $exchangeRate
     */
    public function __construct(
        ExchangeRate $exchangeRate,
        CurrencyRepository $currencyRepository,
        CurrencyExchangeRate $currencyExchangeRate
    )
    {
        $this->exchangeRate = $exchangeRate;

        $this->currencyRepository = $currencyRepository;

        $this->currencyExchangeRateModel = $currencyExchangeRate;
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Core\Contracts\CurrencyExchangeRate';
    }

    /**
     * @param string $currencyCode
     */
    public function dailyUpdate($currencyCode = 'BRL'): void
    {
        $currency = $this->currencyRepository->findOneWhere(['code' => $currencyCode]);

        $rate = $this->exchangeRate->getLatest();
        $calc = $rate * 1.83;

        try{

            $this->currencyExchangeRateModel->newQuery()
                ->where('target_currency', $currency->id)
                ->first()
                ->update(['rate' => $calc]);

        } catch (QueryException $exception){

            throw new $exception;

        }
    }

}