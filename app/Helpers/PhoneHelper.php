<?php

namespace App\Helpers;

class PhoneHelper
{
    /**
     * Это "79863098282" выведет как "+7 (986) 309-82-82"
     */
    public static function beautifyMobile($in): string
    {
        return preg_replace(
            '/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/',
            '+\1 (\2) \3-\4-\5',
            (string)$in
        );
    }
}
