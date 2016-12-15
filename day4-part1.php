<?php

$counter = 0;

$handle = fopen("day4.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {

        preg_match('/([a-z\-]+)\-(\d+)\[([a-z]+)]/', $line, $parts);

        $room = $parts[1];
        $sector_id = $parts[2];
        $checksum = $parts[3];

        if (verifyRoom($room, $checksum)) {
            $counter += $sector_id;
        }
    }

    echo "Day 4 answer 1 : " . $counter . " " . PHP_EOL;

    fclose($handle);
} else {
    // Error opening the file.
}

function verifyRoom($room, $checksum)
{
    // Remove all dashes
    $room = str_replace("-", "", $room);

    $room_letters = str_split($room);

    // Count all letters
    $letter_amounts = array_count_values($room_letters);

    $letters = [];
    $frequency = [];
    foreach ($letter_amounts as $letter => $amount) {
        $letters[] = $letter;
        $frequency[] = $amount;
    }

    // Now sort the monster - http://php.net/manual/en/function.array-multisort.php
    array_multisort($frequency, SORT_DESC, $letters, SORT_ASC);

    // Generate a checksum and if it matches return true
    $checksum_generated = $letters[0] . $letters[1] . $letters[2] . $letters[3] . $letters[4];
    if ($checksum_generated === $checksum) {
        return true;
    }

    return false;
}