<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class IndividualMediaFile extends Model
{
    use HasApiTokens, HasFactory, HasUuids, SoftDeletes;

    protected $connection = 'mongodb';

    protected $table = 'individual_media_files';

    protected $primaryKey = 'id';
}
