<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function insert($attributes = []);

    public function saveEmailVerifiedAt(User $user, $email_verified_at);

    public function saveToken(User $user, $token);

    public function getEmailVerified();

    public function sendNotify($id, $event);

    public function findByAttributes($attributes = []);
}
