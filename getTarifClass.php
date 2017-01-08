<?php

/**
 * Определяем тариф
 *
 *
 * @author Vanterbit
 */
class getTarifClass {
   
/**
 * Формируем путь в зависимомти от тарифа куда будем сохранять данные
 * 
 * @param int $tarif - определитель тарифа
 *
 * @return string  -  возвращаем путь к папке тарифа
 *
 * @author Vanterbit
 */    
public function getTarif($tarif){
    
    switch ($tarif) {
        case 2:
            $pathTarif = '/cache/start/';
            break;
        case 3:
            $pathTarif = '/cache/optimal/';
            break;
        case 4:
            $pathTarif = '/cache/premium/';
            break;
    }
    return $pathTarif;
}

}
