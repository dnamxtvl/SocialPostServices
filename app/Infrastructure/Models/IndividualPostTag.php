<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class IndividualPostTag extends Model
{
    use HasApiTokens, HasFactory, HasUuids, SoftDeletes;

    protected $connection = 'mongodb';

    protected $table = 'individual_post_emojis';

    protected $primaryKey = 'id';
}
