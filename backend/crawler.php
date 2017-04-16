<?php
require __DIR__.'/../vendor/autoload.php';
use wapmorgan\altarix\Crawler;
use wapmorgan\altarix\Database;

$crawler = new Crawler();
$database = Database::open();

$check = $crawler->performCheck();
$database->insertCheckResult($check);
