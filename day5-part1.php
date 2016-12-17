<?php

//$input = "abc";
$input = "wtnhxymk";
$counter = 0;
$continue = true;
$password = "";
while ($continue) {

    if ($counter % 10000 == 0) {
        echo ".";
    }

    $hash = md5($input . $counter);

    if (substr($hash, 0, 5) === "00000") {
        $letter = substr($hash, 5, 1);
        $password .= $letter;
        echo PHP_EOL . "Found character '" . $letter . "'" . PHP_EOL;
    }

    if (strlen($password) == 8) {
        $continue = false;
    }

    $counter++;
}

echo "Day 5 answer 1 '" . $password . "'" . PHP_EOL;

