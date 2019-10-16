<?php

namespace App\Broadcasting;


class WorkspaceUserChannel
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
     * @param User $user
     * @param $workspaceId
     * @param $userId
     * @return bool
     */
    public function join($workspaceId, $userId)
    {
        return true;
        return info('Joined user channel in workspaceId ID:'.$workspaceId." - user ID".$userId);

    }
}
