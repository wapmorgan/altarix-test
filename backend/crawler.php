<?php
require __DIR__.'/../vendor/autoload.php';
use wapmorgan\altarix\Crawler;
use wapmorgan\altarix\Database;

$crawler = new Crawler();
$database = Database::open();

$check = $crawler->performCheck();
try {
    $database->insertCheckResult($check);
} catch (Exception $e) {
    fwrite(STDERR, 'An error occured during storing to DB: ['.$e->getCode().'] '.$e->getMessage());
}
