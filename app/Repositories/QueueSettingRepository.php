<?php

namespace App\Repositories;

use App\Models\QueueSetting;

class QueueSettingRepository
{
    public function getKioskSettings()
    {
        return QueueSetting::first();
    }
}
