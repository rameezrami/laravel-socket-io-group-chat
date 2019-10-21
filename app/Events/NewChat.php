<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChat implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    private $params;

    /**
     * Create a new event instance.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;

        $this->data = $params;
    }

    public function broadcastAs()
    {
        return 'new.chat';
    }

    public function broadcastWith()
    {
        return $this->params['data'];
    }

    /**
     * Get the channels the event should broadcast on.
     * @return Channel|Channel[]
     */
    public function broadcastOn()
    {
        $workspaceId = $this->params['workspace_id'];
        $userIds = $this->params['user_ids'];
        $chat_id = $this->params['chat_id'];

        $channels = [];

        if($chat_id==='single-channel'):
            $channels = ['workspace-1'];
        else:
            foreach ($userIds as $userId):
                $channels[]= new Channel("workspace-{$workspaceId}-user-{$userId}");
            endforeach;
        endif;

        return $channels;
    }
}
