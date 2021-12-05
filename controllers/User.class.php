<?php

class User extends Base
{
    /**
     * Метод вывода пользователя из БД на страницу
     */
    public function user()
    {
        $this->content = '/pages/user.html';

        $id = (!empty($_GET['id'])) ? (int)$_GET['id'] : '';
        $name = (!empty($_POST['name'])) ? trim(strip_tags($_POST['name'])) : '';
        $email = (!empty($_POST['email'])) ? trim(strip_tags($_POST['email'])) : '';
        $password = (!empty($_POST['password'])) ? trim(strip_tags($_POST['password'])) : '';

        if (isset($_SESSION['user'])) {
            $id = (int)$_SESSION['user']['id'];

            $user = new Profile;
            $this->data = $user->getUser($id);
            $this->data['orders'] = $user->getOrders($this->data['email']);
            $this->title .= $this->data['name'];
        }

        if (isset($_GET['value']) && $_GET['value'] == 'id'){
            if ($this->isPost()){
                if (isset($_POST['edit'])) {
                    $user = new Profile;
                    $user->editUser($id, $name, $email, $password, SALT);
                    header('Location: ?path=user');
                }
            }
        }
    }
}
