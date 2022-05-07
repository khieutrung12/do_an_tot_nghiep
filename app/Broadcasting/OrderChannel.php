<?php

namespace App\Broadcasting;

use App\Models\User;

class OrderChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    //xác nhận xem user đăng kí channel có đúng với user đang đăng nhập ko
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, User $userLogin)
    {
        return $user->id === $userLogin->id;
    }
}
