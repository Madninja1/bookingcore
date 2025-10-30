<?php

namespace App\Domain\Guides\Contracts;

use App\Models\Guide;

interface GuideRepository
{
    public function findActive(int $id): ?Guide;
}
