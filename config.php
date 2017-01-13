<?php

//2-старт, 3-оптимал, 4-премиальный
// ВАЖНЫЙ МОМЕНТ! Номер тарифа это номер колонки из страници парсинга
$tarif = 2;

$siteUrl = 'http://oll.tv/tv-channels'; //откуда берем материал
$nameFileCache = 'page.php'; //имя файла куда будет писатся код

//$tmp12345 = explode("\\", ROOT1);// для windows 
$tmp12345 = explode("/", ROOT1);// для Linux 
$pathCode = array_pop($tmp12345); //определяем название папки с кодом. Папка должна находится в корне


$rootPath = 'http://' . $_SERVER['SERVER_NAME'] .'/'. $pathCode;


$fileTime = 'fileTime.txt';
$timeUpdateCache = 10; //время обновления кеша в секундах
$dirCache = ROOT1.'/cache'; //название папки куда будес складывать кэш

require_once ('getTarifClass.php');
require_once ('statusCacheClass.php');




