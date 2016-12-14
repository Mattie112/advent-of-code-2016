<?php

$counter = 0;

$handle = fopen("day3.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {

        preg_match('/\s+(\d*)\s+(\d*)\s+(\d*)/', $line, $parts);

        // Find triangles
        $option1 = findTriangle($parts[1], $parts[2], $parts[3]);
        $option2 = findTriangle($parts[1], $parts[3], $parts[2]);
        $option3 = findTriangle($parts[2], $parts[3], $parts[1]);

        if ($option1 && $option2 && $option3) {
            $counter++;
        }
    }

    echo "Day 3 answer 1 : " . $counter . " possible triangles" . PHP_EOL;

    fclose($handle);
} else {
    // error opening the file.
}

function findTriangle($x, $y, $z)
{
    if ($x + $y <= $z) {
        return false;
    }

    return true;
}