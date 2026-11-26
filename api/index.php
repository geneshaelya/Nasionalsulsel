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

$serverlessEnv = [
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'LOG_CHANNEL' => 'stderr',
];

foreach ($serverlessEnv as $key => $value) {
    if (getenv($key) === false) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

require __DIR__ . '/../public/index.php';
