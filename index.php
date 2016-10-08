<?php
require 'phpQuery.php';

$siteUrl = 'http://oll.tv/tv-channels';

$getSite = file_get_contents($siteUrl);

$doc = phpQuery::newDocument($getSite);

//$tbl = $doc->find('.cont-channels-list');
$tbl = $doc->find('.cont-channels-list tr:eq(0)');
echo $tbl;