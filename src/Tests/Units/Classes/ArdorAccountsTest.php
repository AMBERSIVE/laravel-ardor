<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorAccounts;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorAccountsTest extends TestArdorCase
{

    public function testGetAccountShouldReturnAccountData():void {

        $response = new ArdorMockResponse(200, ['effectiveBalanceFXT' => 878]);

        $ardor = new ArdorAccounts();

        $account = $ardor->setClient($this->createApiMock([$response]))->getAccount(config('ardor.wallet'), ['includeEffectiveBalance' => "true"]);

        $this->assertNotNull($account);
        $this->assertEquals(878, $account->effectiveBalanceFXT);

    }

}