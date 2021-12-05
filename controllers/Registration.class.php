<?php

class Registration extends Base
{
    /**
     * Метод регистрации нового пользователя
     */
    public function registration()
    {
        $this->title .= 'Регистрация';
        $this->content = '/pages/registration.html';

        if ($this->isPost()) {
            $name = (!empty($_POST['name'])) ? trim(strip_tags($_POST['name'])) : '';
            $email = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : '';
            $password = (!empty($_POST['password'])) ? trim(strip_tags($_POST['password'])) : '';

            $registration = new Auth;
            $this->data = $registration->registration($name, $email, $password, SALT);
        }
    }
}
