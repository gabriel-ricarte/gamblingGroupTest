<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Helpers\AffiliateHelper;

class AffiliatesController extends Controller
{
    public function index()
    {
        return view('discoverAffiliates');
    }

    public function discover(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:json'
        ], [
            'file.required' => 'File with affiliates is required',
            'file.mimes' => 'File type must be JSON',
        ]);
        $affiliateHelper = AffiliateHelper::GetInstance();
        $affiliates = $affiliateHelper->readFile($request);
        $validAffiliates = $affiliateHelper->getNearestAffiliates($affiliates, Affiliate::HUNDRED_QUILOMETERS_IN_MILES);
        usort($validAffiliates, function($a, $b) {
            return $a->getAffiliateId() <=> $b->getAffiliateId();
        });
        return view('discoverAffiliates')->with('validAffiliates',$validAffiliates);
    }
}
