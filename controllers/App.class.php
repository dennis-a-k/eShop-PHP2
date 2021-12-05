<?php
/* Файл-роутер */

class App
{
    public static function init()
    {
        // Проверяем существует ли массив Сервер и массив Гет
        if (isset($_SERVER) && isset($_GET)) {
            // Проверяем есть-ли гет параметр path и если есть, то вставляем его и передаем. если нет, то передаем пустую строку
            self::web(isset($_GET['path']) ? $_GET['path'] : '');
        }
    }

    //Пример - eShop.ru/index.php?path=good/id/5

    /**
     * Метод - маршрутизатор
     */
    protected static function web($url)
    {
        // Получаем гет параметр или пустую строку и создаём массив данных разделёнными / при помощи explode()
        //Если передали ?path=good/id/5, то получится ['good', 'id', 5]
        $path = explode('/', $url);
        
        //Если массив под индексом ноль не пустой, то записываем это значение в переменную $controllerName ($controllerName = good)
        //И делаем первую букву good заглавной при помощи ucfirst()
        if (!empty($path[0])) {
            $controllerName = ucfirst($path[0]);
            $controller = new $controllerName;
            if (isset($path[2]) && is_numeric($path[2])) $_GET['id'] = $path[2];
            if (isset($path[2]) && is_string($path[2])) $_GET['id'] = $path[2];
            if (isset($path[1]) && is_string($path[1])) $_GET['value'] = $path[1];
            $controller->request($path[0]);
        } else {
            $path[0] = 'index';
            $controllerName = ucfirst($path[0]);
            $controller = new $controllerName;
            $controller->request($path[0]);
        }
    }
}
