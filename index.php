<?php

//Включаем отображение ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT1', dirname(__FILE__));

require_once ('config.php');

$forPathTarif = new getTarifClass();
$pathTarif = $forPathTarif->getTarif($tarif);
$fileTime = ROOT1.$pathTarif.$fileTime;
$getStatusCache = new statusCacheClass();
$statusCache = $getStatusCache->getTimeCache($fileTime, $timeUpdateCache);


if ($statusCache) {
    
    require_once (ROOT1 . '/phpQuery.php');
    require_once (ROOT1 . '/foldersClass.php');
    require_once (ROOT1 . '/saveImgOlltvClass.php');
    require_once (ROOT1 . '/clearDirImg.php');



    $getSite = file_get_contents($siteUrl);//ЭТО самая ВРЕМЯЗАТРАТНАЯ операция
    $doc = phpQuery::newDocument($getSite);

    $imgUrl = new saveImgOlltv();
    $fullClear = new clearDirImg();
    
    $structureDir = new foldersClass();
    $structureDir->createFolders($dirCache);//проверяем есть ли у нас необходимая структура папок

//Запускаем очистку папки от изображений чтобы туда залить свежие
    $fullClear->clearImg(ROOT1.$pathTarif, $nameFileCache);



    foreach ($doc->find(".cont-channels-list tr") as $article) {
        $article = pq($article);

        $findTarif = $article->find("td:eq($tarif)")->text();

        $imgAttr = $article->find('td img')->attr('src'); //получаем URL картинки что бы потом передать для скачивания
        $urlPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $resultUrl = preg_match($urlPattern, $imgAttr); // тут проверяем если нет Url значит нет изображения и итерация дальше не нужна

        if (!preg_match("/-/i", $findTarif) and $resultUrl) {

            $img = $article->find('td img');
            $imgPathLoc = $imgUrl->saveFile($imgAttr, $pathTarif); // в метод передаем Url изображения по которому получаем его
            $nameCannal = $article->find('td:eq(1)')->text();// Получаем имя канала
            
            if(count(preg_split('~[^\p{L}\p{N}\']+~u',$nameCannal)) > 5){// !!!если в названии канала больше 5ти СЛОВ, то не выводим
            continue ;
            }


            $data = "<div class=\"olltvchennels\">"
                    . " <div class=\"namechennel\"><p> {$nameCannal} </p></div> "
                    . "<img src=\"{$rootPath}{$imgPathLoc}\"/>  "
                    . " </div>";

            $fileCache = ROOT1 . $pathTarif . $nameFileCache; //сюда пишем спарсеные данные

            
            file_put_contents($fileCache, $data, FILE_APPEND);
//            echo $data;// сразу выводми
        }
    }
    
    $rCache = ROOT1.'/' . $pathTarif . $nameFileCache;
    require  $rCache;
    
    touch($fileTime);//меняем время файла на текущее
} else {
    //если файл проверки кэша обновлять не нужно, то запускаем кэшированый файл
//    echo 'Data cache';//Удалить, для теста
    $rCache = ROOT1 . $pathTarif . $nameFileCache;
    require  $rCache;
}
