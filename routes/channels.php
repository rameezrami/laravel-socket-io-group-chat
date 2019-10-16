<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Broadcasting\GeneralUserChannel;
use App\Broadcasting\WorkspaceChannel;
use App\Broadcasting\WorkspaceUserChannel;

Broadcast::channel('general-channel', GeneralUserChannel::class);

Broadcast::channel('workspace-{workspaceId}', WorkspaceChannel::class);

Broadcast::channel('workspace-{workspaceId}-user-{userId}', WorkspaceUserChannel::class);