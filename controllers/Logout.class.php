<?php

class Logout extends Base
{
    /**
     * Метод выхода пользователя с сайта
     */
    public function logout()
    {
        if ($this->isGet()){
            unset($_SESSION['user']);
            session_destroy();
            header('Location: /?path=login');
            exit;
        }
    }
}
