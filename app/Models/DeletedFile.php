<?php

namespace Pterodactyl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeletedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_id',
        'directory',
        'file_name',
        'is_file',
        'size',
        'deleted_at',
    ];

    protected $casts = [
        'is_file' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}