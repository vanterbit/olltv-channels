<?php
require 'phpQuery.php';
require 'saveImgOlltvClass.php';

$siteUrl = 'http://oll.tv/tv-channels';

$getSite = file_get_contents($siteUrl);

$doc = phpQuery::newDocument($getSite);

$imgUrl = new saveImgOlltv;


static $erro = 1;/////////////////////////////////////////

foreach ($doc->find(".cont-channels-list tr") as $article) {
    $article = pq($article);
    
    //Определяем какой тариф выводить - это реализуем позже
    //2-старт, 3-оптимал, 4-премиальный
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
