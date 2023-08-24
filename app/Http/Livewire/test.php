<?php
    $arr = ['one' => 'a', 2 => 'b', 'three' => 'c'];
 
    $old_key = '2';
 
    if (array_key_exists($old_key, $arr)) {
        unset($arr[$old_key]);
    }
 
    print_r($arr);