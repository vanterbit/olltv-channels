<?php

//Включаем отображение ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Подключение файлов системы

define('ROOT1', dirname(__FILE__));
require_once (ROOT1 . '/config.php');
require_once (ROOT1 . '/phpQuery.php');
require_once (ROOT1 . '/saveImgOlltvClass.php');
require_once (ROOT1 . '/clearDirImg.php');



$siteUrl = 'http://oll.tv/tv-channels';

$getSite = file_get_contents($siteUrl);

$doc = phpQuery::newDocument($getSite);

$imgUrl = new saveImgOlltv;
$fullClear = new clearDirImg;



//Определяем какой тариф выводить - это реализуем позже
//2-старт, 3-оптимал, 4-премиальный
// ВАЖНЫЙ МОМЕНТ! Номер тарифа это номер колонки из страници парсинга
$tarif = 2;

//Формируем путь в зависимомти от тарифа куда будем сохранять данные
switch ($tarif) {
    case 2:
        $pathTarif = 'cache/start/';
        break;
    case 3:
        $pathTarif = 'cache/optimal/';
        break;
    case 4:
        $pathTarif = 'cache/premium/';
        break;
}

//Запускаем очистку папки от изображений чтобы туда залить свежие
$fullClear->clearImg($pathTarif);





foreach ($doc->find(".cont-channels-list tr") as $article) {
    $article = pq($article);

    global $pathTarif;

    $findTarif = $article->find("td:eq($tarif)")->text();

    $imgAttr = $article->find('td img')->attr('src'); //получаем URL картинки что бы потом передать для скачивания
    $urlPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    $resultUrl = preg_match($urlPattern, $imgAttr); // тут проверяем если нет Url значит нет изображения и итерация дальше не нужна

    if (!preg_match("/-/i", $findTarif) and $resultUrl) {

        $img = $article->find('td img');
        $imgPathLoc = $imgUrl->saveFile($imgAttr, $pathTarif); // в метод передаем Url изображения по которому получаем его
        $nameCannal = $article->find('td:eq(1)')->text();
        
        $rootPathImg = 'http://'.$_SERVER['SERVER_NAME'].'/olltv-channels/';//ЭТО ТЕСТОВЫЙ ПУТЬ!!!!!!
        $data = "<div class=\"olltvchennels\">"
                . " <div class=\"namechennel\"><p> {$nameCannal} </p></div> "
                . "<img src=\"{$rootPathImg}{$imgPathLoc}\"/>  "
                . " </div>";

        $fileCache = $pathTarif . '/page.html'; //сюда пишем спарсеные данные



        file_put_contents($fileCache, $data, FILE_APPEND);
        echo $data;
    }
}
