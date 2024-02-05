<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Post\RepositoryInterfaces\IndividualPostRepositoryInterface;
use App\Infrastructure\Models\IndividualPost;
use Illuminate\Database\Eloquent\Model;

class IndividualPostRepository implements IndividualPostRepositoryInterface
{
    public function __construct(
        private readonly IndividualPost $individualPost
    ) {
    }

    public function getQuery(array $columnSelects = [], array $filters = [])
    {

    }

    public function findById(string $individualPostId): ?Model
    {
        return $this->individualPost->query()->find(id: $individualPostId);
    }
}
