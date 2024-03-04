<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thought extends Model
{
    use HasFactory;

    protected $fillable = [
      'message',
    ];

    protected $dispatchesEvents = [
      'created' => \App\Events\ThoughtMade::class,
    ];

    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class);
    }
}
