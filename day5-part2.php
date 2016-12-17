<?php

//$input = "abc";
$input = "wtnhxymk";
$counter = 0;
$continue = true;
$password = [];
while ($continue) {

    if ($counter % 10000 == 0) {
        echo ".";
    }

    $hash = md5($input . $counter);

    if (substr($hash, 0, 5) === "00000") {
        $position = substr($hash, 5, 1);
        $position = hexdec($position);
        if ($position < 8 && !isset($password[$position])) {
            $letter = substr($hash, 6, 1);
            $password[$position] = $letter;
            echo PHP_EOL . "Found character '" . $letter . "' on position " . $position . PHP_EOL;
        }
    }

    if (count($password) == 8) {
        $continue = false;
    }

    $counter++;
}

ksort($password);
echo "Day 5 answer 1 '" . implode("", $password) . "'" . PHP_EOL;

