<?php

/**
 * 取指定长度的随机英文字符
 * @param $length
 * @return string
 */
function randomEnSTR($length)
{
    if ($length <= 0) {
        return 'a';
    }
    $STR = [
        'a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l',
        'm', 'n', 'o', 'p', 'q', 'r',
        's', 't', 'u', 'v', 'w', 'x',
        'y', 'x'
    ];
    $temp = [];
    for ($i = 0; $i< $length; $i++) {
        shuffle($STR);
        $temp[] = $STR[0];
    }
    shuffle($temp);
    return implode('', $temp);
}
