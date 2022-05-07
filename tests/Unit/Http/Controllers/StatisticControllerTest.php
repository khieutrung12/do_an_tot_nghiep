<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\StatisticController;
use App\Repositories\Order\OrderRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StatisticControllerTest extends TestCase
{
    protected $controller;
    protected $orderRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepo = Mockery::mock($this->app->make(OrderRepositoryInterface::class))->makePartial();
        $this->controller = new StatisticController(
            $this->orderRepo
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->controller);
        unset($this->orderRepo);
        parent::tearDown();
    }

    public function testIndexStatisticByOrder()
    {
        $response = $this->controller->statisticByOrder();
        $this->assertEquals('admin.statistic.statistic_order', $response->getName());
    }

    public function testIndexStatisticByRevenue()
    {
        $view = $this->controller->statisticByRevenue();
        $this->assertEquals('admin.statistic.statistic_revenue', $view->getName());
    }

    public function testSelectYearRevenueSuccess()
    {
        $get = [];
        $get = ['year' => '2022'];
        $request = new Request($get);
        $data = [
            '1' => '119000',
            '3' => '112000',
        ];
        $value = [
            'month' => 'January,February,March',
            'revenue' => '119000,0,112000'
        ];
        $this->orderRepo->shouldReceive('countOrderByYear')->andReturn(true);
        $this->orderRepo->shouldReceive('getRevenueMonth')->andReturn($data);
        $response = $this->controller->selectYearRevenue($request);
        $this->assertJson(json_encode($value), json_encode($response->getData()));
    }

    public function testSelectYearRevenueFail()
    {
        $get = [];
        $get['year'] = '2021';
        $request = new Request($get);
        $value = [
            'message' => 'messages.no_data',
        ];
        $this->orderRepo->shouldReceive('countOrderByYear')->andReturn(false);
        $response = $this->controller->selectYearRevenue($request);
        $this->assertJson(json_encode($value), json_encode($response->getData()));
    }

    public function testSelectMonthOrderSuccess()
    {
        $get = [];
        $get = [
            'year' => '2021',
            'month' => '01',
        ];
        $data = [
            0 => 21,
        ];
        $value = [
            'totalOrder' => '0,0,10,0',
            'message' => 'messages.load_data_success',
        ];
        $request = new Request($get);
        $this->orderRepo->shouldReceive('getTotalOrdersWeekForMonth')->andReturn($data);
        $response = $this->controller->selectMonthOrder($request);
        $this->assertJson(json_encode($value), json_encode($response->getData()));
    }

    public function testSelectMonthOrderFail()
    {
        $get = [];
        $get = [
            'year' => '2021',
            'month' => '01',
        ];
        $data = [];
        $value = [
            'totalOrder' => '0,0,0,0',
            'message' => 'messages.no_data',
        ];
        $request = new Request($get);
        $this->orderRepo->shouldReceive('getTotalOrdersWeekForMonth')->andReturn($data);
        $response = $this->controller->selectMonthOrder($request);
        $this->assertJson(json_encode($value), json_encode($response->getData()));
    }

    public function testSelectMonthOrderFailNoData()
    {
        $get = [];
        $get = [
            'year' => '',
            'month' => '',
        ];
        $value = [
            'message' => 'messages.no_data',
        ];
        $request = new Request($get);
        $response = $this->controller->selectMonthOrder($request);
        $this->assertJson(json_encode($value), json_encode($response->getData()));
    }
}
