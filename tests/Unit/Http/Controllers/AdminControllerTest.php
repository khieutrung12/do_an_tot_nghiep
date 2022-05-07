<?php

namespace Tests\Unit\Http\Controllers;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\UpdateRequest;
use App\Http\Controllers\AdminController;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Gender\GenderRepositoryInterface;

class AdminControllerTest extends Testcase
{
    protected $userRepo;
    protected $genderRepo;
    protected $adminController;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepo = m::mock(UserRepositoryInterface::class)->makePartial();
        $this->genderRepo = m::mock(GenderRepositoryInterface::class)->makePartial();
        $this->adminController = new AdminController($this->userRepo, $this->genderRepo);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->userRepo);
        unset($this->genderRepo);
        unset($this->adminController);
        parent::tearDown();
    }

    public function testIndexAdmin()
    {
        $view = $this->adminController->index();

        $this->assertEquals('admin.dashboard', $view->getName());
    }

    public function testProfileAdmin()
    {
        $genders = $this->genderRepo->shouldReceive('getAll');
        $user = User::factory()->make();
        Auth::shouldReceive('user')->once()->andReturn($user);

        $view = $this->adminController->profile();
        $this->assertEquals('admin.profile.index', $view->getName());
        $this->assertArrayHasKey('genders', $view->getData());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function testVerifyEmailAdmin()
    {
        $user = User::factory()->make();
        Auth::shouldReceive('user')->once()->andReturn($user);

        $view = $this->adminController->verifyEmail();
        $this->assertEquals('admin.profile.verify_email', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function testSendVerifyEmailAdminFail()
    {
        $user = User::factory()->make();
        $input = [
            'email' => 'testemail123@gmail.com',
        ];

        Auth::shouldReceive('user')->once()->andReturn($user);
        $request = new Request($input);
        $response = $this->adminController->sendVerifyEmail($request);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.verify.email'), $response->headers->get('Location'));
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
            $this->adminController->update($request, $user->id);
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
        $response = $this->adminController->update($request, $user->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.profile'), $response->headers->get('Location'));
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
        $response = $this->adminController->update($request, $user->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.profile'), $response->headers->get('Location'));
        $this->assertArrayHasKey('message', session()->all());
    }

    public function testSendVerifyEmailSuccess()
    {
        $user = User::factory()->make();
        $input = [
            'email' => $user->email,
        ];

        Auth::shouldReceive('user')->once()->andReturn($user);
        $request = new Request($input);
        $this->userRepo->shouldReceive('saveToken');
        Mail::fake();
        $response = $this->adminController->sendVerifyEmail($request);
       
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.profile'), $response->headers->get('Location'));
        $this->assertArrayHasKey('message_verify', session()->all());
    }

    public function testActiveEmailAdminSuccess()
    {
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('find')
            ->andReturn($user);
        $this->userRepo->shouldReceive('saveEmailVerifiedAt');
        $this->userRepo->shouldReceive('saveToken');
        $response = $this->adminController->activeEmail($user->id, $user->token);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.profile'), $response->headers->get('Location'));
    }

    public function testActiveEmailAdminFail()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $user = User::factory()->make();
            $this->userRepo->shouldReceive('find')
                ->andReturn(false);
            $this->adminController->activeEmail($user->id, $user->token);
        });
    }
}
