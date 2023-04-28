<?php
require_once '../bootstrap/base-path.php';

$command = $argv[1];

switch ($command) {
    case 'migrate':
        require 'migrate.php';
        break;
    case 'seed':
        require 'seed.php';
        break;
    default:
        echo 'Console Error';
        break;
}
