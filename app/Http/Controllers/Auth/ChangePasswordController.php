<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;

class ChangePasswordController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function edit($id)
    {
        $user = $this->userRepo->find($id);

        if (empty($user)) {
            return redirect()
                ->route('home')
                ->with('message', __('messages.result'));
        }

        return view('user.profile.profile.change_password', [
            'user' => $user,
        ]);
    }

    public function change(ChangePasswordRequest $request, $id)
    {
        $compare = auth()->attempt([
            'email' => auth()->user()->email,
            'password' => $request->input('current_password'),
        ]);

        if ($compare) {
            if (!Hash::check($request->input('new_password'), auth()->user()->password)) {
                $user = $this->userRepo->update($id, [
                    'password' => Hash::make($request->input('new_password')),
                ]);
                $message = __('messages.update');
            } else {
                $message = __('messages.old-password');
            }
        } else {
            $message = __('messages.password-fail');
        }

        return redirect()
            ->route('password.edit', $id)
            ->with('message', $message);
    }
}
