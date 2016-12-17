<?php

$counter = 0;

$letters = [];
$decoded1 = "";
$decoded2 = "";

$handle = fopen("day6.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {

        $message_letters = str_split(trim($line));
        $i = 0;

        foreach ($message_letters as $letter) {
            if (!isset($letters[$i][$letter])) {
                $letters[$i][$letter] = 1;
            } else {
                $letters[$i][$letter]++;
            }
            $i++;
        }
    }

    foreach ($letters as $column) {
        arsort($column);
        $decoded1 .= key($column);

        asort($column);
        $decoded2 .= key($column);
    }

    echo "Day 6 answer 1 : " . $decoded1 . " " . PHP_EOL;
    echo "Day 6 answer 2 : " . $decoded2 . " " . PHP_EOL;

    fclose($handle);
} else {
    // Error opening the file.
}