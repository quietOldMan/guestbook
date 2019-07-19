<?php

namespace Guestbook\Utils;

abstract class Helper
{
    /**
     * @param $string
     * @return string
     */
    public static function compactString($string)
    {
        $compacted = '';
        preg_match_all('/(.)\1*/', $string, $matches, PREG_SET_ORDER);
        foreach ($matches as $m) {
            $compacted = $compacted . ($m[0][0] . strlen($m[0]));
        }

        if (strlen($compacted) > strlen($string)) {
            return $string;
        } else {
            return $compacted;
        }
    }
}