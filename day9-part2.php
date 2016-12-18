<?php

$handle = fopen("day9.txt", "r");
$iiii = 0;
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

                // First grab the compressed text
                $text = substr($line, 0, $length);
                // Now remove the length from the line
                $line = substr($line, $parts[1]);

                // Simply prepend line with the decompressed string
                // By prepenting it to line it may be decompressed again when needed
                // if not the regex that matched words is triggered saving the output
                for ($i = 0; $i < $amount; $i++) {
                    $line = $text . $line;
                }
                $compression = null;
                $fetch_compressed_text = false;
            }
            if ($iiii % 100 == 0) {
                echo strlen($line).PHP_EOL;
            }
            $iiii++;
        }
        echo "Day 8 answer 2 : " . strlen(join("", $decompressed)) . " " . PHP_EOL;
    }
    fclose($handle);
} else {
    // Error opening the file.
}

