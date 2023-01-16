<?php

require_once ('../vendor/autoload.php');

try {
    $wrapper = new \OddsScanner\PHP\Wrapper();
    $wrapper->start();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

?>