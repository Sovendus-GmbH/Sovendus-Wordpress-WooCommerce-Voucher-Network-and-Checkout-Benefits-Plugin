<?php
$wordpressPath = __DIR__ . '/vendor/johnpbloch/wordpress-core/wp-load.php';
if (file_exists($wordpressPath)) {
    require_once $wordpressPath;
} else {
    echo "Error: wp-load.php not found at $wordpressPath";
    exit(1);
}
