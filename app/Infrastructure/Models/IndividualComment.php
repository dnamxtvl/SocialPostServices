<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class IndividualComment extends Model
{
    use HasApiTokens, HasFactory, HasUuids, SoftDeletes;

    protected $connection = 'mongodb';

    protected $table = 'individual_comments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'content',
        'individual_post_id',
    ];

    public function individualPost(): BelongsTo
    {
        return $this->belongsTo(IndividualPost::class);
    }
}
