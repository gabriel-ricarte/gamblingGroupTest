<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\Affiliate;

class AffiliateHelper
{
    private static $instance;

    private function __construct() {
    }
    
    public static function GetInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    public function readFile(Request $request): array
    {
        $content = file_get_contents($request->file('file')->getPathName());
        $contentRows =  preg_split('/\r\n|\r|\n/',$content);
        $affiliates = [];
        foreach ($contentRows as $affiliate) {
            $affiliate = json_decode($affiliate);
            $affiliates[] = new Affiliate($affiliate->name, $affiliate->affiliate_id, $affiliate->latitude, $affiliate->longitude);
        }
        return $affiliates;
    }

    public function getNearestAffiliates($affiliates = [], $miles):array
    {   
        foreach ($affiliates as $key => $affiliate) {
           $distance = $this->calculateDistanceFromDublinOffice($affiliate);
           if ($distance > $miles) {
             unset($affiliates[$key]);  
           } else {
             $affiliate->setDistanceFromOffice($this->miles2kms($distance));
           }
        }
        return array_values($affiliates);
    }

    public function calculateDistanceFromDublinOffice(Affiliate $affiliate) 
    {
        $rLatDublin = Affiliate::DUBLIN_OFFICE['latitude'] * (pi()/180); // Convert degrees to radians
        $rlatAffiliate = $affiliate->getLatitude() * (pi()/180); // Convert degrees to radians
        $difflat = $rlatAffiliate-$rLatDublin; // Radian difference (latitudes)
        $difflon = ($affiliate->getLongitude()-Affiliate::DUBLIN_OFFICE['longitude']) * (pi()/180); // Radian difference (longitudes)
  
        $distance = 2 * Affiliate::EARTH_RADIUS * asin(sqrt( (sin($difflat/2) * sin($difflat/2)) + (cos($rLatDublin)*cos($rlatAffiliate)*sin($difflon/2)*sin($difflon/2))));
        return $distance;
    }

    public function miles2kms($miles) {
        $ratio = 1.609344;
        $kms = $miles * $ratio;
        return round($kms);
    }
}
