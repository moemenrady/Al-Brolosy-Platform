<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBehavior extends Model
{
    protected $fillable = [
        'identity_id',
        'client_id',
        'user_id',
        'project_id',
        'session_id',
        'event_type',
        'page_url',
        'page_title',
        'metadata',
        'device',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function identity(): BelongsTo
    {
        return $this->belongsTo(Identity::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
