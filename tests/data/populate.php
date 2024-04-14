<?php

use Luma\Tests\Classes\DataPopulator;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

(new DataPopulator())->populate([
    'users' => [
        [
            'username' => 'Abbie',
            'email' => 'abbie@test.com',
            'password' => 'abbie',
            'roles' => ['user'],
        ],
        [
            'username' => 'Ben',
            'email' => 'ben@test.com',
            'password' => 'password123',
            'roles' => ['user'],
        ],
        [
            'username' => 'Charlie',
            'email' => 'charlie@test.com',
            'password' => 'p4$$word123',
            'roles' => ['user'],
        ],
        [
            'username' => 'Danny',
            'email' => 'danny@test.com',
            'password' => 'P4$$w0rd123!',
            'roles' => ['admin'],
        ],
    ],
    'roles' => [
        [
            'name' => 'Administrator',
            'handle' => 'admin',
        ],
        [
            'name' => 'User',
            'handle' => 'user',
        ],
        [
            'name' => 'Moderator',
            'handle' => 'moderator',
        ],
    ],
]);