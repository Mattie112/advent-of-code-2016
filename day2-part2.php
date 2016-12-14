<?php

$input = "RDLULDLDDRLLLRLRULDRLDDRRRRURLRLDLULDLDLDRULDDLLDRDRUDLLDDRDULLLULLDULRRLDURULDRUULLLUUDURURRDDLDLDRRDDLRURLLDRRRDULDRULURURURURLLRRLUDULDRULLDURRRLLDURDRRUUURDRLLDRURULRUDULRRRRRDLRLLDRRRDLDUUDDDUDLDRUURRLLUDUDDRRLRRDRUUDUUULDUUDLRDLDLLDLLLLRRURDLDUURRLLDLDLLRLLRULDDRLDLUDLDDLRDRRDLULRLLLRUDDURLDLLULRDUUDRRLDUDUDLUURDURRDDLLDRRRLUDULDULDDLLULDDDRRLLDURURURUUURRURRUUDUUURULDLRULRURDLDRDDULDDULLURDDUDDRDRRULRUURRDDRLLUURDRDDRUDLUUDURRRLLRR
RDRRLURDDDDLDUDLDRURRLDLLLDDLURLLRULLULUUURLDURURULDLURRLRULDDUULULLLRLLRDRRUUDLUUDDUDDDRDURLUDDRULRULDDDLULRDDURRUURLRRLRULLURRDURRRURLDULULURULRRLRLUURRRUDDLURRDDUUDRDLLDRLRURUDLDLLLLDLRURDLLRDDUDDLDLDRRDLRDRDLRRRRUDUUDDRDLULUDLUURLDUDRRRRRLUUUDRRDLULLRRLRLDDDLLDLLRDDUUUUDDULUDDDUULDDUUDURRDLURLLRUUUUDUDRLDDDURDRLDRLRDRULRRDDDRDRRRLRDULUUULDLDDDUURRURLDLDLLDLUDDLDLRUDRLRLDURUDDURLDRDDLLDDLDRURRULLURULUUUUDLRLUUUDLDRUDURLRULLRLLUUULURLLLDULLUDLLRULRRLURRRRLRDRRLLULLLDURDLLDLUDLDUDURLURDLUURRRLRLLDRLDLDRLRUUUDRLRUDUUUR
LLLLULRDUUDUUDRDUUURDLLRRLUDDDRLDUUDDURLDUDULDRRRDDLLLRDDUDDLLLRRLURDULRUUDDRRDLRLRUUULDDULDUUUDDLLDDDDDURLDRLDDDDRRDURRDRRRUUDUUDRLRRRUURUDURLRLDURDDDUDDUDDDUUDRUDULDDRDLULRURDUUDLRRDDRRDLRDLRDLULRLLRLRLDLRULDDDDRLDUURLUUDLLRRLLLUUULURUUDULRRRULURUURLDLLRURUUDUDLLUDLDRLLRRUUDDRLUDUDRDDRRDDDURDRUDLLDLUUDRURDLLULLLLUDLRRRUULLRRDDUDDDUDDRDRRULURRUUDLUDLDRLLLLDLUULLULLDDUDLULRDRLDRDLUDUDRRRRLRDLLLDURLULUDDRURRDRUDLLDRURRUUDDDRDUUULDURRULDLLDLDLRDUDURRRRDLDRRLUDURLUDRRLUDDLLDUULLDURRLRDRLURURLUUURRLUDRRLLULUULUDRUDRDLUL
LRUULRRUDUDDLRRDURRUURDURURLULRDUUDUDLDRRULURUDURURDRLDDLRUURLLRDLURRULRRRUDULRRULDLUULDULLULLDUDLLUUULDLRDRRLUURURLLUUUDDLLURDUDURULRDLDUULDDRULLUUUURDDRUURDDDRUUUDRUULDLLULDLURLRRLRULRLDLDURLRLDLRRRUURLUUDULLLRRURRRLRULLRLUUDULDULRDDRDRRURDDRRLULRDURDDDDDLLRRDLLUUURUULUDLLDDULDUDUUDDRURDDURDDRLURUDRDRRULLLURLUULRLUDUDDUUULDRRRRDLRLDLLDRRDUDUUURLRURDDDRURRUDRUURUUDLRDDDLUDLRUURULRRLDDULRULDRLRLLDRLURRUUDRRRLRDDRLDDLLURLLUDL
ULURLRDLRUDLLDUDDRUUULULUDDDDDRRDRULUDRRUDLRRRLUDLRUULRDDRRLRUDLUDULRULLUURLLRLLLLDRDUURDUUULLRULUUUDRDRDRUULURDULDLRRULUURURDULULDRRURDLRUDLULULULUDLLUURULDLLLRDUDDRRLULUDDRLLLRURDDLDLRLLLRDLDRRUUULRLRDDDDRUDRUULDDRRULLDRRLDDRRUDRLLDUDRRUDDRDLRUDDRDDDRLLRDUULRDRLDUDRLDDLLDDDUUDDRULLDLLDRDRRUDDUUURLLUURDLULUDRUUUDURURLRRDULLDRDDRLRDULRDRURRUDLDDRRRLUDRLRRRRLLDDLLRLDUDUDDRRRUULDRURDLLDLUULDLDLDUUDDULUDUDRRDRLDRDURDUULDURDRRDRRLLRLDLU";

//$input = "ULL
//RRDDD
//LURDL
//UUUUD";

$input = explode("\n", $input);

//$keypad = [
//    1 => [1 => 1, 2 => 2, 3 => 3],
//    2 => [1 => 4, 2 => 5, 3 => 6],
//    3 => [1 => 7, 2 => 8, 3 => 9],
//];
$keypad = [
    1 => [3 => 1],
    2 => [2 => 2, 3 => 3, 4 => 4],
    3 => [1 => 5, 2 => 6, 3 => 7, 4 => 8, 5 => 9],
    4 => [2 => "A", 3 => "B", 4 => "C"],
    5 => [3 => "D"],
];

$current_button = [3, 1];

$x = 0;
$y = 0;

$code = [];

foreach ($input as $line) {
    $line = str_split($line);

    foreach ($line as $letter) {
        $x = $current_button[0];
        $y = $current_button[1];
        switch ($letter) {
            case "U":
                $new_pos = move($x, $y, 1, -1, $keypad);
                break;
            case "R":
                $new_pos = move($x, $y, -1, 1, $keypad);
                break;
            case "D":
                $new_pos = move($x, $y, 1, 1, $keypad);
                break;
            case "L":
                $new_pos = move($x, $y, -1, -1, $keypad);
                break;
        }
        $current_button = [$new_pos[0], $new_pos[1]];
    }

    $key_row = $current_button[0];
    $key_col = $current_button[1];
    $key = $keypad[$key_row][$key_col];
    $code[] = $key;
}

echo "Day 2 answer 2: " . (implode("", $code)).PHP_EOL;

function move($x, $y, $direction, $amount, $keypad)
{
    if ($direction === -1) {
        $row = $keypad[$x];
        reset($row);
        $first = key($row);
        end($row);
        $last = key($row);

        $y += $amount;

        if ($y < $first) {
            reset($row);
            $y = key($row);
        }
        if ($y > $last) {
            end($row);
            $y = key($row);
        }

    } else {
        $row_id = $x;
        $old_row_id = $x;

        $new_row_id = $row_id + $amount;
        if ($new_row_id > 5) {
            $new_row_id = 5;
        }
        if ($new_row_id < 1) {
            $new_row_id = 1;
        }

        $new_row = $keypad[$new_row_id];

        if (!isset($new_row[$y]) || $new_row[$y] === null) {
            $new_row_id = $old_row_id;
        }

        $x = $new_row_id;
    }

    return [$x, $y];
}