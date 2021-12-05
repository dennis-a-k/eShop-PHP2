<?php

abstract class Controller
{
    /**
     * Генерация базового шаблона (Метод отрисовки страницы)
     */
    protected abstract function render();
    /**
     * Метод с общими данными для страницы (к примеру футер или название сайта итд) вместо конструкотра
     */
    protected abstract function before();

    /**
     * Метод сбора данных и отрисовки страницы
     */
    public function request($path, $get = '')
    {
        $this->before();
        $this->$path();
        $this->render();
    }

    /**
     * выводит 1 если передан Гет параметр
     */
    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    /**
     * выводит 1 если передан Пост параметр
     */
    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Генерация HTML в строку (Шаблонизатор Twig)
     */
    protected function template($layouts, $vars = [])
    {
        try {
            $loader = new \Twig\Loader\FilesystemLoader('layouts');
            $twig = new \Twig\Environment($loader);
            //Доступ к сессии
            $twig->addGlobal('session', $_SESSION);

            echo $twig->render($layouts, $vars);
        } catch (Exception $e) {
            die ('Ошибка при создании шаблонизатора: ' . $e->getMessage());
        }
    }

    /**
     * Если вызвали метода которого нет, то завершаем работу
     */
    public function __call($name, $params)
    {
        header('location: index.php');
    }
}
