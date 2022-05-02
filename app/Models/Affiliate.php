<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{    
    const EARTH_RADIUS = 3958.8;
    const DUBLIN_OFFICE = ['latitude' => 53.3340285, 'longitude' => -6.2535495];
    const HUNDRED_QUILOMETERS_IN_MILES = 62.1371;
    private $latitude;
    private $longitude;
    private $affiliate_id;
    private $name;
    private $distanceFromOffice;

    public function __construct($name, $affiliate_id, $latitude, $longitude) {
        $this->name = $name;
        $this->affiliate_id = $affiliate_id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAffiliateId()
    {
        return $this->affiliate_id;
    }

    public function getDistanceFromOffice()
    {
        return $this->distanceFromOffice;
    }

    public function setDistanceFromOffice($distanceFromOffice)
    {
        $this->distanceFromOffice = $distanceFromOffice;
    }
}
