<?php

//Проверяем если нет папки куда будем складывать файлы то создаем структуру 
$dirCache = 'cache';
if (!is_dir($dirCache)) {
    mkdir($dirCache);

    mkdir($dirCache . '/start');
    mkdir($dirCache . '/start/images');
    mkdir($dirCache . '/optimal');
    mkdir($dirCache . '/optimal/images');
    mkdir($dirCache . '/premium');
    mkdir($dirCache . '/premium/images');
}
