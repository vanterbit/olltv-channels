<?php

/**
 * Проверяем нужно ли запускать процесс збора данных или подключим кэш
 *
 * @author Vanterbit
 */
class statusCacheClass {

     /**
     * Проверяем как давно обновлялся файл-метка для кэша
     * 
     * @param string $fileTime - файл-метка для кэша по которому смотрим время изменения
     * 
     * @param time $timeUpdateCache - время четез которое стоить обновить кэш
     *
     * @return boolean  -  если обновлять не нужно true
     */
    public function getTimeCache($fileTime, $timeUpdateCache) {
        
        
        //если нет файла по котрому смотрим время, то создаем его
        if (!file_exists($fileTime)) {
            fopen($fileTime, 'w');
            touch($fileTime, time() - ($timeUpdateCache + 5)); // меняем время создания файла 
        }
        
        $now_date = date("d-m-Y H:i:s");
        $updateFiles = date("d-m-Y H:i:s", filemtime($fileTime));
        $timeResult = floor((strtotime($now_date) - strtotime($updateFiles)));


        
        if($timeResult > $timeUpdateCache){
            return true;
        }else{
            return false;
        }
    }

}
