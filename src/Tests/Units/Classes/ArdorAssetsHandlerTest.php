<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorAssetsHandler;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;
use AMBSERIVE\Ardor\Models\ArdorTransaction;

use Carbon\Carbon;

class ArdorAssetsTest extends TestArdorCase
{

    /**
     * Test if a asset can be generated
     */
    public function testArdorAssetsIssuing():void {

        $time = time();

        $ardor = new ArdorAssetsHandler();
        $asset = $ardor
                    ->calculateFee()->issueAsset("${time}", ["test" => true, "time" => $time, 'who' => 'AMBERSIVE KG'], 1, 0, 2);

        $this->assertNotNull($asset);
        $this->assertTrue($asset instanceof \AMBERSIVE\Ardor\Models\ArdorTransaction);

    }

    public function testArdorAssetsIssuingThousand():void {

        $time = time();

        $ardor = new ArdorAssetsHandler();
        $asset = $ardor
                    ->calculateFee()->issueAsset("${time}", ["test" => true, "time" => $time, 'who' => 'AMBERSIVE KG - 1000'], 1000, 0, 2);

        $this->assertNotNull($asset);
        $this->assertTrue($asset instanceof \AMBERSIVE\Ardor\Models\ArdorTransaction);


    }

    /**
     * Test if the get all assets returns a collection for the assets
     */
    public function testArdorAllAssets():void {

        $ardor = new ArdorAssetsHandler();
        $assets = $ardor->getAllAssets();

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assets->count());

    }

    /**
     * Test if the Asset search returns a result
     */
    public function testArdorAssetSearch():void {

        $searchTerm = "test OR asdf";

        $ardor  = new ArdorAssetsHandler();
        $assets = $ardor->searchAssets($searchTerm);
        $result = $assets->assets->first();

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assets->count());
        $this->assertNotFalse(strpos($result->name.'/'.$result->description, "test") || strpos($result->name.'/'.$result->description, "asdf"));

    }

    /**
     * Test if an asset property can be set
     */
    public function testArdorSetAssetProperty():void {

        $propName  = time();
        $propValue = "AMBERSIVE KG";

        $ardor  = new ArdorAssetsHandler();
        $search = $ardor->searchAssets("AMBERSIVE KG");
        $searchResult = $search->assets->first();

        $propertySetResult = $ardor->setAssetProperty($searchResult->asset, $propName, $propValue, 2);

        $this->assertNotNull($propertySetResult);
        $this->assertTrue($propertySetResult instanceof  \AMBERSIVE\Ardor\Models\ArdorTransaction);
        $this->assertEquals($propName, optional($propertySetResult)->transactionJSON->attachment->property);

    }

    public function testArdorTransferAssetToAnotherWalletIsSuccessful():void {

        $ardor  = new ArdorAssetsHandler();

        // Action
        $transfer = $ardor->calculateFee()->transferAsset("5080855141560730776", "ARDOR-NJNX-KRD6-JW7T-GU397", 1, 2);

        // Assert
        $this->assertNotNull($transfer);
        $this->assertTrue($transfer->broadcasted);
        $this->assertNotNull(optional($transfer)->transactionJSON->attachment->asset);
        $this->assertEquals("5080855141560730776", optional($transfer)->transactionJSON->attachment->asset);

    }

}