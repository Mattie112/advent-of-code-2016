<?php

$counter = 0;

$handle = fopen("day3.txt", "r");
$multiplelines = [];
if ($handle) {
    while (($line = fgets($handle)) !== false) {

        preg_match('/\s+(\d*)\s+(\d*)\s+(\d*)/', $line, $parts);

        $multiplelines[0][] = $parts[1];
        $multiplelines[1][] = $parts[2];
        $multiplelines[2][] = $parts[3];

        if (count($multiplelines[1]) < 3) {
            continue;
        }

        // Find triangles
        for($i = 0; $i < 3; $i++) {
            $option1 = findTriangle($multiplelines[$i][0], $multiplelines[$i][1], $multiplelines[$i][2]);
            $option2 = findTriangle($multiplelines[$i][0], $multiplelines[$i][2], $multiplelines[$i][1]);
            $option3 = findTriangle($multiplelines[$i][1], $multiplelines[$i][2], $multiplelines[$i][0]);
            
            if ($option1 && $option2 && $option3) {
                $counter++;
            }
        }

        $multiplelines = [];
    }

    echo "Day 3 answer 2 : " . $counter . " possible triangles" . PHP_EOL;

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