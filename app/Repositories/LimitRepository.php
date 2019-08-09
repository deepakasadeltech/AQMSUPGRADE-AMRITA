<?php

namespace App\Repositories;

use App\Models\Limit;

class LimitRepository
{
    public function getLimitData()
    {
        return Limit::first();
    }
}
