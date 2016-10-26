<?php

define('ROOT1', dirname(__FILE__));

//2-старт, 3-оптимал, 4-премиальный
// ВАЖНЫЙ МОМЕНТ! Номер тарифа это номер колонки из страници парсинга
$tarif = 2;

$siteUrl = 'http://oll.tv/tv-channels'; //откуда берем материал
$pathCode = '/olltv-channels/'; //ЭТО ТЕСТОВЫЙ ПУТЬ где лежит код!!!!!!
$nameFileCache = 'page.php'; //имя файла куда будет писатся код
$rootPath = 'http://' . $_SERVER['SERVER_NAME'] . $pathCode;// ЭТО нужно поменять на нормальный путь!!!!!!


$fileTime = 'fileTime.txt';
$timeUpdateCache = 10; //время обновления кеша в секундах
$dirCache = 'cache'; //название папки куда будес складывать кэш

require_once ('getTarifClass.php');
require_once ('statusCacheClass.php');




