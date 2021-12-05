<?php

class Auth
{
    public function login($email, $password, $remember, $salt)
    {
        try {
            //подключаемся к базе с пользователями и проверяем есть ли пользователь с такой почтой и паролем
            $pass = $salt . md5($password) . $salt;
            $sql = "SELECT * FROM users WHERE `email`=:email AND `password`=:pass";
            $markers = [
                ':email' => $email,
                ':pass' => $pass
            ];

            $user = DB::selectRow($sql, $markers);
            
            if (!empty($user)) {
                $_SESSION['user']['role'] = $user['role'];
                $_SESSION['user']['id'] = $user['id'];
                setcookie('user[email]', $email, time() + 3600, '/');
                setcookie('user[password]', $password, time() + 3600, '/');
                
                header('Location: /?path=login');
            }
            $message = 'error';
            return $message;

        } catch (PDOException $e) {
            die ('Ошибка в авторизации: ' . $e->getMessage());
        }
    }

    public function registration($name, $email, $password, $salt)
    {
        try {
            $sql = "SELECT * FROM users WHERE `email`='$email'";
            $result = DB::selectRow($sql);

            if (!($result > 0)) {
                //шифруем пароль
                $pass = $salt . md5($password) . $salt;
                //заносим данные в таблицу пользователей
                $sql = "INSERT INTO users(`name`, `email`, `password`) VALUES (:name, :email, :pass)";
                $markers = [
                    ':name' => $name,
                    ':email' => $email,
                    ':pass' => $pass
                ];

                DB::insert($sql, $markers);

                setcookie('user[name]', $name, time() + 3600, '/layouts/auth/registration/');
                setcookie('user[email]', $email, time() + 3600, '/layouts/auth/');
                setcookie('user[password]', $password, time() + 3600, '/layouts/auth/');
                $message = 'success';
                return $message;
            }
            $message = 'error';
            return $message;
                     
        } catch (PDOException $e) {
            die ('Ошибка в регистрации: ' . $e->getMessage());
        }
    }
}
