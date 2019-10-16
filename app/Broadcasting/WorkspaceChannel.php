<?php

namespace App\Broadcasting;


class WorkspaceChannel
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
     * @param $workspaceId
     * @return bool
     */
    public function join($workspaceId)
    {
        info('Joined workspace channel with workspaceId ID:'.$workspaceId);
        return true;
    }
}
