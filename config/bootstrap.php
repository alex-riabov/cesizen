<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

// ✅ Set default timezone here
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'UTC');

if (file_exists(dirname(__DIR__).'/.env')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}
