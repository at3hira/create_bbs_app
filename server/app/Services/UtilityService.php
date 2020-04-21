<?php

namespace App\Services;

class UtilityService
{
    public function judge_device($ua)
    {
        if ((strpos($ua, 'iPhone') !== false)
            || (strpos($ua, 'iPod') !== false)
            || (strpos($ua, 'Android') !== false)) {
            return false;
        } else {
            return true;
        }
    }
}