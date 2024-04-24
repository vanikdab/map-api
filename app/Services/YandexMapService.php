<?php
namespace App\Services;

use App\Contracts\MapStrategyInterface;
use App\Presentors\MapPresenter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\Response as HttpClientResponse;

class YandexMapService implements MapStrategyInterface {

    private HttpClientResponse|null $response;
    private string $purpose;
    private string $apiKey;
    private string $apiUrl = 'https://geocode-maps.yandex.ru/1.x/';

    public function __construct()
    {
        $this->apiKey = config('services.yandex_map_api.token');
    }

    /**
     * @param string $purpose
     * @param string $input
     * @return MapStrategyInterface
     */
    public function httpRequest($purpose, $input): MapStrategyInterface
    {
        $this->purpose = $purpose;
        $this->response = match ($purpose) {
            'addressList' => $this->getAddressList($input),
        };

        return $this;
    }

    /**
     * @return Collection
     */
    public function collect(): Collection
    {
        return match ($this->purpose) {
            'addressList' => (new MapPresenter())->presentYandexAddressList($this->response->collect()),
        };
    }

    /**
     * @param string $input
     * @return HttpClientResponse
     */
    public function getAddressList(string $input): HttpClientResponse
    {
        return Http::get($this->apiUrl, [
            'apikey' => $this->apiKey,
            'format' => 'json',
            'geocode' => $input,
            'lang' => strtoupper(app()->getLocale()),
        ]);
    }
}
