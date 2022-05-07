<?php

namespace Tests\Unit\Http\Controllers;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VoucherController;
use App\Http\Requests\Voucher\StoreRequest;
use App\Http\Requests\Voucher\UpdateRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;

class VoucherControllerTest extends TestCase
{
    protected $order;
    protected $voucher;
    protected $orderRepo;
    protected $voucherRepo;
    protected $voucherController;

    public function setUp(): void
    {
        parent::setUp();

        $this->voucherRepo = m::mock(VoucherRepositoryInterface::class)->makePartial();
        $this->orderRepo = m::mock(OrderRepositoryInterface::class)->makePartial();
        $this->voucherController = new VoucherController($this->voucherRepo, $this->orderRepo);
    }

    public function tearDown(): void
    {
        m::close();

        unset($this->orderRepo);
        unset($this->voucherRepo);
        unset($this->voucherController);
        parent::tearDown();
    }

    public function testIndexVoucher()
    {
        $this->voucherRepo->shouldReceive('getAll');
        $view = $this->voucherController->index();

        $this->assertEquals('admin.voucher.index', $view->getName());
        $this->assertArrayHasKey('vouchers', $view->getData());
    }

    public function testFetchVoucher()
    {
        $noRecords = 2;
        $vouchers = Voucher::factory()->count($noRecords)->make();
        $this->voucherRepo->shouldReceive('getAll')->andReturn($vouchers);
        $response = $this->voucherController->fetch();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($noRecords, $response->original["recordsTotal"]);
    }

    public function testStoreVoucherSuccess()
    {
        $voucher = Voucher::factory()->make();
        $data = [
            'code' => $voucher->code,
            'name' => $voucher->name,
            'quantity' => $voucher->quantity,
            'value' => $voucher->value,
            'condition_min_price' => $voucher->condition_min_price,
            'maximum_reduction' => $voucher->maximum_reduction,
            'start_date' => $voucher->start_date,
            'end_date' => $voucher->end_date,
        ];

        $request = new StoreRequest($data);
        $this->voucherRepo->shouldReceive('insertVoucher')
            ->andReturn(true);
        $resClient = [
            'code' => 200,
            'message' => 'messages.add-success',
        ];
        
        $response = $this->voucherController->store($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testStoreVoucherFail()
    {
        $data = [
            'code' => '',
            'name' => '',
            'quantity' => '',
            'value' => '',
            'condition_min_price' => '',
            'maximum_reduction' => '',
            'start_date' => '',
            'end_date' => '',
        ];

        $request = new StoreRequest($data);
        $this->voucherRepo->shouldReceive('insertVoucher')
            ->andReturn(false);
        $resClient = [
            'message' => 'messages.something-wrong',
        ];
        
        $response = $this->voucherController->store($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testEditVoucherSuccess()
    {
        $voucher = Voucher::factory()->make();

        $request = new Request((array) $voucher->id);

        $this->voucherRepo->shouldReceive('find')
            ->andReturn(true);
        $resClient = [
            'code' => 200,
            'voucher' => $voucher,
        ];
        $response = $this->voucherController->edit($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testEditVoucherFail()
    {
        $voucher = Voucher::factory()->make();
        $request = new Request((array) ($voucher->id + 1));

        $this->voucherRepo->shouldReceive('find')
            ->andReturn(false);
        $resClient = [
            'message' => 'messages.No Results Found',
        ];
        $response = $this->voucherController->edit($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testUpdateVoucherIdDoesNotExist()
    {
        $voucher = Voucher::factory()->make();
        $input = [
            'cid' => $voucher->id + 1,
            'code' => $voucher->code,
            'name' => $voucher->name,
            'quantity' => $voucher->quantity,
            'value' => $voucher->value,
            'condition_min_price' => $voucher->condition_min_price,
            'maximum_reduction' => $voucher->maximum_reduction,
            'start_date' => $voucher->start_date,
            'end_date' => $voucher->end_date,
        ];
        $this->voucherRepo->shouldReceive('find')
            ->andReturn(false);
        
        $request = new UpdateRequest($input);
        $resClient = [
            'message' => 'messages.No Results Found',
        ];
        $response = $this->voucherController->update($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testUpdateVoucherSuccessWithNewCode()
    {
        $voucher = Voucher::factory()->make();
        $input = [
            'cid' => $voucher->id,
            'code' => $voucher->code,
            'name' => 'New ' . $voucher->name,
            'quantity' => $voucher->quantity,
            'value' => $voucher->value,
            'condition_min_price' => $voucher->condition_min_price,
            'maximum_reduction' => $voucher->maximum_reduction,
            'start_date' => $voucher->start_date,
            'end_date' => $voucher->end_date,
        ];
        $this->voucherRepo->shouldReceive('find')
            ->andReturn($voucher);
        
        $newVoucher = $voucher;
        $newVoucher->code = $input['code'];
        $this->voucherRepo->shouldReceive('update')
            ->andReturn($newVoucher);

        $resClient = [
            'code' => 200,
            'message' => 'messages.update-success',
        ];
        $request = new UpdateRequest($input);

        $response = $this->voucherController->update($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testUpdateVoucherSuccessWithOldCode()
    {
        $voucher = Voucher::factory()->make();
        $input = [
            'cid' => $voucher->id,
            'code' => $voucher->code,
            'name' => $voucher->name,
            'quantity' => $voucher->quantity,
            'value' => $voucher->value,
            'condition_min_price' => $voucher->condition_min_price,
            'maximum_reduction' => $voucher->maximum_reduction,
            'start_date' => $voucher->start_date,
            'end_date' => $voucher->end_date,
        ];
        $this->voucherRepo->shouldReceive('find')
            ->andReturn($voucher);
        
        $this->voucherRepo->shouldReceive('update')
            ->andReturn($voucher);

        $resClient = [
            'code' => 200,
            'message' => 'messages.update-success',
        ];
        $request = new UpdateRequest($input);

        $response = $this->voucherController->update($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testUpdateVoucherFail()
    {
        $voucher = Voucher::factory()->make();
        $input = [
            'cid' => '',
            'code' => '',
            'name' => '',
            'quantity' => '',
            'value' => '',
            'condition_min_price' => '',
            'maximum_reduction' => '',
            'start_date' => '',
            'end_date' => '',
        ];
        $this->voucherRepo->shouldReceive('find')
            ->andReturn($voucher);
        
        $this->voucherRepo->shouldReceive('update')
            ->andReturn(false);

        $resClient = [
            'message' => 'messages.something-wrong',
        ];
        $request = new UpdateRequest($input);

        $response = $this->voucherController->update($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testDeleteVoucherBelongsToOrder()
    {
        $voucher = Voucher::factory()->make();
        $order = Order::factory()->make();
        $order->voucher_id = $voucher->id;

        $this->orderRepo->shouldReceive('findByVoucherId')
            ->andReturn($order);
        
        $resClient = [
            'code' => 403,
            'message' => 'messages.cant-delete',
        ];
        $request = new Request((array) $voucher->id);

        $response = $this->voucherController->delete($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testDeleteVoucherSuccess()
    {
        $voucher = Voucher::factory()->make();

        $this->orderRepo->shouldReceive('findByVoucherId')
            ->andReturn(null);
        $this->voucherRepo->shouldReceive('delete')
            ->andReturn(true);
        
        $resClient = [
            'code' => 200,
            'message' => 'messages.delete-success',
        ];
        $request = new Request((array) $voucher->id);

        $response = $this->voucherController->delete($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testDeleteVoucherFail()
    {
        $voucher = Voucher::factory()->make();

        $this->orderRepo->shouldReceive('findByVoucherId')
            ->andReturn(null);
        $this->voucherRepo->shouldReceive('delete')
            ->andReturn(false);
        
        $resClient = [
            'message' => 'messages.something-wrong',
        ];
        $request = new Request((array) $voucher->id);

        $response = $this->voucherController->delete($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testDeleteListVoucherSuccess()
    {
        $voucher_01 = Voucher::factory()->make();
        $voucher_02 = Voucher::factory()->make();
        $voucher_02->id = $voucher_01->id + 1;

        $input = [
            'voucher_id' => [
                $voucher_01->id,
                $voucher_02->id,
            ],
        ];

        $this->orderRepo->shouldReceive('findByVoucherId')
            ->andReturn(null);
        $this->voucherRepo->shouldReceive('deleteListVoucher')
            ->andReturn(true);

        $resClient = [
            'code' => 200,
            'message' => 'messages.delete-success',
        ];
        $request = new Request($input);
        $response = $this->voucherController->deleteList($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testDeleteListVoucherCantDelete()
    {
        $voucher_01 = Voucher::factory()->make();
        $voucher_02 = Voucher::factory()->make();
        $voucher_02->id = $voucher_01->id + 1;

        $input = [
            'voucher_id' => [
                $voucher_01->id,
                $voucher_02->id,
            ],
        ];

        $order_01 = Order::factory()->make();
        $order_02 = Order::factory()->make();
        $order_01->voucher_id = $voucher_01->id;
        $order_02->voucher_id = $voucher_02->id;

        $this->orderRepo->shouldReceive('findByVoucherId')
            ->andReturn([$order_01, $order_02]);

        $resClient = [
            'code' => 403,
            'message' => 'messages.cant-delete',
        ];
        $request = new Request($input);
        $response = $this->voucherController->deleteList($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testDeleteListVoucherFail()
    {
        $voucher_01 = Voucher::factory()->make();
        $voucher_02 = Voucher::factory()->make();
        $voucher_02->id = $voucher_01->id + 1;

        $input = [
            'voucher_id' => [
                $voucher_01->id,
                $voucher_02->id,
            ],
        ];

        $this->orderRepo->shouldReceive('findByVoucherId')
            ->andReturn(null);
        $this->voucherRepo->shouldReceive('deleteListVoucher')
            ->andReturn(false);

        $resClient = [
            'message' => 'messages.something-wrong',
        ];
        $request = new Request($input);
        $response = $this->voucherController->deleteList($request);
        $this->assertJson(json_encode($resClient), json_encode($response->getData()));
    }

    public function testWalletVoucherWithUserHaveNotUsedVoucher()
    {
        $user = User::factory()->make();
        $vouchers = Voucher::factory()->count(2)->make();
        
        Auth::shouldReceive('user')->once()->andReturn($user);
        $this->orderRepo->shouldReceive('getVoucherIdByUserId')->andReturn(null);
        $this->voucherRepo->shouldReceive('findByCondition')->andReturn($vouchers);
        $view = $this->voucherController->walletVoucher();

        $this->assertEquals('user.profile.voucher.index', $view->getName());
        $this->assertArrayHasKey('vouchers', $view->getData());
    }

    public function testWalletVoucherWithUserUsedVoucher()
    {
        $user = User::factory()->make();
        $vouchers = Voucher::factory()->count(2)->make();
        $orders = Order::factory()->count(2)->make();

        Auth::shouldReceive('user')->once()->andReturn($user);
        $this->orderRepo->shouldReceive('getVoucherIdByUserId')->andReturn($orders);
        $this->voucherRepo->shouldReceive('findByCondition')->andReturn($vouchers);
        $view = $this->voucherController->walletVoucher();

        $this->assertEquals('user.profile.voucher.index', $view->getName());
        $this->assertArrayHasKey('vouchers', $view->getData());
    }

    public function testUseVoucherDoesNotExistSessionCode()
    {
        $voucher = Voucher::factory()->make();
        $response = $this->voucherController->useVoucher((array) $voucher->code);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('shop'), $response->headers->get('Location'));
    }

    public function testUseVoucherExistSessionCode()
    {
        $voucher = Voucher::factory()->make();
        session()->put('code', 'CODETEST');

        $response = $this->voucherController->useVoucher((array) $voucher->code);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('shop'), $response->headers->get('Location'));
    }

    public function testShowVoucher()
    {
        $voucher = Voucher::factory()->make();
        $this->voucherRepo->shouldReceive('findByCode')
            ->andReturn($voucher);
        $request = new Request((array)$voucher->code);
        $view = $this->voucherController->showVoucher($request);

        $this->assertEquals('user.profile.voucher.show', $view->getName());
        $this->assertArrayHasKey('voucher', $view->getData());
    }
}
