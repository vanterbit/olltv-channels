<?php

/**
 * Создаем структуру папок для кеширования файлов
 *
 * @author Vanterbit
 */
class foldersClass {
 
     /**
     * Проверяем если нет папки куда будем складывать файлы то создаем структуру
     * 
     * @param string $dirCache  передаем название папки кэша
     * 
     * @author Vanterbit
     */
public function createFolders($dirCache = 'cache'){
    
    if (!is_dir($dirCache)) {

        $arrPath = explode('/', dirname(__FILE__));
        $dirNow = end($arrPath);
        //chmod('../'.$dirNow, 0777);

        mkdir($dirCache);

        mkdir($dirCache . '/start');
        mkdir($dirCache . '/start/images');
        mkdir($dirCache . '/optimal');
        mkdir($dirCache . '/optimal/images');
        mkdir($dirCache . '/premium');
        mkdir($dirCache . '/premium/images');
    }
}

}
