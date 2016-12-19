<?php

$handle = fopen("day9.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);

        $decompressed = 0;

        $decompressed = parsePart($line);

        echo "Day 8 answer 2 : " . $decompressed . " " . PHP_EOL;
    }
    fclose($handle);
} else {
    // Error opening the file.
}

// Stolen from https://github.com/jvwag/advent-of-code-2016/blob/master/src/Year2016/Day9.php as I was unable to find a nice solution
function parsePart($str)
{
    $total = 0;
    while (preg_match("/([A-Z]+)?\\(([0-9]+)x([0-9]+)\\)(.*)$/", $str, $match)) {
        list(, $prepend, $len, $mul, $rest) = $match;
        $res = parsePart(substr($rest, 0, $len));
        $total += strlen($prepend) + ($res * $mul);
        $str = substr($str, strlen("(" . $len . "x" . $mul . ")") + strlen($prepend) + $len);
    }

    return strlen($str) + $total;
}