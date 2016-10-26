<?php

/**
 * Очищаем папку от изображений(логотипов)
 *
 * @author Vanterbit
 */

class clearDirImg {

    /**
     * Удаляем все файлы с папки
     * 
     * @param string $dir - путь к папке с файлами
     * 
     * @param string $nameCacheFile - имя файла куда пишется код
     *
     * @return boolean  -  возвращаемРезультат
     */
    public function clearImg($dir, $nameCacheFile = 'page.php') {
        

        $delCacheFile = $dir . $nameCacheFile;
        if(file_exists($delCacheFile)){
        unlink($delCacheFile);//удаляем файл с кешированым кодом чтобы создать новый
        }
        
        $dir .= 'images/'; // Папка с изображениями

        $files = scandir($dir); // Берём всё содержимое директории

        $k = 0; // Вспомогательный счётчик для перехода на новые строки
        for ($i = 0; $i < count($files); $i++) { // Перебираем все файлы
            $urlPattern = '/.*\.(jpg|gif|png)$/';
            if (($files[$i] != ".") && ($files[$i] != "..") && (preg_match($urlPattern, $files[$i]))) { // Текущий каталог и родительский пропускаем
                unlink($dir . $files[$i]);
                $k++; // Увеличиваем вспомогательный счётчик
            }
        }
    }
    

}
