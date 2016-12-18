<?php

// Initialize screen
$row = array_fill(0, 50, ".");
//$row = array_fill(0, 7, ".");
$screen = array_fill(0, 6, $row);
//$screen = array_fill(0, 3, $row);

$handle = fopen("day8.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);

        preg_match('/rect.(\d+)x(\d+)/', $line, $parts);
        if ($parts) {
            rect($parts[1], $parts[2], $screen);
        }

        preg_match('/rotate.column.x=(\d+).by.(\d+)/', $line, $parts);
        if ($parts) {
            rotateColumn($parts[1], $parts[2], $screen);
        }

        preg_match('/rotate.row.y=(\d+).by.(\d+)/', $line, $parts);
        if ($parts) {
            rotateRow($parts[1], $parts[2], $screen);
        }
    }

    drawScreen($screen);

    $count = 0;
    foreach ($screen as $row) {
        $counts = array_count_values($row);
        $count += $counts["#"];
    }

    echo "Day 8 answer 1 : " . $count . " " . PHP_EOL;
    echo "Day 8 answer 2 : see image above" . PHP_EOL;


    fclose($handle);
} else {
    // Error opening the file.
}

function drawScreen($screen)
{
    // Draw the screen
    foreach ($screen as $row) {
        foreach ($row as $col_id => $column) {
            echo $column;
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
}

function rect($x, $y, &$screen)
{
    for ($iy = 0; $iy < $y; $iy++) {
        for ($ix = 0; $ix < $x; $ix++) {
            $screen[$iy][$ix] = "#";
        }
    }
}

function rotateRow($y, $amount, &$screen)
{
    for ($i = 0; $i < $amount; $i++) {
        $copy = $screen;
        $row = $copy[$y];
        foreach ($row as $column_id => $column) {
            $value = $column;
            $new_column_id = $column_id + 1;
            if ($new_column_id >= count($row)) {
                $new_column_id = 0;
            }
            $screen[$y][$new_column_id] = $value;
        }
    }
}

function rotateColumn($x, $amount, &$screen)
{
    for ($i = 0; $i < $amount; $i++) {
        $copy = $screen;
        foreach ($copy as $row_id => $row) {
            $value = $row[$x];
            $new_row_id = $row_id + 1;
            if ($new_row_id >= count($screen)) {
                $new_row_id = 0;
            }
            $screen[$new_row_id][$x] = $value;
        }
    }
}