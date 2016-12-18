<?php

$counter = 0;

$candidates = [];

$handle = fopen("day7.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);

        $brackets = [];
        $texts = [];

        // I'm sure this can be fixed with regex but hey this works to!
        // Looping over the input, try to fetch a string without brackets
        // if we don't have that fetch a string WITH brackets
        // save those in an array
        while ($line !== "") {
            preg_match('/^([^\[]\w+)/', $line, $parts);
            $match = $parts[1];

            if (!$match) {
                preg_match('/\[(\w+)\]/', $line, $parts);
                $brackets[] = $parts[1];
                $line = str_replace($parts[0], "", $line);

            } else {
                $texts[] = $parts[1];
                $line = str_replace($parts[1], "", $line);
            }
        }

        // Outside bracket == OK
        $outside = false;
        // Inside brackets == BAD
        $inside = false;

        // Loop over both arrays, and if we have a ABBA set that var to true
        foreach ($brackets as $bracket) {
            if (lookupABBA($bracket)) {
                $inside = true;
                break;
            }
        }

        foreach ($texts as $text) {
            if (lookupABBA($text)) {
                $outside = true;
                break;
            }
        }

        // It is only a valid IPv7 when we have ABBA outside of brackets
        if ($outside && !$inside) {
            $counter++;
        }
    }

    echo "Day 7 answer 1 : " . $counter . " " . PHP_EOL;

    fclose($handle);
} else {
    // Error opening the file.
}

function lookupABBA($input)
{
    $letters = str_split($input);

    $current_letter = 0;

    while ($current_letter + 4 <= count($letters)) {
        $letter1 = $letters[$current_letter + 0];
        $letter2 = $letters[$current_letter + 1];
        $letter3 = $letters[$current_letter + 2];
        $letter4 = $letters[$current_letter + 3];

        if ($letter1 == $letter4 && $letter2 == $letter3 && $letter1 != $letter3) {
            return true;
        }
        $current_letter++;
    }

    return false;
}