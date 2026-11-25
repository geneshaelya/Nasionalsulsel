<?php

declare(strict_types=1);

$tmpPaths = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
];

foreach ($tmpPaths as $path) {
    if (! is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

require __DIR__ . '/../public/index.php';
