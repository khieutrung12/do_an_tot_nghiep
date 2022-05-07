<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function insert($attributes = [])
    {
        return $this->model->insert($attributes);
    }

    public function saveEmailVerifiedAt(User $user, $email_verified_at)
    {
        $user->email_verified_at = $email_verified_at;
        return $user->save();
    }

    public function saveToken(User $user, $token)
    {
        $user->token = $token;
        return $user->save();
    }

    public function getEmailVerified()
    {
        return $this->model->select('email')
            ->whereNotNull('email_verified_at')
            ->get();
    }
    
    public function sendNotify($id, $event)
    {
        $user = $this->find($id);
        if ($user) {
            $user->notify($event);

            return true;
        }

        return false;
    }

    public function findByAttributes($attributes = [])
    {
        return $this->model->where($attributes)->get();
    }
}
