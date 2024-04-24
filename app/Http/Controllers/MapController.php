<?php

namespace App\Http\Controllers;

use App\Classes\MapContext;
use App\Services\GoogleMapService;
use App\Services\YandexMapService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MapController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addressAutocomplete(Request $request): JsonResponse
    {
        if (!$request->search) {
            return response()->json(['predictions' => []]);
        }

        $mapContext = new MapContext(new YandexMapService());

        return response()->json(['predictions' => $mapContext->executeHttpRequest('addressList', $request->search)]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addressDistance(Request $request): JsonResponse
    {
        if (!$request->yCords) {
            return response()->json(['distanceObj' => []]);
        }

        $gCords = implode(',', array_reverse(explode(' ', $request->yCords)));
        $mapContext = new MapContext(new GoogleMapService());

        return response()->json(['distanceObj' => $mapContext->executeHttpRequest('distance', $gCords)]);
    }
}
