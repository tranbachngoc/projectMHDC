<?php

namespace App\Components;

use Geocoder\Provider\GoogleMaps;
use Ivory\HttpAdapter\HttpAdapterInterface;

/**
 * ProviderGoogleMap Provider for the app
 */
class GMap extends GoogleMaps {

    /**
     * @var string
     */
    private $region;

    /**
     * @var bool
     */
    private $useSsl;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(HttpAdapterInterface $adapter, $locale = null, $region = null, $useSsl = true, $apiKey = null) {

        $this->locale = $locale ? $locale : env('GOOGLE_MAP_LOCALE');
        $this->region = $region ? $region : env('GOOGLE_MAP_REGION');
        $this->useSsl = $useSsl ? $useSsl : env('GOOGLE_MAP_USESSL');
        $this->apiKey = $apiKey ? $region : env('GOOGLE_MAP_KEY');
        parent::__construct($adapter, $this->locale, $this->region, $this->useSsl, $this->apiKey);
    }

    /**
     * get distance between 2 points
     *
     * @param float $lat1
     * @param float $long1
     * @param float $lat2
     * @param float $long2
     * @return array
     */
    public static function getDrivingDistance($lat1, $long1, $lat2, $long2) {
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $lat1 . ',' . $long1 . '&destinations=' . $lat2 . ',' . $long2 . '&mode=driving&language=vi-VN&key=' . env('GOOGLE_MAP_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);

        if (empty($response_a['rows'])) {
            return false;
        }

        return [
            'distance' => [
                'text' => $response_a['rows'][0]['elements'][0]['distance']['text'],
                'value' => $response_a['rows'][0]['elements'][0]['distance']['value'] / 1000
            ],
            'duration' => [
                'text' => $response_a['rows'][0]['elements'][0]['duration']['text'],
                'value' => $response_a['rows'][0]['elements'][0]['duration']['value'] //in seconds
            ]
        ];
    }

    /**
     * get address object from lat/lon in google maps
     *
     * @param float $lat
     * @param float $lng
     */
    public static function getGeocodeFromLatLng($lat, $lng, $getAll = false) {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . join(',', [$lat, $lng]) . '&sensor=true&language=vi-VN&key=' . env('GOOGLE_MAP_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);

        if (empty($response_a['results'])) {
            return false;
        }

        return !$getAll ? $response_a['results'][0] : $response_a['results'];
    }
    /**
     * Nearest Roads
     * @param array points
     */
    public static function getNearestRoads($points) {
        //https://roads.googleapis.com/v1/nearestRoads?points=10.793625,106.698023&key=
        $pointsStr = '';
        foreach ($points as $key => $value) {
            $pointsStr.= join(',', [$value['lat'], $value['lng']]). ($key + 1 !== sizeOf($points) ? '|' : '');
        }

        $url = 'https://roads.googleapis.com/v1/nearestRoads?points=' . $pointsStr . '&key=' . env('GOOGLE_MAP_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);

        if (empty($response_a['snappedPoints'])) {
            return false;
        }

        $ids = [];
        $results = [];
        foreach ($response_a['snappedPoints'] as $value) {
            if (!in_array($value['originalIndex'], $ids)) {
                $ids[] = $value['originalIndex'];
                $results[] = [
                    'lat' => $value['location']['latitude'],
                    'lng' => $value['location']['longitude']
                ];
            }
        }

        return $results;
    }
}
