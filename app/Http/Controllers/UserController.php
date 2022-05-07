<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\User\UpdateRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Gender\GenderRepositoryInterface;

class UserController extends Controller
{
    protected $userRepo;
    protected $orderRepo;
    protected $genderRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        OrderRepositoryInterface $orderRepo,
        GenderRepositoryInterface $genderRepo
    ) {
        $this->userRepo = $userRepo;
        $this->orderRepo = $orderRepo;
        $this->genderRepo = $genderRepo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepo->find($id);
        $genders = $this->genderRepo->getAll();

        if (empty($user)) {
            return redirect()
                ->route('home')
                ->with('message', __('messages.result'));
        }

        return view('user.profile.profile.edit', [
            'user' => $user,
            'genders' => $genders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $user = $this->userRepo->find($id);
        if (!$user) {
            abort(Response::HTTP_NOT_FOUND);
        }

        if ($request->avatar != null) {
            $newAvatarName = time() . '-' . str_replace(' ', '-', $request->name) . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('avatars'), $newAvatarName);
        } else {
            $newAvatarName = $user->avatar;
        }

        $user = $this->userRepo->update($id, [
                'name' => $request->input('name'),
                'birthday' => $request->input('birthday'),
                'gender_id' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'avatar' => $newAvatarName,
            ]);

        return redirect()
            ->route('profile.edit', $id)
            ->with('message', __('messages.update'));
    }

    public function viewOrders($id)
    {
        $user = $this->userRepo->find($id);
        $orders = $this->orderRepo->getOrderWithUserId($id);

        return view('user.profile.order.orders')->with(compact('orders'));
    }

    public function viewDetailOrder($id)
    {
        $order = $this->orderRepo->find($id);

        return view('user.profile.order.view_order')->with(compact('order'));
    }

    public function viewStatusOrder($idUser, $isSatus)
    {
        $user = $this->userRepo->find($idUser);
        $orders = $this->orderRepo->getOrderWithUserIdAndStatusOrder($idUser, $isSatus);

        return view('user.profile.order.orders')->with(compact('orders'));
    }
}
