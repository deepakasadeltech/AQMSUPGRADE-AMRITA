<?php

namespace App\Repositories;

use App\Models\DisplaySetting;

class DisplaySettingRepository
{
    public function getDisplaySettings()
    {
        return DisplaySetting::first();
    }
}
