<?php

$handle = fopen("day10.txt", "r");
$bots = [];
$output_bin = [];
$requested_val_1 = 61;
$requested_val_2 = 17;
$answer_bot_id = false;
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);

        if (preg_match('/value.(\d+)\D+(\d+)/', $line, $parts)) {
            $bot_id = $parts[2];
            $value = $parts[1];
            $bots[$bot_id]["values"][] = $value;
        }

        if (preg_match('/bot.(\d+).*(bot|output).(\d+).*(bot|output).(\d+)/', $line, $parts)) {
            $bot_id = $parts[1];
            $low_to = $parts[2];
            $low_to_id = $parts[3];
            $high_to = $parts[4];
            $high_to_id = $parts[5];

            $bots[$bot_id]["low_to"] = $parts[2];
            $bots[$bot_id]["low_to_id"] = $parts[3];
            $bots[$bot_id]["high_to"] = $parts[4];
            $bots[$bot_id]["high_to_id"] = $parts[5];
        }
    }

    $continue = true;
    while ($continue) {
        $continue = false;
        foreach ($bots as $id => &$bot) {
            if (isset($bot["values"]) && count($bot["values"]) == 2 && !isset($bot["done"])) {

                if (in_array($requested_val_1, $bot["values"]) && in_array($requested_val_2, $bot["values"])) {
                    $answer_bot_id = $id;
                }

                if (isset($bot["low_to"]) && $bot["low_to"] == "bot") {
                    $bots[$bot["low_to_id"]]["values"][] = min($bot["values"]);
                }
                if (isset($bot["low_to"]) && $bot["low_to"] == "output") {
                    $output_bin[$bot["low_to_id"]]["values"][] = min($bot["values"]);
                }

                if (isset($bot["high_to"]) && $bot["high_to"] == "bot") {
                    $bots[$bot["high_to_id"]]["values"][] = max($bot["values"]);
                }
                if (isset($bot["high_to"]) && $bot["high_to"] == "output") {
                    $output_bin[$bot["high_to_id"]]["values"][] = max($bot["values"]);
                }

                $bots[$id]["done"] = true;
                $continue = true;
            }
        }

    }

    echo "Day 10 answer 1 : " . $answer_bot_id . " " . PHP_EOL;
    echo "Day 10 answer 2 : " . (reset($output_bin[0]["values"]) * reset($output_bin[1]["values"]) * reset($output_bin[2]["values"])) . " " . PHP_EOL;

    fclose($handle);
} else {
    // Error opening the file.
}

