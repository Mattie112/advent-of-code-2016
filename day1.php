<?php

const NORTH = 0;
const EAST = 1;
const SOUTH = 2;
const WEST = 3;

const LEFT = -1;
const RIGHT = 1;

$input = "L5, R1, R4, L5, L4, R3, R1, L1, R4, R5, L1, L3, R4, L2, L4, R2, L4, L1, R3, R1, R1, L1, R1, L5, R5, R2, L5, R2, R1, L2, L4, L4, R191, R2, R5, R1, L1, L2, R5, L2, L3, R4, L1, L1, R1, R50, L1, R1, R76, R5, R4, R2, L5, L3, L5, R2, R1, L1, R2, L3, R4, R2, L1, L1, R4, L1, L1, R185, R1, L5, L4, L5, L3, R2, R3, R1, L5, R1, L3, L2, L2, R5, L1, L1, L3, R1, R4, L2, L1, L1, L3, L4, R5, L2, R3, R5, R1, L4, R5, L3, R3, R3, R1, R1, R5, R2, L2, R5, L5, L4, R4, R3, R5, R1, L3, R1, L2, L2, R3, R4, L1, R4, L1, R4, R3, L1, L4, L1, L5, L2, R2, L1, R1, L5, L3, R4, L1, R5, L5, L5, L1, L3, R1, R5, L2, L4, L5, L1, L1, L2, R5, R5, L4, R3, L2, L1, L3, L4, L5, L5, L2, R4, R3, L5, R4, R2, R1, L5";
//$input = "R2, R2, R2";
//$input = "R5, L5, R5, R3";
//$input = "R2, L3";
$moves = explode(", ", $input);

$start = [0, 0];
$position = [0, 0];
$direction = NORTH;
$visited = [];
$first_visisted = null;

foreach ($moves as $move) {
    $amount = substr($move, 1);
    $nw_direction = substr($move, 0, 1);
    $direction = rotate($direction, $nw_direction);
    for($i = 0; $i < $amount; $i++) {
        $position = move($direction, 1, $position);
        if (in_array($position, $visited) && $first_visisted === null) {
            $first_visisted = $position;
        }
        $visited[] = $position;
    }
}

echo "Day 1 answer 1: ".($position[0] + $position[1]).PHP_EOL;
echo "Day 1 answer 2: ".($first_visisted[0] + $first_visisted[1]).PHP_EOL;

function move($direction, $amount, $position)
{
    $x = $position[0];
    $y = $position[1];

    switch ($direction) {

        case NORTH:
            $y += $amount;
            break;
        case EAST:
            $x += $amount;
            break;
        case SOUTH:
            $y -= $amount;
            break;
        case WEST:
            $x -= $amount;
            break;
    }

    return [$x, $y];
}

function rotate($cur, $direction)
{
    $cur += ($direction === "L") ? -1 : 1;
    if ($cur < NORTH) {
        $cur = WEST;
    }
    if ($cur > WEST) {
        $cur = NORTH;
    }

    return $cur;
}