<?php

namespace App\Models;

use App\Events\SendChatMessage;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        "sender_id",
        "receiver_id",
        "message"
    ];

    public function sender()
    {
       return $this->belongsTo(User::class,"sender_id");
    }

    public function receiver()
    {
       return $this->belongsTo(User::class,"receiver_id");
    }

    public function send($message,$from_user,$to_user)
    {
            $chatMessage = ChatMessage::create([
                "sender_id" => $from_user,
                "receiver_id" => $to_user,
                "message" => $message
            ]);

            SendChatMessage::dispatch($chatMessage);
    }
}
