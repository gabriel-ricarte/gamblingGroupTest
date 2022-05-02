<?php


namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Helpers\AffiliateHelper;
use Illuminate\Http\UploadedFile;
use App\Models\Affiliate;

class AffiliateHelperTest extends TestCase
{
    private $affiliateHelper;
    protected function setUp(): void
    {
        parent::setUp();
        $this->affiliateHelper = AffiliateHelper::GetInstance();
    }
   
    public function testReadFile()
    {
        $request = new Request();
        $uploadedFile = new UploadedFile(public_path() .'/files/file.txt','file.txt');
        $request->files->set('file', $uploadedFile);
        $expectedAffiliateCount = 31;

        $outcome = $this->affiliateHelper->readFile($request);

        $this->assertIsArray($outcome);
        $this->assertArrayHasKey($expectedAffiliateCount, $outcome);
        $this->assertContainsOnlyInstancesOf(Affiliate::class, $outcome);
    }

    public function testGetNearestAffiliates()
    {
        $affiliates[] = new Affiliate('Inez Blair', 4, "53.2451022", "-6.238335");

        $outcome = $this->affiliateHelper->getNearestAffiliates($affiliates, Affiliate::HUNDRED_QUILOMETERS_IN_MILES);

        $this->assertIsArray($outcome);
        $this->assertArrayHasKey(0, $outcome);
        $affiliate = array_shift($outcome);
        $this->assertNotEmpty($affiliate->getDistanceFromOffice());
        $this->assertContainsOnlyInstancesOf(Affiliate::class, $outcome);
    }

    public function testCalculateDistanceFromDublinOffice()
    {
        $affiliate = new Affiliate('Inez Blair', 4, "53.2451022", "-6.238335");
        $expectedDistance = 6.176332624305746;

        $outcome = $this->affiliateHelper->calculateDistanceFromDublinOffice($affiliate);

        $this->assertEquals($expectedDistance, $outcome);
        $this->assertIsFloat($outcome);
    }

    public function testMiles2kms()
    {
        $miles = 10;
        $expectedKilometers = 16;
        
        $outcome = $this->affiliateHelper->miles2kms($miles);
        $this->assertEquals($expectedKilometers, $outcome);
        $this->assertIsFloat($outcome);
    }
}
