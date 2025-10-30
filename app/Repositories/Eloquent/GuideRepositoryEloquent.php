<?php

namespace App\Repositories\Eloquent;

use App\Domain\Guides\Contracts\GuideRepository;
use App\Models\Guide;

final class GuideRepositoryEloquent implements GuideRepository
{
    public function findActive(int $id): ?Guide
    {
        return Guide::query()->whereKey($id)->where('is_active', true)->first();
    }
}
