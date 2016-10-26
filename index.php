<?php

//Включаем отображение ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT1', dirname(__FILE__));
require_once ('config.php');
require_once ('getTarifClass.php');


$fileTime = 'fileTime.txt';
$timeUpdateCache = 10; //время обновления кеша в секундах

//2-старт, 3-оптимал, 4-премиальный
// ВАЖНЫЙ МОМЕНТ! Номер тарифа это номер колонки из страници парсинга
$tarif = 3;
$forPathTarif = new getTarifClass();
$pathTarif = $forPathTarif->getTarif($tarif);


$siteUrl = 'http://oll.tv/tv-channels'; //откуда берем материал
$pathCode = '/olltv-channels/'; //ЭТО ТЕСТОВЫЙ ПУТЬ где лежит код!!!!!!
$nameFileCache = 'page.php'; //имя файла куда будет писатся код
$rootPath = 'http://' . $_SERVER['SERVER_NAME'] . $pathCode;// ЭТО нужно поменять на нормальный путь

//если нет файла по котрому смотрим время, то создаем его
if (!file_exists($fileTime)) {
    fopen($fileTime, 'w');
    touch($fileTime, time()-($timeUpdateCache+5));// меняем время создания файла 
}

//
$now_date = date("d-m-Y H:i:s");
$updateFiles = date("d-m-Y H:i:s", filemtime($fileTime));
$timeResult = floor((strtotime($now_date) - strtotime($updateFiles)));

echo $timeResult;
//ПРОВЕРЯЕМ ЗАПУСКАТЬ ИЛИ НЕТ
if ($timeResult > $timeUpdateCache) {
    
    //Подключение файлов системы
    require_once (ROOT1 . '/phpQuery.php');
    require_once (ROOT1 . '/saveImgOlltvClass.php');
    require_once (ROOT1 . '/clearDirImg.php');



    $getSite = file_get_contents($siteUrl);
    $doc = phpQuery::newDocument($getSite);


    $imgUrl = new saveImgOlltv();
    $fullClear = new clearDirImg();



//Запускаем очистку папки от изображений чтобы туда залить свежие
    $fullClear->clearImg($pathTarif, $nameFileCache);



    foreach ($doc->find(".cont-channels-list tr") as $article) {
        $article = pq($article);

        $findTarif = $article->find("td:eq($tarif)")->text();

        $imgAttr = $article->find('td img')->attr('src'); //получаем URL картинки что бы потом передать для скачивания
        $urlPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $resultUrl = preg_match($urlPattern, $imgAttr); // тут проверяем если нет Url значит нет изображения и итерация дальше не нужна

        if (!preg_match("/-/i", $findTarif) and $resultUrl) {

            $img = $article->find('td img');
            $imgPathLoc = $imgUrl->saveFile($imgAttr, $pathTarif); // в метод передаем Url изображения по которому получаем его
            $nameCannal = $article->find('td:eq(1)')->text();


            $data = "<div class=\"olltvchennels\">"
                    . " <div class=\"namechennel\"><p> {$nameCannal} </p></div> "
                    . "<img src=\"{$rootPath}{$imgPathLoc}\"/>  "
                    . " </div>";

            $fileCache = $pathTarif . $nameFileCache; //сюда пишем спарсеные данные

            
            file_put_contents($fileCache, $data, FILE_APPEND);
            echo $data;
        }
        touch($fileTime, time());//меняем время файла
    }
} else {
    //если файл проверки кэша обновлять не нужно, то запускаем кєшированый файл
    echo 'cache';
    $rCache = ROOT1.'/' . $pathTarif . $nameFileCache;
    require  $rCache;
}
