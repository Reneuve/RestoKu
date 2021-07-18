<?php

namespace App\Events;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTransactionMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $transaction, $user;
    public function __construct(Transaction $transaction, User $user)
    {
        //
        $this->transaction = $transaction;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('Transaction');
    }

    public function broadcastAs()
    {
        return 'NewTransactionMessage';
    }

    public function broadcastWith()
    {
        # code...
        return [
            'amount'=>$this->transaction->amount,
            'name' => $this->user->name,
            'table_number' => $this->transaction->table_number,
            'id'=>$this->transaction->id,
        ];
    }
}
