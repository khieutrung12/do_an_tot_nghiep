<?php

namespace Tests\Unit\Http\Controllers;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Gender\GenderRepositoryInterface;

class UserControllerTest extends Testcase
{
    protected $userRepo;
    protected $orderRepo;
    protected $genderRepo;
    protected $userController;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepo = m::mock(UserRepositoryInterface::class)->makePartial();
        $this->orderRepo = m::mock(OrderRepositoryInterface::class)->makePartial();
        $this->genderRepo = m::mock(GenderRepositoryInterface::class)->makePartial();
        $this->userController = new UserController($this->userRepo, $this->orderRepo, $this->genderRepo);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->userRepo);
        unset($this->orderRepo);
        unset($this->genderRepo);
        unset($this->userController);
        parent::tearDown();
    }

    public function testEditUserSuccess()
    {
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('find')
            ->andReturn($user);
        $this->genderRepo->shouldReceive('getAll');
        
        $view = $this->userController->edit($user->id);
        $this->assertEquals('user.profile.profile.edit', $view->getName());
        $this->assertArrayHasKey('genders', $view->getData());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function testEditUserFail()
    {
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('find')
            ->andReturn(false);
        $this->genderRepo->shouldReceive('getAll');

        $response = $this->userController->edit($user->id);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('home'), $response->headers->get('Location'));
    }

    public function testViewOrdersSuccess()
    {
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('find')
            ->andReturn($user);
        $orders = $this->orderRepo->shouldReceive('getOrderWithUserId');
        $view = $this->userController->viewOrders($user->id);
        $this->assertEquals('user.profile.order.orders', $view->getName());
        $this->assertArrayHasKey('orders', $view->getData());
    }

    public function testViewDetailOrderSuccess()
    {
        $order = Order::factory()->make();
        $this->orderRepo->shouldReceive('find')
            ->andReturn($order);
        $view = $this->userController->viewDetailOrder($order->id);
        $this->assertEquals('user.profile.order.view_order', $view->getName());
        $this->assertArrayHasKey('order', $view->getData());
    }

    public function testViewStatusOrderSuccess()
    {
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('find')
            ->andReturn($user);
        $order = Order::factory()->make();
        $this->orderRepo->shouldReceive('getOrderWithUserIdAndStatusOrder');
        $view = $this->userController->viewStatusOrder($user->id, $order->id);
        $this->assertEquals('user.profile.order.orders', $view->getName());
        $this->assertArrayHasKey('orders', $view->getData());
    }

    public function testUpdateUserWithIdNotExist()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $user = User::factory()->make();
            $this->userRepo->shouldReceive('find')
                ->andReturn(false);
            $input = [
                'name' => $user->name,
                'birthday' => $user->birthday,
                'gender_id' => $user->gender_id,
                'phone' => $user->phone,
                'avatar' => $user->avatar,
            ];
            $request = new UpdateRequest($input);
            $this->userController->update($request, $user->id);
        });
    }

    public function testUpdateUserWithAvatarNull()
    {
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('find')
            ->andReturn($user);
        $input = [
            'name' => $user->name,
            'birthday' => $user->birthday,
            'gender_id' => $user->gender_id,
            'phone' => $user->phone,
            'avatar' => null,
        ];
        $this->userRepo->shouldReceive('update')
            ->andReturn($user);
        $request = new UpdateRequest($input);
        $response = $this->userController->update($request, $user->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('profile.edit', $user->id), $response->headers->get('Location'));
        $this->assertArrayHasKey('message', session()->all());
    }

    public function testUpdateUserWithAvatarNotNull()
    {
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('find')
            ->andReturn($user);
        $input = [
            'name' => $user->name,
            'birthday' => $user->birthday,
            'gender_id' => $user->gender_id,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
        ];
        $this->userRepo->shouldReceive('update')
            ->andReturn($user);
        $request = new UpdateRequest($input);
        $response = $this->userController->update($request, $user->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('profile.edit', $user->id), $response->headers->get('Location'));
        $this->assertArrayHasKey('message', session()->all());
    }
}
