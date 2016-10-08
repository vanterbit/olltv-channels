<?php
require 'phpQuery.php';

$siteUrl = 'http://oll.tv/tv-channels';

$getSite = file_get_contents($siteUrl);

$doc = phpQuery::newDocument($getSite);


foreach ($doc->find(".cont-channels-list tr") as $article) {
    $article = pq($article);
    
    //Определяем какой тариф выводить - это реализуем позже
    //2-старт, 3-оптимал, 4-премиальный
    $tarif = 2;
    
    $findTarif = $article->find("td:eq($tarif)")->text();
    
    if(!preg_match("/-/i", $findTarif)){
        $img = $article->find('td img');
        $nameCannal = $article->find('td:eq(1)')->text();
        
        echo "<div class=\"olltvchennels\">"
            . " <div class=\"namechennel\"><p> {$nameCannal} </p></div> "
            . "  {$img}  "
        . " </div>";
    }
}
