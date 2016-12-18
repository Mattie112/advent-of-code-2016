<?php

$handle = fopen("day9-test2.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);

        $fetch_compressed_text = false;
        $compression = "";
        $decompressed = [];

        while ($line != "") {
            // From the start of the string search for regular letters
            preg_match('/^(\w+)/', $line, $parts);
            if ($parts && !$fetch_compressed_text) {
                $decompressed[] = $parts[1];
                $line = substr($line, strlen($parts[0]));
            }

            // From the start of the string search for (aaaaa) and capture "aaaaa"
            preg_match('/^\((\w+)\)/', $line, $parts);
            if ($parts && !$fetch_compressed_text) {
                $fetch_compressed_text = true;
                $compression = $parts[1];
                $line = substr($line, strlen($parts[0]));
            }

            if ($fetch_compressed_text) {
                // Simply fetch some stuff and repeat it
                preg_match('/(\d+)x(\d+)/', $compression, $parts);
                $length = $parts[1];
                $amount = $parts[2];

                $text = substr($line, 0, $length);
                for ($i = 0; $i < $amount; $i++) {
                    $decompressed[] = $text;
                }
                $compression = null;
                $fetch_compressed_text = false;
                $line = substr($line, $parts[1]);
            }
        }
        echo "Day 8 answer 1 : " . strlen(join("", $decompressed)) . " " . PHP_EOL;
    }
    fclose($handle);
} else {
    // Error opening the file.
}

