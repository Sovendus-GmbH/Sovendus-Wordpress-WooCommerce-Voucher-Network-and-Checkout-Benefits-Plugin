<?php

$wordpressPath = __DIR__ . '/vendor/johnpbloch/wordpress/wp-load.php';
echo "Debug: Checking path $wordpressPath\n";
if (file_exists($wordpressPath)) {
    require_once $wordpressPath;
} else {
    echo "Error: wp-load.php not found at $wordpressPath\n";
    echo "Current directory: " . __DIR__ . "\n";

    echo "Contents of current directory:\n";
    $currentDirContents = scandir(__DIR__);
    foreach ($currentDirContents as $item) {
        echo $item . "\n";
    }

    echo "Contents of vendor directory:\n";
    $vendorContents = scandir(__DIR__ . '/vendor');
    foreach ($vendorContents as $item) {
        echo $item . "\n";
    }

    echo "Contents of vendor/johnpbloch directory:\n";
    $johnpblochContents = scandir(__DIR__ . '/vendor/johnpbloch');
    foreach ($johnpblochContents as $item) {
        echo $item . "\n";
    }

    echo "Contents of vendor/johnpbloch/wordpress directory:\n";
    $wordpressContents = scandir(__DIR__ . '/vendor/johnpbloch/wordpress');
    foreach ($wordpressContents as $item) {
        echo $item . "\n";
    }

    exit(1);
}
