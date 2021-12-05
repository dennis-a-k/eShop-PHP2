<?php

class Login extends Base
{
     /**
     * Метод авторизации пользователя
     */
    public function login()
    {
        $this->title .= 'Вход на сайт';
        $this->content = '/pages/login.html';

        if ($this->isPost()) {
            $email = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : '';
            $password = (!empty($_POST['password'])) ? trim(strip_tags($_POST['password'])) : '';
            $remember = (!empty($_POST['remember'])) ? trim(strip_tags($_POST['remember'])) : '';

            $login = new Auth;
            $this->data = $login->login($email, $password, $remember, SALT);
        }
    }
}
