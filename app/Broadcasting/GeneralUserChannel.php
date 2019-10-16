<?php

namespace App\Broadcasting;

use App\Models\User;
use Auth;

class GeneralUserChannel
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

    /**
     * Authenticate the user's access to the channel.
     *
     * @param \App\Models\User $user
     * @return array|bool
     */
    public function join()
    {
        info('Joined general channel');
        return true;
    }
}
