<?php


namespace OnNow\ExchangeRate\Services;


use Ixudra\Curl\Facades\Curl;

class Connection
{

    /**
     * @var string
     */
    protected $endpoint = 'https://api.fastforex.io/';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $data = '';

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function exec()
    {
        try{

            return Curl::to($this->endpoint . $this->path)
                ->withData(array_merge($this->data, ['api_key' => '3a341a2d82-4670caadbe-qr3cpj']))
                ->asJson()
                ->get();

        } catch (\Exception $exception){
            throw $exception;
        }
    }

}