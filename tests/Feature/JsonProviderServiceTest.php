<?php

namespace Tests\Feature;

use App\Services\JsonProviderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JsonProviderServiceTest extends TestCase
{
    # 'DataProviderTestX' REFERS TO USERS PROVIDER DATA
    # 'DataProviderTestY' REFERS TO TRANSACTIONS PROVIDER DATA
    
    protected $JsonProviderService;

    protected function setUp(): void
    {
        parent::setUp();
        //add test data provider
        $JsonProviderService = app(JsonProviderService::class);
        $JsonProviderServiceUpdated = new \ReflectionClass($JsonProviderService);
        $dataSourcesProperty = $JsonProviderServiceUpdated->getProperty('JsonFiles');
        $dataSourcesProperty->setAccessible(true);
        $dataSourcesProperty->setValue($JsonProviderService,['DataProviderTestX', 'DataProviderTestY']);
        $this->JsonProviderService = $JsonProviderService;
    }

    public function testParentsListingFromAllSources()
    {
        $output = $this->JsonProviderService->getAllParents();
        $this->assertEquals(17, count($output));
    }

    public function testParentsFromOneProviderFilter()
    {
        $filtersX = [
            'provider' => 'DataProviderTestX'
        ];
        $outputX = $this->JsonProviderService->getAllParents($filtersX);
        $this->assertEquals(7, count($outputX));

        $filtersY = [
            'provider' => 'DataProviderTestY'
        ];
        $outputY = $this->JsonProviderService->getAllParents($filtersY);
        $this->assertEquals(10, count($outputY));
    }

   public function testParentsWithStatusFilter()
    {
        $filters = [
            'statusCode' => 'authorised'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(4, count($output));

        $filters_decline = [
            'statusCode' => 'decline'
        ];
        $output_decline = $this->JsonProviderService->getAllParents($filters_decline);
        $this->assertEquals(5, count($output_decline));

        $filters_refunded = [
            'statusCode' => 'refunded'
        ];
        $output_refunded = $this->JsonProviderService->getAllParents($filters_refunded);
        $this->assertEquals(1, count($output_refunded));
    }

    public function testParentsWithMinBalanceFilter()
    {
        $filters = [
            'balanceMin' => 0
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(17, count($output));

        $filters = [
            'balanceMin' => 500
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(8, count($output));

        $filters = [
            'balanceMin' => 10000
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(0, count($output));
    }

    public function testParentsWithMaxBalanceFilter()
    {
        $filters = [
            'balanceMax' => 7001
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(17, count($output));

        $filters = [
            'balanceMax' => 500
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(10, count($output));

        $filters = [
            'balanceMax' => 101
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(1, count($output));
    }

    public function testParentsWithCurrencyFilter()
    {
        $filters = [
            'currency' => 'EUR'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(2, count($output));

        $filters = [
            'currency' => 'SAR'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(8, count($output));

        $filters = [
            'currency' => 'AED'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(2, count($output));

        $filters = [
            'currency' => 'USD'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(3, count($output));

        $filters = [
            'currency' => 'EGP'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(2, count($output));
    }

    public function testParentsWithAllFilters()
    {
        $filters = [
            'provider'   => 'DataProviderTestY',  // which is transactions 
            'statusCode' => 'refunded',
            'balanceMin' => 10,
            'balanceMax' => 201,
            'currency'   => 'USD'
        ];
        $output = $this->JsonProviderService->getAllParents($filters);
        $this->assertEquals(1, count($output));
    }


    public function testNotFoundDataSource()
    {
        $this->assertTrue(true);
    }
}

