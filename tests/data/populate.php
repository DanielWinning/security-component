<?php

use Luma\Tests\Classes\DataPopulator;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

(new DataPopulator())->populate([
    [
        'username' => 'Abbie',
        'email' => 'abbie@test.com',
        'password' => 'abbie',
    ],
    [
        'username' => 'Ben',
        'email' => 'ben@test.com',
        'password' => 'password123',
    ],
    [
        'username' => 'Charlie',
        'email' => 'charlie@test.com',
        'password' => 'p4$$word123',
    ],
    [
        'username' => 'Danny',
        'email' => 'danny@test.com',
        'password' => 'P4$$w0rd123!',
    ],
]);