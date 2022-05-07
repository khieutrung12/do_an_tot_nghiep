<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerifyMail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\UpdateRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Gender\GenderRepositoryInterface;
use DateTime;

class AdminController extends Controller
{
    protected $genderRepo;
    protected $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        GenderRepositoryInterface $genderRepo
    ) {
        $this->userRepo = $userRepo;
        $this->genderRepo = $genderRepo;
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        $genders = $this->genderRepo->getAll();
        $user = Auth()->user();

        return view('admin.profile.index', [
            'genders' => $genders,
            'user' => $user,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = $this->userRepo->find($id);
        if (!$user) {
            abort(Response::HTTP_NOT_FOUND);
        }

        if ($request->avatar != null) {
            $newAvatarName = time() . '-' . str_replace(' ', '-', $request->name) . '.'
                . $request->avatar->extension();
            $request->avatar->move(public_path('avatars'), $newAvatarName);
        } else {
            $newAvatarName = $user->avatar;
        }

        $user = $this->userRepo->update($id, [
            'name' => $request->input('name'),
            'birthday' => $request->input('birthday'),
            'gender_id' => $request->input('gender'),
            'avatar' => $newAvatarName,
        ]);

        return redirect()
            ->route('admin.profile')
            ->with('message', __('messages.update'));
    }

    public function verifyEmail()
    {
        $user = Auth()->user();

        return view('admin.profile.verify_email', [
            'user' => $user,
        ]);
    }

    public function sendVerifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $user = Auth()->user();

        if ($request->email != $user->email) {
            return redirect()->route('admin.verify.email')
                    ->withErrors(['email' => __('messages.email-not-match')])
                    ->withInput();
        }

        $token = strtoupper(Str::random(10));
        $this->userRepo->saveToken($user, $token);

        Mail::to($user->email)->send(new VerifyMail());

        return redirect()->route('admin.profile')
            ->with('message_verify', __('messages.check-your-email'));
    }

    public function activeEmail($id, $token)
    {
        $user = $this->userRepo->find($id);
        if (!$user) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $email_verified_at = new DateTime();
        
        $this->userRepo->saveEmailVerifiedAt($user, $email_verified_at);
        $this->userRepo->saveToken($user, null);

        return redirect()->route('admin.profile');
    }
}
