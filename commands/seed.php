<?php
define('PATH_TO_FACTORIES', PATH_TO_PROJECT.'/database/seeds/');

if (isset($argv[2])) {
    $seedFile = array(PATH_TO_FACTORIES.$argv[2]);
    seed($seedFile);
} else {
    $allFiles = glob(PATH_TO_FACTORIES.'*.php');
    seed($allFiles);
}

function seed(array $allFiles) {
    foreach ($allFiles as $file) {
        require_once $file;
        $className = basename($file, ".php");
        $seed = new $className;
        $seed->run();
    }
}

