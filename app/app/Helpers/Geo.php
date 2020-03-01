<?php
namespace App\Helpers;
use App\Components\GMap; 
class Geo {
    public static function random() {
        return (float)rand() / (float)getrandmax();
    }

    /**
     * get random position with lat / lng by radius
     *
     * @param float $lat
     * @param float $lng
     * @param float $radius in metter
     */
    public static function getRandomPosition($lat, $lng, $radius = 1000) {
        $r = $radius / 111300; // = 100 meters
        $y0 = $lat;
        $x0 = $lng;
        $u = self::random();
        $v = self::random();
        $w = $r * sqrt($u);
        $t = 2 * pi() * $v;
        $x = $w * cos($t);
        $y1 = $w * sin($t);
        $x1 = $x / cos($y0);

        return [
            'lat' => $y0 + $y1,
            'lng' => $x0 + $x1
        ];
    }

    /**
     * get random positions with lat / lng by radius
     *
     * @param float $lat
     * @param float $lng
     * @param float $radius in metter
     */
    public static function getRandomPositions($lat, $lng, $radius = 1000, $total = 20) {
        $results = [];
        for ($i = 0; $i < $total; $i++) {
            $results[] = Geo::getRandomPosition((float)$lat, (float)$lng, $radius);
        }

        return GMap::getNearestRoads($results);
    }

    /**
     * get random bearing 0->360
     *
     */
    public static function getRandomBearing() {
        return (float)rand(0, 360);
    }
}