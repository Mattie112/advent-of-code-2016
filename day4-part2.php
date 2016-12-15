<?php

$counter = 0;
$valid_rooms = [];

$handle = fopen("day4.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {

        preg_match('/([a-z\-]+)\-(\d+)\[([a-z]+)]/', $line, $parts);

        $room = $parts[1];
        $sector_id = $parts[2];
        $checksum = $parts[3];

        if (true) {
            $counter += $sector_id;
            $valid_rooms[] = [$room, $sector_id];
        }
    }

    // Now we have a list of valid rooms, go ahead and decrypt them
    foreach ($valid_rooms as $item) {
        $room = $item[0];
        $sector_id = $item[1];

        $decrypted = decrypt($room, $sector_id);
        if (strpos($decrypted, "north") !== false) {
            echo "Day 4 answer 2 " . $decrypted . " - " . $sector_id . PHP_EOL;
        }
    }

    fclose($handle);
} else {
    // Error opening the file.
}

function decrypt($room, $sector_id)
{
    $room_words = explode("-", $room);
    $decrypted_words = [];
    foreach ($room_words as $room_word) {
        $room_letters = str_split($room_word);
        $decrypted_letters = [];
        foreach ($room_letters as $letter) {
            $decrypted_letters[] = rotateLetter($letter, $sector_id);
        }
        $decrypted_words[] = implode("", $decrypted_letters);
    }

    $decrypted = implode(" ", $decrypted_words);

    return $decrypted;
}

function rotateLetter($letter, $rotations)
{
    $ascii = ord($letter);
    for ($i = 0; $i < $rotations; $i++) {
        $ascii++;
        if ($ascii > ord("z")) {
            $ascii = ord("a");
        }
    }

    return chr($ascii);
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