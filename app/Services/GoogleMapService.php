<?php
namespace App\Services;

use App\Contracts\MapStrategyInterface;
use App\Presentors\MapPresenter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\Response as HttpClientResponse;

class GoogleMapService implements MapStrategyInterface {

    private HttpClientResponse|null $response;
    private string $purpose;
    private string $apiKey;
    private string $origins = '40.2067086,44.5331829';
    private array $apiEndpoints = [
        'distance' => 'https://maps.googleapis.com/maps/api/distancematrix/json'
    ];

    public function __construct()
    {
        $this->apiKey = config('services.google_distance_api.token');
    }

    /**
     * @param string $purpose
     * @param string $input
     * @return MapStrategyInterface
     */
    public function httpRequest(string$purpose, string$input): MapStrategyInterface
    {
        $this->purpose = $purpose;
        $this->response = match ($purpose) {
            'distance' => $this->getDistance($input),
        };

        return $this;
    }

    /**
     * @return Collection
     */
    public function collect(): Collection
    {
        return match ($this->purpose) {
            'distance' => (new MapPresenter())->presentGoogleDistance($this->response->collect()),
        };
    }

    /**
     * @param $cords
     * @return HttpClientResponse
     */
    public function getDistance($cords): HttpClientResponse
    {
        return Http::get($this->apiEndpoints['distance'], [
            'key' => $this->apiKey,
            'units'=> 'metric',
            'origins' => $this->origins,
            'destinations' => $cords
        ]);
    }
}
