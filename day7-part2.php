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
                $line = substr($line, strlen($parts[0]));

            } else {
                $texts[] = $parts[1];
                $line = substr($line, strlen($parts[1]));
            }
        }

        // Outside bracket == OK
        $outsides = [];

        // Get all ABA texts that are outside of brackets
        foreach ($texts as $text) {
            $temp = lookupABA($text);
            if ($temp) {
                $outsides[] = $temp;
            }
        }

        // Now loop through outside texts
        foreach ($outsides as $outside) {
            // Loop through all ABA elements
            foreach ($outside as $element) {
                // Now loop through text within brackets
                foreach ($brackets as $bracket) {
                    // See if we can match an ABA (element) with BAB (text within brackets)
                    if (lookupBAB($bracket, $element)) {
                        $counter++;
                        break 3;
                    }
                }
            }
        }
    }

    echo "Day 7 answer 1 : " . $counter . " " . PHP_EOL;

    fclose($handle);
} else {
    // Error opening the file.
}

function lookupABA($input)
{
    $letters = str_split($input);

    $current_letter = 0;
    $return = [];
    while ($current_letter + 3 <= count($letters)) {
        $letter1 = $letters[$current_letter + 0];
        $letter2 = $letters[$current_letter + 1];
        $letter3 = $letters[$current_letter + 2];

        if ($letter1 == $letter3 && $letter1 != $letter2) {
            $return[] = $letter1 . $letter2 . $letter3;
        }
        $current_letter++;
    }

    return $return;
}

function lookupBAB($input, $aba)
{
    $letters = str_split($input);

    $current_letter = 0;

    while ($current_letter + 3 <= count($letters)) {
        $letter1 = $letters[$current_letter + 0];
        $letter2 = $letters[$current_letter + 1];
        $letter3 = $letters[$current_letter + 2];

        if ($letter1 == $letter3 && $letter1 != $letter2) {
            // See if ABA matches BAB
            if ($letter2 . $letter1 . $letter2 == $aba) {
                return true;
            }
        }
        $current_letter++;
    }

    return false;
}