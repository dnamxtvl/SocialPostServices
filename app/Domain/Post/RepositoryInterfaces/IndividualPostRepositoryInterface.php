<?php

namespace App\Domain\Post\RepositoryInterfaces;

use Illuminate\Database\Eloquent\Model;

interface IndividualPostRepositoryInterface
{
    public function getQuery(array $columnSelects = [], array $filters = []);

    public function findById(string $individualPostId): ?Model;
}
