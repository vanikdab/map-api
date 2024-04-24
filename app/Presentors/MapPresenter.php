<?php


namespace App\Presentors;


use Illuminate\Support\Collection;

class MapPresenter
{
    /**
     * @param Collection $responseCollection
     * @return Collection
     */
    public function presentYandexAddressList(Collection $responseCollection): Collection
    {
        return $responseCollection;
    }

    /**
     * @param Collection $responseCollection
     * @return Collection
     */
    public function presentGoogleDistance(Collection $responseCollection): Collection
    {
        return collect([
            'distance' => @$responseCollection['rows'][0]['elements'][0]['distance']['value'],
            'duration' => @$responseCollection['rows'][0]['elements'][0]['duration']['value'],
        ]);
    }
}
