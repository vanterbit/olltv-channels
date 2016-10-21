<?php

/**
 * Переименовует и сoхраняет файлы по URL
 * 
 * @author Vanterbit 
 */
class saveImgOlltv {

    /**
     * Переименовуем полученный файл
     * 
     * Поскольку файл который получаем имеет вид URL с слешами, то переименовуем
     * 
     * @param string $x  передаем url/имя файла
     *
     * @return string   -  возвращаем название файла
     * 
     * @author Vanterbit
     */
    public function getFileNameImg($x) {

        $path_parts = pathinfo($x);
        $getExtensionImg = $path_parts['extension']; //получаем расширение файла
        //
        //меняем символы http://  / .
        $patterns = array();
        $patterns[0] = '/http\:\/\//';
        $patterns[1] = '/\//';
        $patterns[2] = '/\./';

        $replacements = array();
        $replacements[2] = '';
        $replacements[1] = '-';
        $replacements[0] = '_';

        $getFileName = preg_replace($patterns, $replacements, $x);
        $getFullName = $getFileName . "." . $getExtensionImg;

        return $getFullName;
    }

    /**
     * Сoхраняет файлы по URL
     * 
     *
     * @param string $url Первый параметр url файла
     * @param string $path Второй параметр Путь куда сохраняем
     * 
     * @author Prot 
     */
    public function saveFile($url, $path) {
        $img = 'images/';
        $path .= $img;
        $pathNow = $path . $this->getFileNameImg($url);
        file_put_contents($pathNow, file_get_contents($url));

        return $pathNow;
    }

}
