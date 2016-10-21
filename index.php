<?php

//Включаем отображение ошибок
ini_set('display_errors',1);
error_reporting(E_ALL);

//Подключение файлов системы

define('ROOT1', dirname(__FILE__));
require_once (ROOT1.'config.php');
require_once (ROOT1.'phpQuery.php');
require_once (ROOT1.'saveImgOlltvClass.php');
require_once (ROOT1.'clearDirImg.php');



$siteUrl = 'http://oll.tv/tv-channels';

$getSite = file_get_contents($siteUrl);

$doc = phpQuery::newDocument($getSite);

$imgUrl = new saveImgOlltv;
$fullClear = new clearDirImg;

//Запускаем очистку папки от изображений чтобы туда залить свежие
$fullClear->clearImg();


static $erro = 1;/////////////////////////////////////////

foreach ($doc->find(".cont-channels-list tr") as $article) {
    $article = pq($article);
    
    //Определяем какой тариф выводить - это реализуем позже
    //2-старт, 3-оптимал, 4-премиальный
    // ВАЖНЫЙ МОМЕНТ! Номер тарифа это номер колонки из страници парсинга
    $tarif = 2;
    
    $findTarif = $article->find("td:eq($tarif)")->text();
    
    $imgAttr = $article->find('td img')->attr('src');//получаем URL картинки что бы потом передать для скачивания
    $urlPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    $resultUrl = preg_match($urlPattern, $imgAttr);// тут проверяем если нет Url значит нет изображения и итерация дальше не нужна
    
    if(!preg_match("/-/i", $findTarif) and $resultUrl){
        echo $erro++;////////////////////////////////////////для дебагинга - смотрим номер итерации
        $img = $article->find('td img');
        $imgUrl->saveFile($imgAttr);// в метод передаем Url изображения по которому получаем его
        $nameCannal = $article->find('td:eq(1)')->text();
        
        echo "<div class=\"olltvchennels\">"
            . " <div class=\"namechennel\"><p> {$nameCannal} </p></div> "
            . "  {$img}  "
        . " </div>";
    }
}
