<?php

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dataPopulator = new \Luma\Tests\Classes\DataPopulator();

$dataPopulator->populate();